<?php

class NewsHolder extends Page
{

    private static $db = array(
        'ShowShare' => 'Boolean',
        'ShowFacebook' => 'Boolean',
        'ShowTwitter' => 'Boolean',
        'ShowGoogle' => 'Boolean',
        'ThumbnailHeight' => 'Int',
        'ThumbnailWidth' => 'Int',
        'NewsExcerptsPerPage' => 'Int'
    );

    private static $has_one = array(
        'DefaultPhoto' => 'Image'
    );

    private static $has_many = array(
        'NewsCategories' => 'NewsCategory',
        'NewsAuthors' => 'NewsAuthor'
    );

    private static $extensions = array(
        'Lumberjack'
    );

    private static $defaults = array(
        'ThumbnailWidth' => '140',
        'ThumbnailHeight' => '140',
        'NewsExcerptsPerPage' => '15'
    );

    private static $allowed_children = array('NewsPage');
    private static $icon = 'basicnews/images/newsholder';

    public function getCMSFields()
    {
        $imagefield = UploadField::create('DefaultPhoto')->setTitle('Default Photo')->setDescription('To be used on individual news pages if feature photo is empty. 2MB max size');
        $imagefield->folderName = 'News';
        $imagefield->getValidator()->allowedExtensions = array('jpg','jpeg','gif','png');
        $imagefield->getValidator()->setAllowedMaxFileSize('2097152'); // 2 MB in bytes
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Categories', GridField::create(
            'NewsCategories',
            'Category',
            $this->NewsCategories(),
            GridFieldConfig_RecordEditor::create(50)
        ));
        $fields->addFieldToTab('Root.Authors', GridField::create(
            'NewsAuthors',
            'Author',
            $this->NewsAuthors(),
            GridFieldConfig_RecordEditor::create(50)
        ));
        $fields->addFieldsToTab('Root.Config', array(
            HeaderField::create('ImageHeader')
                ->setTitle('Default Featured Photo Options'),
            TextField::create('ThumbnailHeight')
                ->setTitle('Feature Photo Height'),
            TextField::create('ThumbnailWidth')
                ->setTitle('Feature Photo Width'),
            $imagefield,
            HeaderField::create('NewsExcerptsHeader')
                ->setTitle('Excerpt Options'),
            NumericField::create('NewsExcerptsPerPage')
                ->setTitle('News Excerpts Per Page'),
            HeaderField::create('ShareIcons')
                ->setTitle('Share Icon Options'),
            CheckboxField::create('ShowShare')
                ->setTitle('Show Share Icons'),
            DisplayLogicWrapper::create(
                CheckboxField::create('ShowFacebook')
                    ->setTitle('Show Facebook Icon'),
                CheckboxField::create('ShowTwitter')
                    ->setTitle('Show Twitter Icon'),
                CheckboxField::create('ShowGoogle')
                    ->setTitle('Show Google Icon')
            )->displayIf('ShowShare')->isChecked()->end()
        ));
        return $fields;
    }

    public function getLumberjackTitle()
    {
        return 'Posts';
    }

}

class NewsHolder_Controller extends Page_Controller
{

    private static $allowed_actions = array(
        'category',
        'author',
        'rss'
    );

    public function init()
    {
        parent::init();
        Requirements::CSS("news/css/news.css");
        RSSFeed::linkToFeed($this->Link() . "rss", $this->SiteConfig->Title . " News");
    }

    public function rss()
    {
        $rss = new RSSFeed(
            $this->GetNewsPages(),
            $this->Link(),
            $this->SiteConfig->Title . " News", "RSS feed for the news from " . $this->SiteConfig->Title
        );
        return $rss->outputToBrowser();
    }

    public function getCategory()
    {
        $Params = $this->getURLParams();
        if(is_numeric($Params['ID']) && $Category = NewsCategory::get()->byID((int)$Params['ID'])) {
            return $Category;
        }
    }

    public function category()
    {
        if($Category = $this->getCategory()) {
            $Data = array(
                'NewsCategory' => $Category
            );
            return $this->customise(array('NewsCategory' => $Category))->renderWith(array('NewsCategory', 'Page'));
        } else {
            return $this->httpError(404, 'Sorry that news category could not be found');
        }
    }

    public function getAuthor()
    {
        $Params = $this->getURLParams();
        if(is_numeric($Params['ID']) && $Author = NewsAuthor::get()->byID((int)$Params['ID'])) {
            return $Author;
        }
    }

    public function author()
    {
        if($Author = $this->getAuthor()) {
            $Data = array(
                'NewsAuthor' => $Author
            );
            return $this->customise(array('NewsAuthor' => $Author))->renderWith(array('NewsAuthor', 'Page'));
        } else {
            return $this->httpError(404, 'Sorry that news author could not be found');
        }
    }

    public function GetNewsPages()
    {
        return NewsPage::get()->filter('ParentID', $this->ID)->sort('Date DESC');
    }

    public function PaginatedNews()
    {
        if ($this->NewsExcerptsPerPage) {
            $NewsExcerptsPerPage = $this->NewsExcerptsPerPage;
        } else {
            $NewsExcerptsPerPage = '15';
        }
        $PaginatedNews = new PaginatedList($this->GetNewsPages(), $this->request);
        $PaginatedNews->setPageLength($NewsExcerptsPerPage);
        return $PaginatedNews;
    }

    public function NewsCategories()
    {
        $CategoriesFiltered = new ArrayList();
        $AllCategories = $this->getComponents('NewsCategories');
        if ($AllCategories) {
            foreach ($AllCategories as $Category) {
                if ($Category->GetNewsPages()->Count() > 0) {
                    $CategoriesFiltered->push($Category);
                }
            }
        }
        return $CategoriesFiltered;
    }

}

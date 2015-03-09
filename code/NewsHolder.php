<?php 
 
class NewsHolder extends Page {

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
    'NewsCategories' => 'NewsCategory'
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

	public function getCMSFields() {
    $imagefield = UploadField::create('DefaultPhoto')->setTitle('Default Photo')->setDescription('To be used on individual news pages if feature photo is empty. 2MB max size');
    $imagefield->folderName = 'News'; 
    $imagefield->getValidator()->allowedExtensions = array('jpg','jpeg','gif','png');
    $imagefield->getValidator()->setAllowedMaxFileSize('2097152'); // 2 MB in bytes
	  $fields = parent::getCMSFields();
    $NewsCategoriesGridField = new GridField(
      'NewsCategories',
      'Category',
      $this->NewsCategories(),
      GridFieldConfig::create()
        ->addComponent(new GridFieldToolbarHeader())
        ->addComponent(new GridFieldAddNewButton('toolbar-header-right'))
        ->addComponent(new GridFieldSortableHeader())
        ->addComponent(new GridFieldDataColumns())
        ->addComponent(new GridFieldPaginator(50))
        ->addComponent(new GridFieldEditButton())
        ->addComponent(new GridFieldDeleteAction())
        ->addComponent(new GridFieldDetailForm())
        ->addComponent(new GridFieldFilterHeader())
    );
    $fields->addFieldToTab("Root.Categories", $NewsCategoriesGridField);
	 	$fields->addFieldsToTab('Root.Config', array(
	    HeaderField::create('ImageHeader')->setTitle('Default Featured Photo Options'),
	    TextField::create('ThumbnailHeight')->setTitle('Feature Photo Height'),
	    TextField::create('ThumbnailWidth')->setTitle('Feature Photo Width'),
	    $imagefield,
      HeaderField::create('NewsExcerptsHeader')->setTitle('Excerpt Options'),
      NumericField::create('NewsExcerptsPerPage')->setTitle('News Excerpts Per Page'),
	    HeaderField::create('ShareIcons')->setTitle('Share Icon Options'),
	    CheckboxField::create('ShowShare')->setTitle('Show Share Icons'),
	    $showfacebook = CheckboxField::create('ShowFacebook')->setTitle('Show Facebook Icon'),
	    $showtwitter = CheckboxField::create('ShowTwitter')->setTitle('Show Twitter Icon'),
	    $showgoogle = CheckboxField::create('ShowGoogle')->setTitle('Show Google Icon')
    ));  
	  $showfacebook->displayIf('ShowShare')->isChecked();
	  $showtwitter->displayIf('ShowShare')->isChecked();
	  $showgoogle->displayIf('ShowShare')->isChecked();
	  return $fields;
  }
 
}
 
class NewsHolder_Controller extends Page_Controller {

  private static $allowed_actions = array(
    'category',
    'rss'
  );

	public function init() {
    parent::init();
    Requirements::CSS("news/css/news.css");
    RSSFeed::linkToFeed($this->Link() . "rss", $this->SiteConfig->Title . " News");
  }

  public function rss() {
    $rss = new RSSFeed(
      $this->GetNewsPages(), 
      $this->Link(), 
      $this->SiteConfig->Title . " News", 
      "RSS feed for the news from " . $this->SiteConfig->Title
    );
    return $rss->outputToBrowser();
  }
     
  public function getCategory() {
    $Params = $this->getURLParams();
    if(is_numeric($Params['ID']) && $Category = NewsCategory::get()->byID((int)$Params['ID'])) {         
      return $Category;
    }
  }
  
  public function category() {       
    if($Category = $this->getCategory()) {
      $Data = array(
        'NewsCategory' => $Category
      );
      return $this->customise(array('NewsCategory' => $Category))->renderWith(array('NewsCategory', 'Page'));
    }
    else {
      return $this->httpError(404, 'Sorry that news category could not be found');
    }
  }

	public function GetNewsPages() {
		return NewsPage::get()->filter('ParentID',$this->ID)->sort('Date DESC');
	}

	public function PaginatedNews() {
    if($this->NewsExcerptsPerPage) 
      $NewsExcerptsPerPage = $this->NewsExcerptsPerPage;
    else
      $NewsExcerptsPerPage = '15';
	  $PaginatedNews = new PaginatedList($this->GetNewsPages(), $this->request);
	  $PaginatedNews->setPageLength($NewsExcerptsPerPage);
	  return $PaginatedNews;
	}
	
}
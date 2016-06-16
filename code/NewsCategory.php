<?php

class NewsCategory extends DataObject
{

    private static $db = array(
        'Title' => 'Text',
        'Description' => 'HTMLText'
    );

    private static $has_one = array(
        'NewsHolder' => 'NewsHolder'
    );

    private static $belongs_many_many = array(
        'NewsPages' => 'NewsPage'
    );

    private static $summary_fields = array(
        'Title' => 'Title',
        'DescriptionExcerpt' => 'Description'
    );

    public function getCMSFields()
    {
        return new FieldList(
            TextField::create('Title')->setTitle('Category Name'),
            HTMLEditorField::create('Description')->setTitle('Category Description')
        );
    }

    public function Link()
    {
        return Controller::join_links($this->NewsHolder()->URLSegment, 'category', $this->ID);
    }

    public function canCreate($Member = null)
    {
        return true;
    }
    public function canEdit($Member = null)
    {
        return true;
    }
    public function canView($Member = null)
    {
        return true;
    }
    public function canDelete($Member = null)
    {
        return true;
    }

    public function LinkingMode()
    {
        if (Controller::curr()->ClassName == 'NewsHolder') {
            if (Controller::curr()->getAction() == 'category' && $Category = Controller::curr()->getCategory()) {
                return ($Category->ID == $this->ID) ? 'current' : 'link';
            }
        }
    }

    public function getNewsPages()
    {
        return $this->getManyManyComponents('NewsPages');
    }

    public function PaginatedNews()
    {
        if (Controller::curr()->ClassName == 'NewsHolder') {
            $NewsExcerptsPerPage = Controller::curr()->NewsExcerptsPerPage;
        }
        if (Controller::curr()->ClassName == 'NewsPage') {
            $NewsExcerptsPerPage = Controller::curr()->Parent->NewsExcerptsPerPage;
        }
        if ($NewsExcerptsPerPage == '0') {
            $NewsExcerptsPerPage = '15';
        }
        $PaginatedNews = new PaginatedList($this->getNewsPages(), Controller::curr()->request);
        $PaginatedNews->setPageLength($NewsExcerptsPerPage);
        return $PaginatedNews;
    }

    public function DescriptionExcerpt($length = 300)
    {
        $text = strip_tags($this->Description);
        $length = abs((int)$length);
        if (strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return $text;
    }
}

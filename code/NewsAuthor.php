<?php

class NewsAuthor extends DataObject
{

    private static $db = array (
        'Prefix' => 'Varchar',
        'FirstName' => 'Varchar',
        'MiddleName' => 'Varchar',
        'LastName' => 'Varchar',
        'Suffix' => 'Varchar'
    );

    private static $has_one = array (
        'NewsHolder' => 'NewsHolder'
    );

    private static $belongs_many_many = array (
        'NewsPages' => 'NewsPage'
    );

    private static $summary_fields = array(
        'FirstName' => 'FirstName',
        'LastName' => 'LastName',
    );

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

    public function canPublish($Member = null)
    {
        return true;
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Prefix')->setTitle('Prefix (ie. Dr, Mr, Ms)'),
            TextField::create('FirstName')->setTitle('First Name'),
            TextField::create('MiddleName')->setTitle('Middle Name'),
            TextField::create('LastName')->setTitle('Last Name'),
            TextField::create('Suffix')->setTitle('Suffix (ie. Jr., Ph.D.)'),
        ));
        return $fields;
    }

    public function FullName()
    {
        $prefix = ($this->Prefix) ? $this->Prefix . " " : null;
        $middlename = ($this->MiddleName) ? $this->MiddleName . " " : null;
        $suffix = ($this->Suffix) ? ", " . $this->Suffix : null;
        return $prefix . $this->FirstName . " " . $middlename . $this->LastName . $suffix;
    }

    public function getTitle() {
        return $this->FullName();
    }

    public function Link()
    {
        return Controller::join_links($this->NewsHolder()->URLSegment, 'author', $this->ID);
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

}

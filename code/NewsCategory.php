<?php

class NewsCategory extends DataObject {

	private static $db = array (
		'Title' => 'Text',
		'Description' => 'HTMLText'
	);
	
	private static $belongs_many_many = array (
		'NewsPages' => 'NewsPage'
	);

	private static $summary_fields = array( 
      	'Title' => 'Category Name',
      	'DescriptionExcerpt' => 'Description'
   	);
	
	public function getCMSFields() {
		return new FieldList(
			TextField::create('Title')->setTitle('Category Name'),
			HTMLEditorField::create('Description')->setTitle('Category Description')
		);
	}
	
	public function Link() {
		if(Controller::curr()->ClassName == 'NewsHolder') {
			return Controller::curr()->Link() . "category/" . $this->ID;
		}
		if(Controller::curr()->ClassName == 'NewsPage') {
			return Controller::curr()->Parent()->Link() . "category/" . $this->ID;
		}
	}

	function canCreate($Member = null) { return true; }
	function canEdit($Member = null) { return true; }
	function canView($Member = null) { return true; }
	function canDelete($Member = null) { return true; }
	
	public function LinkingMode() {
        if(Controller::curr()->ClassName == 'NewsHolder') {
			if(Controller::curr()->getAction() == 'category' && $DJ = Controller::curr()->getCategory()) {
				return ($DJ->ID == $this->ID) ? 'current' : 'link';
			}
		}
    }

    public function GetNewsPages() {
    	return $this->getManyManyComponents("NewsPages");
  	}
   
  	public function PaginatedNews() {
     	$PaginatedNews = new PaginatedList($this->GetNewsPages(), Controller::curr()->request);
      	$PaginatedNews->setPageLength('15');
      	return $PaginatedNews;
   	}

   	public function DescriptionExcerpt($length = 300) {
	   	$text = strip_tags($this->Description);
		$length = abs((int)$length);
		if(strlen($text) > $length) {
			$text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
		}
		return $text;
	}

}

?>
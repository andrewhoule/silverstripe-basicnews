<?php 
 
class NewsHolder extends Page {

	private static $has_one = array(
        'DefaultPhoto' => 'Image'
    );
	
   	private static $allowed_children = array("NewsPage" );
	private static $icon = "../images/newsholder";

	public function getCMSFields() {
        $imgfield = UploadField::create('DefaultPhoto')->setTitle("Default Featured Photo (Used on individual news pages if feature photo is empty)");
        $imgfield->folderName = "News"; 
        $imgfield->getValidator()->allowedExtensions = array('jpg','jpeg','gif','png');
	    $fields = parent::getCMSFields();
	    if( Member::currentUser()->inGroups(array('administrators')) ) {
	    	$fields->addFieldToTab('Root.FeaturePhoto', $imgfield);
	    }
	    return $fields;
    }
 
}
 
class NewsHolder_Controller extends Page_Controller {

	public function init() {
    	parent::init();
      	Requirements::CSS("news/css/news.css");
   	}

	function GetNewsPages() {
		return NewsPage::get()->filter("ParentID","$this->ID")->sort("Date","DESC");
	}

	public function PaginatedNews() {
	  	$PaginatedNews = new PaginatedList($this->GetNewsPages(), $this->request);
	  	$PaginatedNews->setPageLength('15');
	  	return $PaginatedNews;
	}
	
}

?>
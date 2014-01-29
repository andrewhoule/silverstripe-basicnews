<?php 
 
class NewsHolder extends Page {

	private static $db = array(
		'ShowShare' => 'Boolean',
		'ShowFacebook' => 'Boolean',
		'ShowTwitter' => 'Boolean',
		'ShowGoogle' => 'Boolean'
	);

	private static $has_one = array(
        'DefaultPhoto' => 'Image'
    );
	
   	private static $allowed_children = array("NewsPage" );
	private static $icon = "basicnews/images/newsholder";

	public function getCMSFields() {
        $imagefield = UploadField::create('DefaultPhoto')->setTitle("Photo to be used on individual news pages if feature photo is empty");
        $imagefield->folderName = "News"; 
        $imagefield->getValidator()->allowedExtensions = array('jpg','jpeg','gif','png');
	    $fields = parent::getCMSFields();
	   	$fields->addFieldsToTab("Root.Config", array(
	    	HeaderField::create("ImageHeader","Default Featured Photo"),
	    	$imagefield,
	    	HeaderField::create("ShareIcons","Share Icons"),
	    	CheckboxField::create("ShowShare")->setTitle("Show Share Icons"),
	    	$showfacebook = CheckboxField::create("ShowFacebook")->setTitle("Show Facebook Icon"),
	    	$showtwitter = CheckboxField::create("ShowTwitter")->setTitle("Show Twitter Icon"),
	    	$showgoogle = CheckboxField::create("ShowGoogle")->setTitle("Show Google Icon")
	    ));  
	    $showfacebook->displayIf("ShowShare")->isChecked();
	    $showtwitter->displayIf("ShowShare")->isChecked();
	    $showgoogle->displayIf("ShowShare")->isChecked();
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
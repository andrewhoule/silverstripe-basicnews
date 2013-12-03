<?php 
 
class NewsPage extends Page {

	private static $db = array(
        "Date" => "Date",
        "Author" => "Text"
    );

    private static $has_one = array(
        'Photo' => 'Image'
    );

    private static $defaults = array (
        "Date" => "now"
    );
	
   	private static $icon = "basicnews/images/newspage";

   	function getCMSFields() {
        $dateField = DateField::create("Date")->setTitle("Article Date (for example: 12/31/2010)");
        $dateField->setConfig('showcalendar', true);
        $dateField->setConfig('dateformat', 'MM/dd/YYYY');
        $imgfield = UploadField::create('Photo')->setTitle("Featured Photo");
        $imgfield->folderName = "News"; 
        $imgfield->getValidator()->allowedExtensions = array('jpg','jpeg','gif','png');
	    $fields = parent::getCMSFields();
	    $fields->addFieldToTab('Root.Main', $dateField, 'Content');
	    $fields->addFieldToTab('Root.Main', TextField::create("Author")->setTitle("Author Name"), 'Content');
        $fields->addFieldToTab('Root.Main', $imgfield, 'Content');
	    return $fields;
    }

    public function FeaturePhotoCropped($x=140,$y=140) {
        if($this->Photo()->exists()) {
            return $this->Photo()->CroppedImage($x,$y);
        }
        elseif($this->Parent()->getComponent('DefaultPhoto')->exists()) {
            return $this->Parent()->getComponent('DefaultPhoto')->CroppedImage($x,$y);
        }
        else {
            return false;
        }
    }

    public function NoFeaturePhoto() {
        if($this->Photo()->exists() || $this->Parent()->getComponent('DefaultPhoto')->exists()) {
            return false;
        }
        else 
            return true; 
    }

    public function PhotoSized($x=400) {
        return $this->Photo()->setWidth($x);
    }

    public function ContentExcerpt($length = 300) {
        $text = strip_tags($this->Content);
        $length = abs((int)$length);
        if(strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return $text;
    }

    public function NiceDate() {
        return $this->obj('Date')->Format("F j, Y");
    }
 
}
 
class NewsPage_Controller extends Page_Controller {

	public function init() {
    	parent::init();
      	Requirements::CSS("news/css/news.css");
   	}

	public function PrevNextPage($Mode = 'next') {
        if($Mode == 'next'){
            $Where = "ParentID = ($this->ParentID) AND Sort > ($this->Sort)";
            $Sort = "Sort ASC";
        }
        elseif($Mode == 'prev'){
            $Where = "ParentID = ($this->ParentID) AND Sort < ($this->Sort)";
            $Sort = "Sort DESC";
        }
        else {
            return false;
        }
        return DataObject::get("SiteTree", $Where, $Sort, null, 1);
     }

    public function hasSiblings() {
        if($this->PrevNextPage('next') || $this->PrevNextPage('prev'))
            return true;
        else
            return false;
    } 
	
}

?>
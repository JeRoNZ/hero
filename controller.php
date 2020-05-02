<?php namespace Application\Block\Hero;

defined("C5_EXECUTE") or die("Access Denied.");

use Concrete\Core\Block\BlockController;
use Concrete\Core\Editor\LinkAbstractor;
use Core;
use File;
use Page;
use Permissions;
use URL;

class Controller extends BlockController
{
    public $btFieldsRequired = [];
    protected $btExportFileColumns = ['image', 'file_1'];
    protected $btExportPageColumns = ['page'];
    protected $btTable = 'btHero';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;
    protected $btIgnorePageThemeGridFrameworkContainer = false;
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $pkg = false;
    
    public function getBlockTypeDescription()
    {
        return t("Hero");
    }

    public function getBlockTypeName()
    {
        return t("Hero");
    }

    public function getSearchableContent()
    {
        $content = [];
        $content[] = $this->title;
        $content[] = $this->blurb;
        return implode(" ", $content);
    }

    public function view()
    {
        
        if ($this->image && ($f = File::getByID($this->image)) && is_object($f)) {
            $this->set("image", $f);
        } else {
            $this->set("image", false);
        }
        $this->set('blurb', LinkAbstractor::translateFrom($this->blurb));
        $file_1_id = (int)$this->file_1;
        $this->file_1 = false;
        if ($file_1_id > 0 && ($file_1_file = File::getByID($file_1_id)) && is_object($file_1_file)) {
            $fp = new Permissions($file_1_file);
	        if ($fp->canViewFile()) {
	            $urls = ['relative' => $file_1_file->getRelativePath()];
		        if (($c = Page::getCurrentPage()) && $c instanceof Page) {
			        $urls['download'] = URL::to('/download_file', $file_1_id, $c->getCollectionID());
		        }
		        $file_1_file->urls = $urls;
		        $this->file_1 = $file_1_file;
            }
        }
        $this->set("file_1", $this->file_1);
    }

    public function add()
    {
        $this->addEdit();
    }

    public function edit()
    {
        $this->addEdit();
        
        $this->set('blurb', LinkAbstractor::translateFromEditMode($this->blurb));
    }

    protected function addEdit()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('redactor');
        $this->set('btFieldsRequired', $this->btFieldsRequired);
        $this->set('identifier_getString', Core::make('helper/validation/identifier')->getString(18));
		$this->requireAsset('core/colorpicker');
    }

    public function save($args)
    {
        $args['blurb'] = LinkAbstractor::translateTo($args['blurb']);
        parent::save($args);
    }

    public function validate($args)
    {
        $e = Core::make("helper/validation/error");
        if (in_array("image", $this->btFieldsRequired) && (trim($args["image"]) == "" || !is_object(File::getByID($args["image"])))) {
            $e->add(t("The %s field is required.", t("Image")));
        }
        if (in_array("title", $this->btFieldsRequired) && (trim($args["title"]) == "")) {
            $e->add(t("The %s field is required.", t("Title")));
        }
        if (in_array("blurb", $this->btFieldsRequired) && (trim($args["blurb"]) == "")) {
            $e->add(t("The %s field is required.", t("Blurb")));
        }
        if (in_array("page", $this->btFieldsRequired) && (trim($args["page"]) == "" || $args["page"] == "0" || (($page = Page::getByID($args["page"])) && $page->error !== false))) {
            $e->add(t("The %s field is required.", t("Page Link")));
        }
        if (in_array("file_1", $this->btFieldsRequired) && (!isset($args["file_1"]) || trim($args["file_1"]) == "" || !is_object(File::getByID($args["file_1"])))) {
            $e->add(t("The %s field is required.", t("File")));
        }
        return $e;
    }

    public function composer()
    {
        $this->edit();
    }
}

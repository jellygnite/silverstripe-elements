<?php

namespace Jellygnite\Elements\Model;
use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Controllers\CustomElementController;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Assets\File;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\View\Requirements;
use SilverStripe\Dev\Debug;

class ElementSidebarContent extends BaseElement
{
    private static $icon = 'font-icon-block-layout-7';

    private static $db = [
        'Content' => 'HTMLText',
        'Sidebar' => 'HTMLText'
    ];
	
    private static $has_one = [];
    
	private static $owns = [];
		
    private static $table_name = 'ElementSidebarContent';
	
	private static $styles = [];
	
	
    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder
	
//    private static $controller_template = "ElementHolder";

    private static $singular_name = 'Sidebar Content Block';

    private static $plural_name = 'Sidebar Content Blocks';

    private static $description = 'Content block with adjacent sidebar content block';
	
	private static $inline_editable = false;
	
	private static $defaults = array (
		'ShowTitle' => '1'
	);
    /**
     * Re-title the HTML field to Content
     *
     * {@inheritDoc}
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {			
			
        });

        return parent::getCMSFields();
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Content/Sidebar');
    }

}

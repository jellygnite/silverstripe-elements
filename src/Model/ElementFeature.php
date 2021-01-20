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

class ElementFeature extends BaseElement
{
    private static $icon = 'font-icon-block-promo-3';

    private static $db = [
        'Content' => 'HTMLText'
    ];
    /**
     * @var array
     */
    private static $has_one = [
        'Image' => File::class,
        'ElementLink' => Link::class,
    ];
    
	private static $owns = [
        'Image'
    ];
		
    private static $table_name = 'ElementFeature';
	
	private static $styles = [];

	private static $extra_styles = [
		'ImageAlignment' => [
			'Title' => 'Image Alignment',
			'Description' => 'Set the position of the image for device widths 640px and higher.',
			'Location' => 'image',
			'After' => 'Image',
			'Tab' => 'Main',
			'Styles' => [
				'Left Align Image' => '',
				'Right Align Image' => 'uk-flex-last@s',
			]
		],	
	];
	
    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder
	
    private static $controller_template = "ElementHolder";

    private static $singular_name = 'Feature Block';

    private static $plural_name = 'Feature Blocks';

    private static $description = 'Featured item containing HTML text block next to image';
	
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
			$fields->replaceField(
                'ElementLinkID',
                LinkField::create('ElementLinkID', $this->fieldLabel('ElementLinkID'))
                    ->setDescription(_t(__CLASS__.'.LinkDescription', 'Optional. Add a call to action link.'))
            );
			$fields->dataFieldByName('Image')
				->setFolderName('images/elements')
				->setAllowedFileCategories('image/supported','image/unsupported'); 
			
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
        return _t(__CLASS__ . '.BlockType', 'Feature');
    }

}

<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Controllers\CustomElementController;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Bummzack\SortableFile\Forms\SortableUploadField;

use SilverStripe\Dev\Debug;

/**
 * Class ElementGallery
 * 
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Gallery()
 *
 * does not need ShowTitle
 */
class ElementImageGallery extends BaseElement {
	
	private static $cascade_duplicates = false;	
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-layout-5';

    /**
     * @return string
     */
    private static $singular_name = 'Image Gallery Element';

    /**
     * @return string
     */
    private static $plural_name = 'Image Gallery Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementImageGallery';

    /**
     * @var array
     */
    private static $styles = [];
	
	// allows us to store templates in this module folder
	private static $controller_class = CustomElementController::class;  


    /**
     * @var array
     */
    private static $db = [
        'Content' => 'HTMLText'
    ];

    /**
     * @var array
     */
	private static $many_many = [
		'Images' => Image::class
	];

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Images' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Images',
    ];

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

//        $labels['Content'] = _t(__CLASS__.'.ContentLabel', 'Intro');
        $labels['Gallery'] = _t(__CLASS__ . '.ImageGalleryLabel', 'Image Gallery');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            
            if ($this->ID) {
				$itemField = $fields->dataFieldByName('Images');
                $fields->removeByName('Images');
				$fields->dataFieldByName('Content')
	                ->setRows(8);
				
				
				$fields->addFieldToTab('Root.Main', 
				
					SortableUploadField::create(
						'Images', $this->fieldLabel('Images')
					)->setRightTitle('Supports bulk image uploads')
				);
            }
        });
		
		return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getImagesList()
    {
        return $this->Images()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Images()->count() == 1) {
            $label = ' item';
        } else {
            $label = ' items';
        }
        return DBField::create_field('HTMLText', $this->Images()->count() . $label)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'Image Gallery');
    }


}

<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Model\GalleryObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
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
class ElementGallery extends BaseElement {
	
	private static $cascade_duplicates = false;	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-layout-5';

    /**
     * @return string
     */
    private static $singular_name = 'Gallery Element';

    /**
     * @return string
     */
    private static $plural_name = 'Gallery Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementGallery';

    /**
     * @var array
     */
    private static $styles = [];

    /**
     * @var array
     */
    private static $db = [
        'Content' => 'HTMLText'
    ];

    /**
     * @var array
     */
    private static $many_many = array(
        'MediaItems' => GalleryObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'MediaItems' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'MediaItems',
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
        $labels['Gallery'] = _t(__CLASS__ . '.GalleryLabel', 'Gallery');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            
            if ($this->ID) {
                $itemField = $fields->dataFieldByName('MediaItems');
                $fields->removeByName('MediaItems');
                $config = $itemField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $itemField,
                ));
            }
        });
		
		return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getMediaItemsList()
    {
        return $this->MediaItems()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->MediaItems()->count() == 1) {
            $label = ' item';
        } else {
            $label = ' items';
        }
        return DBField::create_field('HTMLText', $this->MediaItems()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Media Gallery');
    }
	
}

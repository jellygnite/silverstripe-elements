<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Controllers\CustomElementController;
use Jellygnite\Elements\Model\PopupObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Dev\Debug;

/**
 * Class ElementPopups
 * @package Dynamic\Elements\Popups\Elements
 *
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Popups()
 */
class ElementPopups extends BaseElement {
	
	private static $cascade_duplicates = false;	
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-clone';

    /**
     * @return string
     */
    private static $singular_name = 'Popups Element';

    /**
     * @return string
     */
    private static $plural_name = 'Popups Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementPopups';
	
    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder
	
    private static $controller_template = 'ElementHolder_Popups';

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
        'Popups' => PopupObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Popups' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Popups',
    ];

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     * @var bool
     */
    private static $inline_editable = false;	
	
	private static $defaults = array (
		'ShowTitle' => '1'
	);

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Content'] = _t(__CLASS__.'.ContentLabel', 'Intro');
        $labels['Popups'] = _t(__CLASS__ . '.PopupsLabel', 'Popups');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setRows(5);

            if ($this->ID) {
                /** @var \SilverStripe\Forms\GridField\GridField $PopupField */
                $popupField = $fields->dataFieldByName('Popups');
                $fields->removeByName('Popups');
                $config = $popupField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $popupField,
                ));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getPopupList()
    {
        return $this->Popups()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Popups()->count() == 1) {
            $label = ' popup';
        } else {
            $label = ' popups';
        }
        return DBField::create_field('HTMLText', $this->Popups()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Popups');
    }


}

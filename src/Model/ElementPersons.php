<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Controllers\CustomElementController;
use Jellygnite\Elements\Model\PersonObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class ElementPersons
 * 
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Persons()
 */
class ElementPersons extends BaseElement {
	
	private static $cascade_duplicates = false;	
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-users';

    /**
     * @return string
     */
    private static $singular_name = 'Persons Element';

    /**
     * @return string
     */
    private static $plural_name = 'Persons Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementPersons';

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
    private static $many_many = array(
        'Persons' => PersonObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Persons' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Persons',
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
        $labels['Persons'] = _t(__CLASS__ . '.PersonsLabel', 'Persons');

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
                /** @var \SilverStripe\Forms\GridField\GridField $PersonField */
                $personField = $fields->dataFieldByName('Persons');
                $fields->removeByName('Persons');
                $config = $personField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $personField,
                ));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getPersonList()
    {
        return $this->Persons()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Persons()->count() == 1) {
            $label = ' person';
        } else {
            $label = ' persons';
        }
        return DBField::create_field('HTMLText', $this->Persons()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Persons');
    }


}

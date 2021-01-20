<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Model\AccordionObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class ElementAccordion
 * 
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Accordion()
 */
class ElementAccordion extends BaseElement
{
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-accordion';

    /**
     * @return string
     */
    private static $singular_name = 'Accordion Element';

    /**
     * @return string
     */
    private static $plural_name = 'Accordion Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementAccordion';

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
        'Accordions' => AccordionObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Accordions' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Accordions',
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
        $labels['Accordions'] = _t(__CLASS__ . '.AccordionsLabel', 'Accordions');

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
                /** @var \SilverStripe\Forms\GridField\GridField $AccordionField */
                $accordionField = $fields->dataFieldByName('Accordions');
                $fields->removeByName('Accordions');
                $config = $accordionField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $accordionField,
                ));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getAccordionList()
    {
        return $this->Accordions()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Accordions()->count() == 1) {
            $label = ' accordion';
        } else {
            $label = ' accordions';
        }
        return DBField::create_field('HTMLText', $this->Accordions()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Accordion');
    }

	public function duplicate($doWrite = true, $relations = null) {
		$object = parent::duplicate($doWrite, false);
		return $object;
	} 
}

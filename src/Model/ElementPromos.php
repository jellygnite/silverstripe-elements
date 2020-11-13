<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Controllers\CustomElementController;
use Jellygnite\Elements\Model\PromoObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Dev\Debug;

/**
 * Class ElementPromos
 * @package Jellygnite\Elements\Model\ElementPromos
 *
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Promos()
 */
class ElementPromos extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-layout-2';

    /**
     * @return string
     */
    private static $singular_name = 'Promos Element';

    /**
     * @return string
     */
    private static $plural_name = 'Promos Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementPromos';
	
    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder
	
    private static $controller_template = 'ElementHolder_Promos';

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
        'Promos' => PromoObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Promos',
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
        $labels['Promos'] = _t(__CLASS__ . '.PromosLabel', 'Promos');

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
                /** @var \SilverStripe\Forms\GridField\GridField $promoField */
                $promoField = $fields->dataFieldByName('Promos');
                $fields->removeByName('Promos');
                $config = $promoField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $promoField,
                ));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getPromoList()
    {
        return $this->Promos()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Promos()->count() == 1) {
            $label = ' promo';
        } else {
            $label = ' promos';
        }
        return DBField::create_field('HTMLText', $this->Promos()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Promos');
    }

}

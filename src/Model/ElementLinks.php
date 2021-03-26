<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Controllers\CustomElementController;
use Sheadawson\Linkable\Models\Link;
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
 * Class ElementLinks
 * 
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Links()
 *
 * does not need ShowTitle
 */
class ElementLinks extends BaseElement {
	
	private static $cascade_duplicates = false;	
	
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-link';

    /**
     * @return string
     */
    private static $singular_name = 'Links Element';

    /**
     * @return string
     */
    private static $plural_name = 'Links Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementLinks';

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
        'Links' => Link::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Links' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Links',
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

        $labels['Links'] = _t(__CLASS__ . '.LinksLabel', 'Links');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            if ($this->ID) {
                /** @var \SilverStripe\Forms\GridField\GridField $LinkField */
                $linkField = $fields->dataFieldByName('Links');
                $fields->removeByName('Links');
                $config = $linkField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $linkField,
                ));
            }
        });
		
		return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getLinksList()
    {
        return $this->Links()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Links()->count() == 1) {
            $label = ' link';
        } else {
            $label = ' links';
        }
        return DBField::create_field('HTMLText', $this->Links()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Links');
    }


}

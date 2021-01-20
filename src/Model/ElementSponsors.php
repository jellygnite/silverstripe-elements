<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Model\SponsorObject;
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
class ElementSponsors extends BaseElement
{
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-rocket';

    /**
     * @return string
     */
    private static $singular_name = 'Sponsors Element';

    /**
     * @return string
     */
    private static $plural_name = 'Sponsors Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementSponsors';

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
        'Sponsors' => SponsorObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Sponsors' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Sponsors',
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
        $labels['Sponsors'] = _t(__CLASS__ . '.SponsorsLabel', 'Sponsors');

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
                /** @var \SilverStripe\Forms\GridField\GridField $SponsorField */
                $personField = $fields->dataFieldByName('Sponsors');
                $fields->removeByName('Sponsors');
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
    public function getSponsorList()
    {
        return $this->Sponsors()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Sponsors()->count() == 1) {
            $label = ' sponsor';
        } else {
            $label = ' sponsors';
        }
        return DBField::create_field('HTMLText', $this->Sponsors()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Sponsors');
    }

	
	public function isCarousel() {
		return  ($this->Style == 'carousel');
	}

	public function duplicate($doWrite = true, $relations = null) {
		$object = parent::duplicate($doWrite, false);
		return $object;
	} 
}

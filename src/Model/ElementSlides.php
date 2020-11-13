<?php

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Models\BaseElement;
use Jellygnite\Elements\Model\SlideObject;
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
 * Class ElementSlides
 * 
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Slides()
 *
 * does not need ShowTitle
 */
class ElementSlides extends BaseElement
{
	
	
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-carousel';

    /**
     * @return string
     */
    private static $singular_name = 'Slides Element';

    /**
     * @return string
     */
    private static $plural_name = 'Slides Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementSlides';

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
        'Slides' => SlideObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Slides' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var array
     */
    private static $owns = [
        'Slides',
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
        $labels['Slides'] = _t(__CLASS__ . '.SlidesLabel', 'Slides');

        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            
	        $fields->replaceField('Content', new LiteralField('Content', ''));
            $fields->removeByName('Title');
            $fields->removeByName('ShowTitle');
			
			$fields->addFieldsToTab('Root.Main', array(
				TextField::create('Title', 'Title (reference only, never displayed)')
			));

            if ($this->ID) {
                /** @var \SilverStripe\Forms\GridField\GridField $SlideField */
                $slideField = $fields->dataFieldByName('Slides');
                $fields->removeByName('Slides');
                $config = $slideField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Main', array(
                    $slideField,
                ));
            }
        });
		
		return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getSlidesList()
    {
        return $this->Slides()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Slides()->count() == 1) {
            $label = ' slide';
        } else {
            $label = ' slides';
        }
        return DBField::create_field('HTMLText', $this->Slides()->count() . $label)->Summary(20);
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
        return _t(__CLASS__.'.BlockType', 'Slides');
    }
}

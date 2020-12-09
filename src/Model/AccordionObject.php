<?php
namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementAccordion;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

/**
 * Class AccordionObject
 *
 * @method \SilverStripe\ORM\ManyManyList ElementAccordions()
 */
class AccordionObject extends BaseElementObject
{
	
    /**
     * @return string
     */
    private static $singular_name = 'Accordion';

    /**
     * @return string
     */
    private static $plural_name = 'Accordions';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementAccordion' => ElementAccordion::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'AccordionObject';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Summary',
    ];
	
	private static $defaults = array (
		'ShowTitle' => '1'
	);


    /**
     * @return FieldList
     *
     * @throws \Exception
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName('ElementAccordion');
            $fields->removeByName('Image');
			
			
        });

        $fields = parent::getCMSFields();	

		return $fields;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->dbObject('Content')->Summary(20);
    }
}

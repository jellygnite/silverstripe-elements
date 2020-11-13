<?php
namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementPersons;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

/**
 * Class PersonObject
 *
 * @method \SilverStripe\ORM\ManyManyList ElementPersons()
 */
class PersonObject extends BaseElementObject
{
	
	
    /**
     * @return string
     */
    private static $singular_name = 'Person';

    /**
     * @return string
     */
    private static $plural_name = 'Persons';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementPersons' => ElementPersons::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'PersonObject';

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
            $fields->removeByName('ElementPersons');
			
        });

        $fields = parent::getCMSFields();	
		$fields->dataFieldByName('Image')
			->setFolderName('images/person'); 
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

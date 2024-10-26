<?php
namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementSponsors;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

/**
 * Class PersonObject
 *
 * @method \SilverStripe\ORM\ManyManyList ElementPersons()
 */
class SponsorObject extends BaseElementObject
{
	
	
    /**
     * @return string
     */
    private static $singular_name = 'Sponsor';

    /**
     * @return string
     */
    private static $plural_name = 'Sponsors';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementSponsors' => ElementSponsors::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'SponsorObject';

	private static $defaults = array (
		'ShowTitle' => '0'
	);


    /**
     * @return FieldList
     *
     * @throws \Exception
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName('ElementSponsors');
			$fields->removeByName('Title');
            $fields->removeByName('SubTitle');
            $fields->removeByName('ShowTitle');
            $fields->removeByName('Content');		
			
			$fields->insertBefore(
                'ElementLinkID',
                TextField::create('Title', 'Title (reference only, never displayed)')
            );
			
			
        });

        $fields = parent::getCMSFields();
		$fields->dataFieldByName('Image')
			->setFolderName('images/logos'); 
		return $fields;
    }


}

<?php

namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementPopups;
use SilverStripe\Assets\File;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\Dev\Debug;

/**
 * Class PopupObject
 * @package Dynamic\Elements\Popups\Model
 *
 * @method \SilverStripe\ORM\ManyManyList ElementPopups()
 */
class PopupObject extends BaseElementObject
{
	
    private static $db = [	
        'PopupContent' => 'HTMLText',
	];
	
	private static $has_one = [
        'ImageRollover' => File::class,   // use file class but limit file categories to support SVG
        'ImagePopup' => File::class,   // use file class but limit file categories to support SVG
    ];

    /**
     * @var array
     */
    private static $owns = [
        'ImageRollover',
		'ImagePopup'
    ];
	
	
    /**
     * @return string
     */
    private static $singular_name = 'Popup';

    /**
     * @return string
     */
    private static $plural_name = 'Popups';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementPopups' => ElementPopups::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'PopupObject';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Summary',
    ];
	
	private static $defaults = array (
		'ShowTitle' => '1'
	);


    private static $styles = [];

    /**
     * @return FieldList
     *
     * @throws \Exception
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
			$fields->removeByName('ElementPopups');
			$fields->removeByName('ElementLinkID');
			
			$fields->dataFieldByName('Image')
				->setFolderName('images/popups'); 
				
			$ufImageRollover = $fields->dataFieldByName('ImageRollover')
				->setFolderName('images/popups'); 
			
			$ufImagePopup= $fields->dataFieldByName('ImagePopup')
				->setFolderName('images/popups'); 
			
			$fields->InsertBefore( $ufImageRollover, 'Content');
			$fields->InsertBefore( $ufImagePopup, 'Content');
        });
		

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->dbObject('Content')->Summary(20);
    }
	
}

<?php
namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementSlides;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

/**
 * Class SlideObject
 *
 * @method \SilverStripe\ORM\ManyManyList ElementSlides()
 */
class SlideObject extends BaseElementObject
{
	private static $db = array(
		'PanelPosition' => 'Enum("None,Top Left,Top Center,Top Right,Middle Left,Middle Center,Middle Right,Bottom Left,Bottom Center,Bottom Right","None")',
	);	
	
    /**
     * @return string
     */
    private static $singular_name = 'Slide';

    /**
     * @return string
     */
    private static $plural_name = 'Slides';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementSlides' => ElementSlides::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'SlideObject';

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
            $fields->removeByName('ElementSlides');
			$fields->insertBefore(DropdownField::create("PanelPosition", "Panel Position", $this->dbObject('PanelPosition')->enumValues() ) , 'Content');
        });

        $fields = parent::getCMSFields();	
		$fields->dataFieldByName('Image')
			->setFolderName('images/slides')
			->setRightTitle('Recommended upload size is 1920px x 900px.');
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

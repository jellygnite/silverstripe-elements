<?php
namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementCarousel;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

/**
 * Class PersonObject
 *
 * @method \SilverStripe\ORM\ManyManyList ElementPersons()
 */
class CarouselObject extends BaseElementObject
{

    /**
     * @return string
     */
    private static $singular_name = 'Carousel';

    /**
     * @return string
     */
    private static $plural_name = 'Carousels';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementCarousel' => ElementCarousel::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'CarouselObject';

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
            $fields->removeByName('ElementCarousel');
			
        });

        $fields = parent::getCMSFields();
		$fields->dataFieldByName('Image')
			->setFolderName('images/carousel'); 
		return $fields;
    }


}

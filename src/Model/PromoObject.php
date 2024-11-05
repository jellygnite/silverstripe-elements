<?php

namespace Jellygnite\Elements\Model;

use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementPromos;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\Dev\Debug;

/**
 * Class PromoObject
 * @package Dynamic\Elements\Promos\Model
 *
 * @method \SilverStripe\ORM\ManyManyList ElementPromos()
 */
class PromoObject extends BaseElementObject
{
    /**
     * @return string
     */
    private static $singular_name = 'Promo';

    /**
     * @return string
     */
    private static $plural_name = 'Promos';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementPromos' => ElementPromos::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'PromoObject';

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
            $fields->removeByName('ElementPromos');

            $fields->dataFieldByName('Image')
                ->setFolderName('images'); 
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

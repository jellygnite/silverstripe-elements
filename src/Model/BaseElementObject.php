<?php
// 	ElementalArea 
//		has_many Elements => BaseElement::class 
//			has_many
//			many_many BaseElementObject::class

namespace Jellygnite\Elements\Model;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use DNADesign\Elemental\Models\BaseElement;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;

/**
 * Class BaseElementObject.
 *
 * @property string $Title
 * @property boolean $ShowTitle
 * @property string $SubTitle
 * @property string $Content
 *
 * @property int $ImageID
 * @property int $ElementLinkID
 *
 * @method Image Image()
 * @method Link ElementLink()
 *
 * @mixin Versioned
 */
class BaseElementObject extends DataObject
{
	
	
    private static $styles = [];
	
    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(255)',
        'ShowTitle' => 'Boolean',
        'SubTitle' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'ExtraClass' => 'Varchar(255)',
        'Style' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Image' => File::class,   // use file class but limit file categories to support SVG
        'ElementLink' => Link::class,
    );

    /**
     * @var array
     */
    private static $owns = array(
        'Image'
    );

    /**
     * @var string
     */
    private static $default_sort = 'Title ASC';

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Image.CMSThumbnail',
        'Title',
    );

    /**
     * @var array
     */
    private static $searchable_fields = array(
        'Title',
        'Content',
    );

    /**
     * @var array
     */
    private static $extensions = [
        Versioned::class,
    ];

    /**
     * Adds Publish button.
     *
     * @var bool
     */
    private static $versioned_gridfield_extensions = true;

    /**
     * @var string
     */
    private static $table_name = 'BaseElementObject';

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Title'] = _t(__CLASS__ . '.TitleLabel', 'Title');
        $labels['SubTitle'] = _t(__CLASS__ . '.SubTitleLabel', 'SubTitle');
        $labels['ElementLinkID'] = _t(__CLASS__ . '.LinkLabel', 'Link');
        $labels['Image'] = _t(__CLASS__ . '.ImageLabel', 'Image');
        $labels['Image.CMSThumbnail'] = _t(__CLASS__ . '.ImageLabel', 'Image');
        $labels['Content'] = _t(__CLASS__. '.ContentLabel', 'Content');

        return $labels;
    }

    /**
     * @return FieldList
     *
     * @throws \Exception
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            /** @var FieldList $fields */
            $fields->removeByName(array(
                'Sort',
            ));

            // Add a combined field for "Title" and "Displayed" checkbox in a Bootstrap input group
            $fields->removeByName('ShowTitle');
            $fields->replaceField(
                'Title',
                TextCheckboxGroupField::create()
                    ->setName($this->fieldLabel('Title'))
            );

            $fields->replaceField(
                'ElementLinkID',
                LinkField::create('ElementLinkID', $this->fieldLabel('ElementLinkID'))
                    ->setDescription(_t(__CLASS__.'.LinkDescription', 'Optional. Add a call to action link.'))
            );
			$fields->insertBefore(
                'Content', 
                $fields->dataFieldByName('SubTitle')
            );
            $fields->insertBefore(
                'Content', 
                $fields->dataFieldByName('ElementLinkID')
            );

            $image = $fields->dataFieldByName('Image')
                ->setDescription(_t(__CLASS__.'.ImageDescription', 'Optional. Display an image.'))
                ->setFolderName('images')
				->setAllowedFileCategories('image/supported','image/unsupported');
            $fields->insertBefore(
                'Content', 
                $image
            );

            $fields->dataFieldByName('Content')
                ->setRows(8);

            $fields->addFieldToTab(
                'Root.Settings',
                TextField::create('ExtraClass', 'Custom CSS classes')
                    ->setAttribute('placeholder','my_class another_class')
            );
			
							
            $styles = $this->config()->get('styles');

            if ($styles && count($styles) > 0) {
                $styleDropdown = DropdownField::create('Style', 'Style variation', $styles);
                $fields->insertBefore(
                    'ExtraClass', 
                    $styleDropdown
                );
                $styleDropdown->setEmptyString('Select a style..');
            } else {
                $fields->removeByName('Style');
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return SiteTree|null
     */
    public function getPage()
    {
        $page = Director::get_current_page();
        // because $page can be a SiteTree or Controller
        return $page instanceof SiteTree ? $page : null;
    }

  // method that can be overridden by indivudal element objects
    public function getOwnerElement()
    {
        // You can't find the owner element of an object that hasn't been saved yet
        if (!$this->isInDB()) {
            return null;
        }

	    return null;
    }

    public function getLinkURL()
    {
		if($link = $this->ElementLink){
			return $link->getLinkURL();
		}
		return false;
    }

    public function getStyleVariant()
    {
        $style = $this->Style;
        $styles = $this->config()->get('styles');

        if (isset($styles[$style])) {
            $style = strtolower($style ?? '');
        } else {
            $style = '';
        }

        $this->extend('updateStyleVariant', $style);

        return $style;
    }
	
	
    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param \SilverStripe\Security\Member|null $member
     * @return boolean
     */
    public function canView($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canView($member);
        }

        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param \SilverStripe\Security\Member|null $member
     *
     * @return boolean
     */
    public function canEdit($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canEdit($member);
        }

        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * Uses archive not delete so that current stage is respected i.e if a
     * element is not published, then it can be deleted by someone who doesn't
     * have publishing permissions.
     *
     * @param \SilverStripe\Security\Member|null $member
     *
     * @return boolean
     */
    public function canDelete($member = null)
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        if ($page = $this->getPage()) {
            return $page->canArchive($member);
        }

        return Permission::check('CMS_ACCESS', 'any', $member);
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param \SilverStripe\Security\Member|null $member
     * @param array $context
     *
     * @return boolean
     */
    public function canCreate($member = null, $context = array())
    {
        $extended = $this->extendedCan(__FUNCTION__, $member);
        if ($extended !== null) {
            return $extended;
        }

        return Permission::check('CMS_ACCESS', 'any', $member);
    }


}

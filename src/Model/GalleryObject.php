<?php
namespace Jellygnite\Elements\Model;

use Embed\Embed;
use Jellygnite\Elements\Model\BaseElementObject;
use Jellygnite\Elements\Model\ElementPersons;
use SilverStripe\Assets\File;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use UncleCheese\DisplayLogic\Forms\Wrapper;


use SilverStripe\ORM\ValidationResult;
use SilverStripe\View\Requirements;
use SilverStripe\Dev\Debug;

/**
 * Class GalleryObject
 *
 * @method \SilverStripe\ORM\ManyManyList ElementGallery()
 */
class GalleryObject extends BaseElementObject
{


	private static $valid_providers = ['youtube','vimeo'];
		
	private static $db = array(
		'Type' => 'Enum("Image,HTML5Video,EmbedVideo","Image")',
	    'VideoURL' => 'Varchar(255)',
		'Code' => 'Varchar(100)',
        'Provider' => 'Varchar(50)',
        'ImageURL' => 'Varchar(255)' 
	);	

    private static $has_one = [
        'HTML5Video' => File::class,
    ];	
	
	private static $owns = [
        'HTML5Video'
    ];
	
    /**
     * @return string
     */
    private static $singular_name = 'Media Item';

    /**
     * @return string
     */
    private static $plural_name = 'Media Items';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementGallery' => ElementGallery::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'GalleryObject';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Summary',
    ];
	
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
	        
      		Requirements::javascript('jellygnite/silverstripe-elements:client/dist/javascript/jsVideoUrlParser.js');
      		Requirements::javascript('jellygnite/silverstripe-elements:client/dist/javascript/parsevideo.js');
						
			$fldType = $fields->dataFieldByName('Type');
			$fldVideoURL = $fields->dataFieldByName('VideoURL')->setRightTitle('Enter a Youtube or Vimeo URL.');
			$fldVideoCode = $fields->dataFieldByName('Code')->setAttribute("readonly",true);
			$fldVideoProvider = $fields->dataFieldByName('Provider')->setAttribute("readonly",true);
			$fldVideoImageURL = $fields->dataFieldByName('ImageURL')->setAttribute("readonly",true);
			$fldImage = $fields->dataFieldByName('Image')
				->setFolderName('images/gallery')
				->setDescription(null);
			
			$fldHTML5Video = $fields->dataFieldByName('HTML5Video');
			$fldHTML5Video->setFolderName('video')
				->setAllowedFileCategories('video');
			
            $fields->removeByName([
				'ElementGallery',
				'ElementLinkID',
				'Type',
				'VideoURL',
				'Code',
				'Provider',
				'ImageURL',
				'Image',
				'HTML5Video',
				'Content',
			]);
									
			$fields->addFieldsToTab('Root.Main', [
				$fldType,			
				Wrapper::create([
					$fldVideoURL,
					FieldGroup::create( 
						$fldVideoCode, 
						$fldVideoProvider,
						$fldVideoImageURL
					)->setTitle("Video Meta")->addExtraClass("fieldgroup-horizontal")
				])
					->displayIf('Type')->isEqualTo('EmbedVideo')
					->end(),
				Wrapper::create( $fldHTML5Video )
					->displayIf('Type')->isEqualTo('HTML5Video')
					->end(),
				Wrapper::create( LiteralField::create('InfoField','<div class="form__field-holder"><p>Optional image field may be used as video thumbnail.</p></div>')  )
					->displayIf('Type')->isEqualTo('HTML5Video')
//					->orIf("Type")->isEqualTo("EmbedVideo")
					->end(),
				Wrapper::create($fldImage)
					->displayIf('Type')->isEqualTo('Image')
					->orIf("Type")->isEqualTo("HTML5Video")
//					->orIf("Type")->isEqualTo("EmbedVideo")
					->end()

			]);
			
			
			
			
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

    public function validate()
    {
        $result = parent::validate();
		$providers = $this->config()->get('valid_providers');
		
        // check provider is valid
        if ($this->VideoProvider && !in_array($this->VideoProvider,$providers)) {
            $result->addError(
                'Video Provider is not valid',
                ValidationResult::TYPE_ERROR,
                'INVALID_PROVIDER'
            );
        }



        return $result;
    }
	
    public function getVideoURL($params = null) {
		switch ($this->Provider) {
			case 'youtube':
				return 'https://www.youtube.com/watch?v='.$this->Code;
				break;
			case 'vimeo':
				return 'https://vimeo.com/'.$this->Code;
				break;
		}
		
		return $this->getField('VideoURL');
	}
	
    public function getEmbedURL($params = null) {
		switch ($this->Provider) {
			case 'youtube':
				return 'https://www.youtube.com/embed/'.$this->Code.'?autoplay=1&rel=0';
				break;
			case 'vimeo':
				return 'https://player.vimeo.com/video/'.$this->Code;
				break;
			default:
				return false;
		}
	}
    public function getMediaType($params = null) {
		switch ($this->Type) {
			case 'Image':
				return 'image';
				break;
			case 'HTML5Video':
				return 'html5video';
				break;
			case 'EmbedVideo':
				switch ($this->Provider) {
					case 'youtube':
					case 'vimeo':
						return 'video';
						break;
					default:
						return false;
				}
				break;
		}
	}
}

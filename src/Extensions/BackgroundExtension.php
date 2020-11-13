<?php

namespace Jellygnite\Elements\Extensions;

use Jellygnite\Elements\Controllers\CustomElementController;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Dev\Debug;



/**
 * class ElementContentExtension
 * =============================
 *
 * Extends DNADesign\Elemental\Models\ElementContent;
 *
 * License: MIT-style license http://opensource.org/licenses/MIT
 * 
 * Adds a background object to your element
 * 
 * add this to your mysite.yml e.g.
 
DNADesign\Elemental\Models\ElementContent:
  extensions:
    - Jellygnite\Elements\Extensions\BackgroundExtension
 *
 *
**/


class BackgroundExtension extends DataExtension 
{

    private static $has_one = [
        'BackgroundImage' => Image::class,
        'BackgroundVideo' => File::class,
    ];	
	
	private static $owns = [
        'BackgroundImage',
        'BackgroundVideo'
    ];


    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder

	private static $controller_template = 'ElementHolder';

    public function updateCMSFields(FieldList $fields) 
	{
		$fldBackgroundImage = $fields->dataFieldByName('BackgroundImage')
			->setFolderName('images/background')
			->setDescription('This will also be used as the poster image if using a video background.');
		
		$fldBackgroundVideo = $fields->dataFieldByName('BackgroundVideo');
		$fldBackgroundVideo->setFolderName('video')
			->setAllowedFileCategories('video')
			->setDescription('This will override the background image.');
		
		$fields->removeByName([
			'BackgroundImage','BackgroundVideo'
		]);


		$fields->addFieldsToTab('Root.Background', [
			$fldBackgroundImage,
			$fldBackgroundVideo
		]);
    }

    public function updateStyleVariant(&$style)
	{
		if($this->owner->BackgroundImageID || $this->owner->BackgroundVideoID) {
			$style .= ' has-bg';
			if($this->owner->BackgroundImage->IsDark()){
				$style .= ' invert';
			}
		}					
    }
	
}
<?php

namespace Jellygnite\Elements\Extensions;

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

    public function updateCMSFields(FieldList $fields) 
	{
		$fldBackgroundImage = $fields->dataFieldByName('BackgroundImage')
			->setFolderName('images/background')
			->setDescription(null);
		
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
		if($this->hasBackground()) {
			$style .= ' has-bg';
		}
					
    }
	
    public function hasBackground()
	{
		return (bool) ($this->owner->BackgroundImageID || $this->owner->BackgroundVideoID) ;
					
    }
	
}
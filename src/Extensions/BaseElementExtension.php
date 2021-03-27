<?php

namespace Jellygnite\Elements\Extensions;

use Jellygnite\Elements\Controllers\CustomElementController;
use Exception;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\DataExtension;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Dev\Debug;

class BaseElementExtension extends DataExtension 
{

    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder

	private static $controller_template = 'ElementHolder';
	
	
	public function getNextElement(){
		$element = BaseElement::get()->filter([
			'ParentID' => $this->owner->ParentID,
			'Sort:GreaterThan' => $this->owner->Sort,
		])->sort('Sort')->first();
		return $element;
	}
	
    /**
     * Check if this element contains a CSS class
     *
     * @return boolean
     */	
	public function hasCustomCSSClass($cssclass){
		//$haystack = $this->owner->ExtraClass. ' ' . $this->owner->Style;
		$haystack = $this->owner->getStyleVariant();
		return ((((strpos($haystack, $cssclass )) ) !== false));
	}
	
}
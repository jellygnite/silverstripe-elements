<?php

namespace Jellygnite\Elements\Extensions;

use SilverStripe\ORM\DataExtension;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Dev\Debug;

class BaseElementExtension extends DataExtension 
{

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
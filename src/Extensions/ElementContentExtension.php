<?php

namespace Jellygnite\Elements\Extensions;

use Jellygnite\Elements\Controllers\CustomElementController;
use SilverStripe\ORM\DataExtension;


class ElementContentExtension extends DataExtension 
{

    private static $controller_class = CustomElementController::class;  // allows us to store templates in this module folder

	private static $controller_template = 'ElementHolder';
	
	
}
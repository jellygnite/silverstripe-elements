<?php

namespace Jellygnite\Elements\Controllers;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\View\Requirements;


class CustomElementController extends ElementController
{
     /**
     * Renders the managed {@link BaseElement} wrapped with the current
     * {@link ElementController}.
     *
     * @return string HTML
     */
    public function forTemplate()
    {
        $defaultStyles = $this->config()->get('default_styles');
        if ($this->config()->get('include_default_styles') && !empty($defaultStyles)) {
            foreach ($defaultStyles as $stylePath) {
                Requirements::css($stylePath);
            }
        }

        $template = $this->element->config()->get('controller_template');

        return $this->renderWith([
            'type' => 'Layout',
            'Jellygnite\\Elements\\'.$template,		// allow template location in jellygnite folder
            'DNADesign\\Elemental\\'.$template		// fallback to this one
        ]);
    }

}

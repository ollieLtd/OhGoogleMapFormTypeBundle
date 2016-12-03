<?php

namespace Oh\GoogleMapFormTypeBundle\Twig\Extension;

/**
 * Description of GlobalsExtension.
 * 
 * aqui defino todas las variables globales para poder recoger en cualquier 
 * plantilla twig del bundle
 *
 * @author Juanjo García <juanjogarcia@editartgroup.com>
 */

class GlobalsExtension extends \Twig_Extension {

    /**
     * 
     * @param string $apiKey
     */
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function getGlobals() {

        return array(
            'apiKey' => $this->apiKey
        );
    }

    public function getName() {
        return 'oh.twig.extension.globals';
    }

}

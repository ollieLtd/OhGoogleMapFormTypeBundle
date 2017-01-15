<?php

namespace Oh\GoogleMapFormTypeBundle\Twig\Extension;

/**
 * Expose GoogleMaps Api Key globally so it can be accessed anywhere in Twig.
 *
 * @author Juanjo García <juanjogarcia@editartgroup.com>
 */
class GlobalsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getGlobals()
    {
        return array(
            'apiKey' => $this->apiKey,
        );
    }

    public function getName()
    {
        return 'oh.twig.extension.globals';
    }
}

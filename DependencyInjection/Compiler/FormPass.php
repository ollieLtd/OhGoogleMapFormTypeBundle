<?php

namespace Oh\GoogleMapFormTypeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Add a new twig.form.resources
 *
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');

        foreach (array('div', 'jquery') as $template) {
            $resources[] = 'OhGoogleMapFormTypeBundle:Form:' . $template . '_layout.html.twig';
        }

        $container->setParameter('twig.form.resources', $resources);
    }
}

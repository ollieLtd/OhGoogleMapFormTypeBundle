<?php

namespace Oh\GoogleMapFormTypeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Oh\GoogleMapFormTypeBundle\DependencyInjection\Compiler\FormPass;

class OhGoogleMapFormTypeBundle extends Bundle {

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }

}

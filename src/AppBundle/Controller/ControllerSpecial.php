<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of ControllerSpecial
 *
 * @author Mat
 */
abstract class ControllerSpecial extends Controller {
    
    /**
     * Override
     */
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->init();
    }
    
    /**
     * Initialize stuff after the setContainer
     */
    public abstract function init();
}

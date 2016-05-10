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
     * Get the business service for target entity
     * @param string $name Name of the entity
     * @return \AppBundle\Services\Business\BusinessService
     */
    public function getBusinessService ( $name ) {
        return $this->get( 'app.business_service_factory' )
                    ->build( $name );
    }


    /**
     * Initialize stuff after the setContainer
     */
    public abstract function init();
}

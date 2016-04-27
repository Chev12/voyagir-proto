<?php

namespace AppBundle\Services\Business;

/**
 * Description of BusinessServices
 *
 * @author Mat
 */
class BusinessServiceFactory {
    
    private $doctrine;
    private $logger;
    
    public function __construct( $doctrine, $logger ){
        $this->doctrine = $doctrine;
        $this->logger = $logger;
    }
    
    public function build( $serviceName ) {
        $service = null;
        $ns = "\\AppBundle\\Services\\Business\\";
        if( $serviceName ){
            $serviceFullName = $ns.$serviceName."Service";
            $service = new $serviceFullName ( $this->doctrine );
        }
        if( !$service ){
            throw new Exception("Merde", null, null);
        }
        $service->setRepo( $this->doctrine->getRepository( 'AppBundle:'.$serviceName ));
        $service->setLogger( $this->logger );
        return $service;
    }
}
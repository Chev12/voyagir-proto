<?php

namespace AppBundle\Services\Business;

/**
 * Description of BusinessServices
 *
 * @author Mat
 */
class BusinessServiceFactory {
    
    /**
     * @var \Symfony\Bridge\Doctrine\RegistryInterface
     */
    private $doctrine;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    
    public function __construct( $doctrine, $logger ){
        $this->doctrine = $doctrine;
        $this->logger = $logger;
    }
    
    /**
     * Builds a service for target entity name
     * 
     * @param string $entityName The name of the entity
     * @return \AppBundle\Services\Business\BusinessService
     * @throws Exception
     */
    public function build( $entityName ) {
        $service = null;
        $ns = "\\AppBundle\\Services\\Business\\";
        if( $entityName ){
            $serviceName = $ns.$entityName."Service";
            if( class_exists($serviceName) ){
                $service = new $serviceName ( $this->doctrine->getManager() );
            }
            else {
                $service = new BusinessService( $this->doctrine->getManager() );
            }
        }
        if( !$service ){
            // TODO change Exception name :)
            throw new Exception("Merde", null, null);
        }
        $service->setRepo( $this->doctrine->getRepository( 'AppBundle:'.$entityName ));
        $service->setLogger( $this->logger );
        return $service;
    }
}
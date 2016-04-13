<?php

namespace AppBundle\Services\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\EstablishmentActivity;

/**
 * Listener for persistence operations on EstablishmentActivity entity
 *
 * @author Mat
 */
class EstablishmentActivityListener implements EventSubscriber{
    
    var $logger;
    
    public function __construct($logger) {
        $this->logger = $logger;
    }
    
    public function getSubscribedEvents(){
        return array('prePersist');
    }
    
    // Automatically generate the ID of the activity since it's not 
    // supported by Doctrine
    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if($entity instanceof EstablishmentActivity){
            $em = $args->getEntityManager();
            $query = $em->getRepository('AppBundle:EstablishmentActivity');
            $query = $query->createNamedQuery("getNewId")
                        ->setParameter("id_etb", 
                                       $entity->getEstablishment()->getId());
            $rs = $query->getResult();
            $this->logger->info("Result ID is ".$rs[0]['new_id']);
            $entity->setId($rs[0]['new_id']);
        }
    }
}

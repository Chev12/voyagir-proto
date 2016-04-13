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
    
    /**
     * Set the activity id before persist
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if($entity instanceof EstablishmentActivity){
            // Don't change the id if it's not a new activity
            if($entity->getId() === null){
                $entity->setId($this->getNewId($em, $entity));
            }
        }
    }
    
    /**
     * Calls the named query that fetch the maximum id + 1 and return it
     * If none exist for the establishment, return 1
     * @param EntityManager $em
     * @param EstablishmentActivity $activity
     * @return integer
     */
    public function getNewId($em, $activity){
        $newId = 1;
        $query = $em->getRepository('AppBundle:EstablishmentActivity')
                    ->createNamedQuery("getNewId")
                    ->setParameter("id_etb", 
                                   $activity->getEstablishment()->getId());
        $rs = $query->getResult();
        if(count($rs) > 0){
            $newId = $rs[0]['new_id'];
        }
        return $newId===null?1:$newId;
        
    }
}

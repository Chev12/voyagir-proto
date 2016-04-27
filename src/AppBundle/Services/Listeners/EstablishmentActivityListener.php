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
            if($entity->getLevel() === null){
                $entity->setLevel($this->getNewLevel($em, $entity));
            }
        }
    }
    
    /**
     * Calls the named query that fetch the maximum level + 1 and return it
     * If none exist for the establishment, return 1
     * @param EntityManager $em
     * @param EstablishmentActivity $activity
     * @return integer
     */
    public function getNewLevel($em, $activity){
        $newLevel = 1;
        $query = $em->getRepository('AppBundle:EstablishmentActivity')
                    ->createNamedQuery("getNewLevel")
                    ->setParameter("id_etb", 
                                   $activity->getEstablishment()->getId());
        $rs = $query->getResult();
        if(count($rs) > 0){
            $newLevel = $rs[0]['new_level'];
        }
        return $newLevel===null?1:$newLevel;
        
    }
}

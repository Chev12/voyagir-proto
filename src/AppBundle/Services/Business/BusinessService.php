<?php

namespace AppBundle\Services\Business;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * Description of EstablishmentService
 *
 * @author Mat
 */
class BusinessService {
    
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var EntityRepository
     */
    private $repo;
    
    private $logger;
    
    /**
     * Get an object by id.
     * @param integer $id
     * @return Object
     * @throws NotFoundException
     */
    function get( $id ) {
        $obj = $this->getRepo()->find( $id );
            
        if ( ! $obj ) {
            throw new NotFoundHttpException(
                'No object found for id '.$id, null
            );
        }
        return $obj;
    }
    
    /**
     * Find all entities in repository
     */
    public function findAll(){
        return $this->repo->findAll();
    }
    
    /**
     * Persist an entity (create/update)
     * @param type $entity
     * @param boolean $doFlush
     */
    public function save ( $entity, $doFlush = true) {
        $this->em->persist( $entity );
        if($doFlush){
            $this->flush();
        }
    }
    
    /**
     * Delete an entity
     * @param type $entity
     * @param boolean $doFlush
     */
    public function remove ( $entity, $doFlush = true ) {
        $this->em->remove( $entity );
        if($doFlush){
            $this->flush();
        }
    }
    
    /**
     * Flush
     */
    public function flush () {
        $this->em->flush();
    }
    
    public function __construct($doctrine) {
        $this->em = $doctrine->getManager();
    }
    
    /**
     * Return this service repository
     * @return Doctrine\ORM\Repository
     */
    public function getRepo(){
        return $this->repo;
    }
    
    /**
     * Set this service repository
     * @param Doctrine\ORM\Repository $repo
     * @return \AppBundle\Services\Business\BusinessService
     */
    public function setRepo($repo){
        $this->repo = $repo;
        return $this;
    }
    
    /**
     * Set logger
     * @param type $logger
     */
    public function setLogger($logger){
        $this->logger = $logger;
    }
}

<?php

namespace AppBundle\Services\Business;

/**
 * Description of CategoryService
 *
 * @author Mat
 */
class CategoryService extends BusinessService {
    
    /**
     * Get a category by its limits
     * @param integer $id
     * @return Object
     * @throws NotFoundException
     */
    function getByLimits( $limit_inf, $limit_sup ) {
        $obj = $this->getRepo()->findOneBy( $limit_inf, $limit_sup );
            
        if ( ! $obj ) {
            throw new NotFoundHttpException(
                'No catagories found with limits ('.$limit_inf.'-'.$limit_sup.').', null
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
}

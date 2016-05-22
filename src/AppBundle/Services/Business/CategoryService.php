<?php

namespace AppBundle\Services\Business;

use AppBundle\Entity\Category;

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
     * Get a category by its limits with its parents
     * @param integer $id
     * @return Object
     * @throws NotFoundException
     */
    function getWithParents( $id ) {
        
        $category = $this->get($id);
        
        $qb = $this->getQueryBuilder();
        $qb->select('c')
           ->from('AppBundle:Category', 'c')
           ->where($qb->expr()->andX(
                $qb->expr()->lt('c.limitInf', ':limit_inf'),
                $qb->expr()->gt('c.limitSup', ':limit_sup')
           ))
           ->orderBy('c.level', 'DESC')
           ->setParameter('limit_inf', $category->getLimitInf())    
           ->setParameter('limit_sup', $category->getLimitSup());
        
        $results = $qb->getQuery()->getResult();
        $category->setParentCategories($results);
        return $category;
    }
    
    /**
     * Persist a category (create/update)
     * @param Category $category
     * @param Category $parent
     * @param boolean $doFlush
     */
    public function saveWithParent ( $category, $parent, $doFlush = true) {
        $limitSupParent = $parent->getLimitSup();
        
        $rootParent = $parent;
        if ( $parent->getLevel() > 1 ) {
            $rootParent = $this->getRootParent ( $parent );
        }
        $category->setLimitInf ( $limitSupParent );
        $category->setLimitSup ( $limitSupParent + 1 );
        $category->setLevel ( $parent->getLevel() + 1 );
        
        $this->updateToTheRight ( $rootParent->getLimitSup() );
        $this->updateParents ( $parent );
        return parent::save ( $category, $doFlush );
    }
    
    /**
     * 
     * @param Category $category
     * @param boolean $doFlush
     */
    public function remove ( $category, $doFlush = true ) {
        //$rootParent = $this->getRootParent ( $category );
        $this->updateToTheRight ( $category->getLimitSup(), '-' );
        $this->updateParents ( $category, '-' );
        parent::remove ( $category, $doFlush );
    }
    
    /**
     * Get the first (level = 1) parent of given category
     * @param Category $category
     * @return Category
     */
    public function getRootParent ( $category ) {
        $qb = $this->getQueryBuilder();
        $qb->select('c')
           ->from('AppBundle:Category', 'c')
           ->where($qb->expr()->andX(
                $qb->expr()->eq('c.level', 1),
                $qb->expr()->lte('c.limitInf', ':limit_inf'),
                $qb->expr()->gte('c.limitSup', ':limit_sup')
           ))
           ->setParameter('limit_inf', $category->getLimitInf())    
           ->setParameter('limit_sup', $category->getLimitSup());
        return $qb->getQuery()->getSingleResult();
    }
    
    /**
     * Move all categories on the right of given limit further
     * @param int $limit_sup
     */
    private function updateToTheRight ( $limit_sup, $f = '+' ) {
        $qb = $this->getQueryBuilder();
        $qb->update('AppBundle:Category', 'c')
           ->set('c.limitInf', 'c.limitInf '.$f.' 2')
           ->set('c.limitSup', 'c.limitSup '.$f.' 2')
           ->where('c.limitInf > :limit')
           ->setParameter('limit', $limit_sup);
        $qb->getQuery()->execute();
    }
    
    /**
     * Update all parent categories
     * @param Category $category
     */
    private function updateParents ( $category, $f = '+' ) {
        $qb = $this->getQueryBuilder();
        $qb->update('AppBundle:Category', 'c')
           ->set('c.limitSup', 'c.limitSup '.$f.' 2')
           ->where($qb->expr()->andX(
                $qb->expr()->lte('c.limitInf', ':limit_inf'),
                $qb->expr()->gte('c.limitSup', ':limit_sup')))
           ->setParameter('limit_inf', $category->getLimitInf())
           ->setParameter('limit_sup', $category->getLimitSup());
        $qb->getQuery()->execute();
    }
}

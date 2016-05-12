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
     * Persist a category (create/update)
     * @param Category $category
     * @param Category $parent
     * @param boolean $doFlush
     */
    public function saveWithParent ( $category, $parent, $doFlush = true) {

        $limitSupParent = $parent->getLimitSup();
        
        $category->setLimitInf( $limitSupParent );
        $category->setLimitSup( $limitSupParent + 1 );
        $category->setLevel( $parent->getLevel() + 1 );
        
        $parent->setLimitSup($limitSupParent + 2);
        
        // MAJ catégorie suivante
        /*update category set
        limit_inf = limit_inf + 2,
                limit_sup = limit_sup + 2
                where limit_inf > limitSupParent;*/
        
        // MAJ catégories parentes
        /*update category set
            limit_sup = limit_sup + 2
        where limit_sup >= limitSupParent
                and limit_inf < limitSup*/
        
        parent::save($category, false);
        parent::save($parent, $doFlush);
        return $category;
    }
}

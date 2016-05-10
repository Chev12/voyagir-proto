<?php

namespace AppBundle\Services\Business;

use AppBundle\Entity\Establishment;

/**
 * Description of CommitmentService
 *
 * @author Mat
 */
class EstablishmentService extends BusinessService {
    
    /**
     * Recherche un établissement
     * @param type $etbCriteria
     * @return type
     */
    public function search ( Establishment $etbCriteria )
    {
        $qb = $this->getQueryBuilder();
        $arrayAnd = array();
        $arrayParams = array();
        
        // Name
        if ( $etbCriteria->getName() )
        {
            $arrayAnd[] = $qb->expr()->like(
                        $qb->expr()->lower ( 'e.name' ), 
                        $qb->expr()->lower ( ':name' ));
            $arrayParams['name'] = '%'.$etbCriteria->getName().'%';
        }
        // Category
        if ( $etbCriteria->getCategory() )
        {
            $arrayAnd[] = $qb->expr()->eq ( 'e.category', ':category' );
            $arrayParams['category'] = $etbCriteria->getCategory();
        }
        // Area
        if ( $etbCriteria->getAdressRegion() )
        {
            $arrayAnd[] = $qb->expr()->like(
                        $qb->expr()->lower ( 'e.adressRegion' ), 
                        $qb->expr()->lower ( ':area' ));
            $arrayParams['area'] = $etbCriteria->getAdressRegion();
        }
        // City
        if ( $etbCriteria->getAdressCity() )
        {
            $arrayAnd[] = $qb->expr()->like(
                        $qb->expr()->lower ( 'e.city' ), 
                        $qb->expr()->lower ( ':city' ));
            $arrayParams['city'] = $etbCriteria->getAdressCity();
        }
        // Country
        if ( $etbCriteria->getAdressCountry() )
        {
            $arrayAnd[] = $qb->expr()->eq ( 'e.adressCountry', ':country' );
            $arrayParams['country'] = $etbCriteria->getAdressCountry();
        }
        $where = call_user_func_array ( array ( $qb->expr(), 'andx' ), $arrayAnd);
        $qb->select ( 'e' )
           ->from( 'AppBundle:Establishment', 'e' )
           ->where( $where );
        $qb->setParameters ( $arrayParams );
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Met à jour la date de création, la catégorie par défaut
     * puis sauve l'établissement
     * @param Establishment $etb
     * @param boolean $doFlush
     * @return Establishment
     */
    public function save ( $etb, $doFlush = true ) 
    {
        // Si nouvel établissement
        if ( ! $etb->getCreatedAt() )
        {
            $etb->setCreatedAt ( new \DateTime() )
                ->setValidated ( 0 );
            if ( ! $etb->getCategory() )
            {
                $etb->setCategory( 1 );
            }
        }
        return parent::save ( $etb, $doFlush );
    }
    
    /**
     * Validate an establishment
     * @param Establishment $etb
     * @param boolean $doFlush
     * @return Establishment
     */
    public function validate ( Establishment $etb, $doFlush = true ) 
    {
        $etb->setValidated ( 1 );
        $etb->setValidatedAt ( new \DateTime() );
        return parent::save ( $etb, $doFlush );
    }
    
    /**
     * Return the last validated establishment.
     * @param integer $limit Wanted number of establishments
     * @return array Array of establishments
     */
    public function findLastValidated ( $limit )
    {
        return $this->getRepo()->findBy( array ( 'validated' => 1 ), 
                                         array ( 'validatedAt'  => 'DESC',
                                                 'createdAt'    => 'DESC'), 
                                         $limit );
    }
        
    /**
     * Return the non validated establishment.
     * @return array Array of establishments
     */
    public function findNotValidated ()
    {
        return $this->getRepo()->findBy(array ('validated' => 0));
    }
}
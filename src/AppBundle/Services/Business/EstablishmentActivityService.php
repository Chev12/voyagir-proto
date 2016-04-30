<?php

namespace AppBundle\Services\Business;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of EstablishmentActivityService
 *
 * @author Mat
 */
class EstablishmentActivityService extends BusinessService {
    
    /**
     * Get an activity by its Establishment and level
     * 
     * @param type $idEtb Establishment id
     * @param type $level 
     * @return \AppBundle\Entity\EstablishmentActivity
     * @throws NotFoundHttpException
     */
    function getByEtbAndLevel( $idEtb, $level ) {
        $activity = $this->getRepo()->findOneBy(array('establishment' => $idEtb, 'level' => $level));
            
        if ( ! $activity ) {
            throw new NotFoundHttpException(
                'No activites found for Establishment '.$idEtb.' at level '.$level.').', null
            );
        }
        return $activity;
    }
}

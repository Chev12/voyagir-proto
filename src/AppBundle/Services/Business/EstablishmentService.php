<?php

namespace AppBundle\Services\Business;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of EstablishmentService
 *
 * @author Mat
 */
class EstablishmentService extends BusinessService {
    
    /**
     * Get an establishment by id.
     * @param integer $id
     * @return AppBundle\Entity\Establishment
     * @throws NotFoundException
     */
    function get( $id ) {
        $establishment = $this->getRepo()->find( $id );
            
        if ( ! $establishment ) {
            throw new NotFoundHttpException(
                'No establishment found for id '.$id, null
            );
        }
        return $establishment;
    }
}

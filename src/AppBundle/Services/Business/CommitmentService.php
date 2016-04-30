<?php

namespace AppBundle\Services\Business;

/**
 * Description of CommitmentService
 *
 * @author Mat
 */
class CommitmentService extends BusinessService {
    
    /**
     * Get a Commitmnet by id.
     * @param integer $id
     * @return \AppBundle\Entity\Commitment
     * @throws NotFoundException
     */
    function get( $id ) {
        $commitment = parent::get($id);

        // Create an ArrayCollection of the current Question objects in the database
        foreach ($commitment->getQuestions() as $question) {
            $commitment->addOriginalQuestions($question);
        }
        return $commitment;
    }
    
    /**
     * Persist a Commitment (create/update)
     * @param \AppBundle\Entity\Commitment $commitment
     * @param boolean $doFlush
     */
    public function save ( $commitment, $doFlush = true) {
        foreach ($commitment->getOriginalQuestions() as $question) {
            if (false === $commitment->getQuestions()->contains($question)) {
                $this->remove($question, $doFlush);
            }
        }
        parent::save( $commitment, $doFlush );
    }
}

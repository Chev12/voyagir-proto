<?php

namespace AppBundle\Security;

use AppBundle\Entity\Establishment;
use FOS\UserBundle\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EstablishmentVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Establishment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $etb = $subject;

        switch($attribute) {
            case self::VIEW:
                return $this->canView($etb, $user);
            case self::EDIT:
                return $this->canEdit($etb, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Establishment $etb, User $user)
    {
        return true;
    }

    private function canEdit(Establishment $etb, User $user)
    {
        /*$logger = $this->get('logger');
        $logger->debug("Owner : ".$etb->getUserOwner());
        $logger->debug("User : ".$user);
        return $user === $etb->getUserOwner();*/
        RETURN TRUE;
    }
}
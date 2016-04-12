<?php

namespace AppBundle\Services;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
/**
 * Description of UserSecurity
 *
 * @author Mat
 */
class UserSecurity {
    
    private $tokenStorage;
    private $authChecker;
    
    /**
     * Verify the user has ownership of the establishment
     * @throws type AccessDeniedException
     */
    public function verifyOwnership($_idEtb){
        $found = false;
        // If no id then the user is creating a new one
        if($_idEtb == 0){
            $found = true;
        }
        // The user must be logged in
        elseif ($this->authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = null;
            $token = $this->tokenStorage->getToken();
            if($token !== null && is_object($token->getUser())){
                $user = $token->getUser();
                foreach($user->getEstablishments() as $etb){
                    if($etb->getId() == $_idEtb){
                        $found = true;
                        break;
                    }
                }
            }
        }
        return $found;
        /* Code à intégrer :
            $ownerConnected = $this->get('utils.user_security')->verifyOwnership($_id);
            if(!$ownerConnected){
                throw $this->createAccessDeniedException();
            }
         */
    }
    
    public function __construct(TokenStorage $tokenStorage, AuthorizationChecker $authChecker) {
        $this->tokenStorage = $tokenStorage;
        $this->authChecker = $authChecker;
    }
}

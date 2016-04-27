<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends ControllerSpecial
{
    private $establishmentService;
    
    public function init(){
        $this->establishmentService = 
                $this->get( 'app.business_service_factory' )
                     ->build( 'Establishment' );
    }
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $establishments = $this->establishmentService->findAll();
        
        return $this->render('default/index.html.twig', array(
            'establishments' => $establishments
        ));
    }
}


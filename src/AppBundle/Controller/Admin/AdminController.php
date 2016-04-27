<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\ControllerSpecial;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends ControllerSpecial
{
    /**
     * @var \AppBundle\Services\Business\CommitmentService
     */
    private $commitmentService;
    /**
     * @var \AppBundle\Services\Business\ActivityTypeService
     */
    private $activityService;
    
    public function init(){
        $this->commitmentService = 
                $this->get( 'app.business_service_factory' )
                     ->build( 'Commitment' );
        $this->activityService = 
                $this->get( 'app.business_service_factory' )
                     ->build( 'ActivityType' );
    }
    
    /**
     * @Route("/admin", name="admin_home")
     */
    public function indexAction(Request $request)
    {
        $commitments = $this->commitmentService->findAll();
        $activities = $this->activityService->findAll();
        
        return $this->render('admin/index.html.twig', array(
            'commitments' => $commitments,
            'activities' => $activities
        ));
    }
}


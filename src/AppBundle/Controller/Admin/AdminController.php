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
    /**
     * @var \AppBundle\Services\Business\EstablishmentService
     */
    private $establishmentService;
    
    public function init(){
        $this->commitmentService = $this->getBusinessService ( 'Commitment' );
        $this->activityService = $this->getBusinessService ( 'ActivityType' );
        $this->establishmentService = $this->getBusinessService ( 'Establishment' );
    }
    
    /**
     * @Route("/admin", name="admin_home")
     */
    public function indexAction(Request $request)
    {
        $commitments = $this->commitmentService->findAll();
        $activities = $this->activityService->findAll();
        $establishments = $this->establishmentService->findNotValidated();
        
        return $this->render('admin/index.html.twig', array(
            'commitments' => $commitments,
            'activities' => $activities,
            'establishments' => $establishments
        ));
    }
}


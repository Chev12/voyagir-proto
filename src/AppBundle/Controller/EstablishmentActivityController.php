<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EstablishmentActivity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\Extension\Core\Type\IntegerType;

class EstablishmentActivityController extends ControllerSpecial
{
    /**
     * @var \AppBundle\Services\Business\EstablishmentActivityService
     */
    private $activityService;
    /**
     * @var \AppBundle\Services\Business\EstablishmentService
     */
    private $establishmentService;
    
    public function init(){
        $this->activityService = $this->getBusinessService ( 'EstablishmentActivity' );
        $this->establishmentService = $this->getBusinessService ( 'Establishment' );
    }
    
    /**
     * @Route("/etb/{_idEtb}/activity/{_level}", name="etb_activity_detail")
     */
    public function indexAction($_idEtb, $_level = 0)
    {   
        $activity = $this->activityService->getByEtbAndLevel($_idEtb, $_level);
        
        return $this->render('establishment/activity/detail.html.twig', array(
            'activity' => $activity
        ));
    }
    
    /**
     * @Route("/manage/etb/{_idEtb}/activity/{_level}", name="etb_activity_update",
     *                            defaults={"_idAct" = 0})
     * @Route("/manage/etb/{_idEtb}/activity/", name="etb_activity_new",
     *                      defaults={"_level" = 0})
     */
    public function manageAction( Request $request, $_idEtb, $_level = 0)
    {   
        // Getting an existing activity or a new one
        $establishmentActivity = $this->getEstablishmentActivity($_idEtb, $_level);
        $this->denyAccessUnlessGranted('edit', $establishmentActivity->getEstablishment());
        
        // Creating form
        $form = $this->buildForm($establishmentActivity);
        $form->handleRequest($request);

        // Saving
        if ($form->isValid()) {
            $this->activityService->save($establishmentActivity);
            return $this->redirect(
                    $this->generateUrl('etb_activity_detail', array(
                        '_idEtb' => $_idEtb,
                        '_idAct' => $establishmentActivity->getLevel())
                            ));
        }
        
        // Show form
        return $this->render('establishment/activity/manage.html.twig', array(
            'form' => $form->createView(),
            'activity' => $establishmentActivity
        ));
    }
    
    /**
     * Build the form for editing an activity
     * 
     * @param type $establishmentActivity
     * @return Form
     */
    public function buildform($establishmentActivity) {
        $save_label = $this->get('translator')->trans("establishment.manage.save");
        return $this->createFormBuilder($establishmentActivity)
            ->add('description',    TextType::class)
            ->add('price',          IntegerType::class)
            ->add('activity_type',  EntityType::class,
                                    array(  
                                        'class' => 'AppBundle:ActivityType',
                                        'choice_label' => 'name'))
            ->add('save',           SubmitType::class,
                                    array('label' => $save_label))
            ->getForm();
    }
    
    /**
     * @Route("/manage/etb/{_idEtb}/activity/delete", name="etb_activity_delete")
     */
    public function delete(Request $request, $_idEtb){
        if($request->getMethod("POST")){
            $idAct = $request->get("idAct");
            $establishmentActivity = $this->activityService->get($idAct);
            $this->denyAccessUnlessGranted('edit', $establishmentActivity->getEstablishment());
            $this->activityService->remove($establishmentActivity);
            
            return $this->redirectToRoute('etb_manage_update', array(
                            'id' => $_idEtb
                ));
        }
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * Finds the activity with the given id or creates a new one.
     * @param type $_idEtb Establishment ID
     * @param type $_level Activity level : use 0 to create a new one
     * @return EstablishmentActivity
     * @throws type NotFoundException
     */
    public function getEstablishmentActivity($_idEtb, $_level = 0){
        if($_level != 0){
            $establishmentActivity = $this->activityService->getByEtbAndLevel($_idEtb, $_level);
        }
        // Creating a new one
        else{
            $establishmentActivity = new EstablishmentActivity();
            $etb = $this->establishmentService->get($_idEtb);
            $etb->addActivity($establishmentActivity);
            $establishmentActivity->setEstablishment($etb);
        }
        return $establishmentActivity;
    }
    
    /**
     * Get EstablishmentActivity repository
     * @return type
     */
    public function getRepo(){
        return $this->getDoctrine()->getRepository('AppBundle:EstablishmentActivity');
    }
}


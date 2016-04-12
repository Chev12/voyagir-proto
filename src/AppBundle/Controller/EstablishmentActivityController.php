<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EstablishmentActivity;

class EstablishmentActivityController extends Controller
{
    /**
     * @Route("/etb/{_idEtb}/activity/{_idAct}", name="etb_activity_detail")
     */
    public function indexAction($_idEtb, $_idAct = 0)
    {   
        $rep = $this->getDoctrine()
                    ->getRepository('AppBundle:EstablishmentActivity');
        
        $activity = $rep->findOneBy(array('id' => $_idAct, 'establishment' => $_idEtb));
            
        if (!$activity) {
            throw $this->createNotFoundException(
                'No activity found for id ('.$_idEtb.', '.$_idAct.')'
            );
        }
        $ownerConnected = $this->get('utils.user_security')->verifyOwnership($_idEtb);
        
        return $this->render('establishment/activity/detail.html.twig', array(
            'activity' => $activity,
            'ownerConnected' => $ownerConnected
        ));
    }
    
    /**
     * @Route("/manage/etb/{_idEtb}/activity/{_idAct}", name="etb_activity_update",
     *                            defaults={"_idAct" = 0})
     * @Route("/manage/etb/{_idEtb}/activity/", name="etb_activity_new",
     *                      defaults={"_idAct" = 0})
     */
    public function manageAction( Request $request, $_idEtb, $_idAct = 0)
    {   
        
        $ownerConnected = $this->get('utils.user_security')->verifyOwnership($_idEtb);
        if(!$ownerConnected){
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('AppBundle:EstablishmentActivity');
        
        // Getting an existing activity or a new one
        $establishmentActivity = $this->getEstablishmentActivity($rep, $_idEtb, $_idAct);
        
        // Creating form
        $save_label = $this->get('translator')->trans("establishment.manage.save");
        $form = $this->createFormBuilder($establishmentActivity)
            ->add('description','text')
            ->add('price',      'integer')
            ->add('activity_type','entity', array(  
                                    'class' => 'AppBundle:ActivityType',
                                    'choice_label' => 'name'))
            ->add('save',       'submit', array('label' => $save_label))
            ->getForm();

        $form->handleRequest($request);

        // Saving
        if ($form->isValid()) {
            // Update an existing activity
            if($establishmentActivity->getEstablishment() != null){
                $etb = $establishmentActivity->getEstablishment();
            }
            // Creating a new one, bind with Establishment
            else{
                $etb = $em->getRepository('AppBundle:Establishment')->find($_idEtb);
                $etb->addActivity($establishmentActivity);
                $establishmentActivity->setEstablishment($etb);
            }
            $em->persist($establishmentActivity);
            $em->flush();
            return $this->redirect(
                    $this->generateUrl('etb_activity_detail', array(
                        '_idEtb' => $_idEtb,
                        '_idAct' => $establishmentActivity->getId())
                            ));
        }
        
        // Show form
        return $this->render('establishment/activity/manage.html.twig', array(
            'form' => $form->createView(),
            'activity' => $establishmentActivity
        ));
    }
    
    /**
     * @Route("/manage/etb/{_idEtb}/activity/delete", name="etb_activity_delete")
     */
    public function delete(Request $request, $_idEtb){
        $ownerConnected = $this->get('utils.user_security')->verifyOwnership($_idEtb);
        if(!$ownerConnected){
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        
        if($request->getMethod("POST")){
            $idAct = $request->get("idAct");
            $establishmentActivity = $em->getRepository("AppBundle:EstablishmentActivity")
                                ->find($_idEtb, $idAct);
            $em->remove($establishmentActivity);
            $em->flush();
            
            return $this->redirectToRoute('etb_manage_update', array(
                            'id' => $_idEtb
                ));
        }
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * Finds the activity with the given id or creates a new one.
     * @param type $_rep Doctrine repository
     * @param type $_idEtb Establishment ID
     * @param type $_idAct Activity ID : use 0 to create a new one
     * @return EstablishmentActivity
     * @throws type NotFoundException
     */
    public function getEstablishmentActivity($_rep, $_idAct = 0){
        if($_idAct != 0){
            $activity = $_rep->find($_idAct);

            if (!$activity) {
                throw $this->createNotFoundException(
                    'No activity found for id '.$_idAct
                );
            }
        }
        // Creating a new one
        else{
            $activity = new EstablishmentActivity();
        }
        return $activity;
    }
    
}


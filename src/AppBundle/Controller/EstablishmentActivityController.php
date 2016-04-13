<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\EstablishmentActivity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
        
        return $this->render('establishment/activity/detail.html.twig', array(
            'activity' => $activity
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
        $em = $this->getDoctrine()->getManager();
        
        // Getting an existing activity or a new one
        $establishmentActivity = $this->getEstablishmentActivity($em, $_idEtb, $_idAct);
        $this->denyAccessUnlessGranted('edit', $establishmentActivity->getEstablishment());
        
        // Creating form
        $save_label = $this->get('translator')->trans("establishment.manage.save");
        $form = $this->createFormBuilder($establishmentActivity)
            ->add('description',    TextType::class)
            ->add('price',          IntegerType::class)
            ->add('activity_type',  EntityType::class,
                                    array(  
                                        'class' => 'AppBundle:ActivityType',
                                        'choice_label' => 'name'))
            ->add('save',           SubmitType::class,
                                    array('label' => $save_label))
            ->getForm();

        $form->handleRequest($request);

        // Saving
        if ($form->isValid()) {
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
        $em = $this->getDoctrine()->getManager();
        
        if($request->getMethod("POST")){
            $idAct = $request->get("idAct");
            $establishmentActivity = $em->getRepository('AppBundle:EstablishmentActivity')
                                        ->findOneBy(array('id' => $_idAct, 'establishment' => $_idEtb));
            $this->denyAccessUnlessGranted('edit', $establishmentActivity->getEstablishment());
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
    public function getEstablishmentActivity($_em, $_idEtb, $_idAct = 0){
        if($_idAct != 0){
            $establishmentActivity = $_em->getRepository('AppBundle:EstablishmentActivity')
                                         ->findOneBy(array('id' => $_idAct, 
                                                           'establishment' => $_idEtb));

            if (!$establishmentActivity) {
                throw $this->createNotFoundException(
                    'No activity found for id ('.$_idAct.','.$_idEtb.')'
                );
            }
        }
        // Creating a new one
        else{
            $establishmentActivity = new EstablishmentActivity();
            $etb = $_em->getRepository('AppBundle:Establishment')->find($_idEtb);
            $etb->addActivity($establishmentActivity);
            $establishmentActivity->setEstablishment($etb);
        }
        return $establishmentActivity;
    }
    
}


<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Establishment;

class EstablishmentController extends Controller
{
    /**
     * @Route("/etb/{_id}", name="etb_detail")
     */
    public function indexAction($_id = 0)
    {   
        $rep = $this->getDoctrine()
                    ->getRepository('AppBundle:Establishment');
        
        $establishment = $rep->find($_id);
            
        if (!$establishment) {
            throw $this->createNotFoundException(
                'No establishment found for id '.$_id
            );
        }
        
        $ownerConnected = $this->get('utils.user_security')->verifyOwnership($_id);
        
        return $this->render('establishment/detail.html.twig', array(
            'establishment' => $establishment,
            'activities' => $establishment->getActivities(),
            'ownerConnected' => $ownerConnected
        ));
    }
    
    /**
     * @Route("/manage/etb/{_id}", name="etb_manage_update",
     *                            defaults={"_id" = 0})
     * @Route("/manage/etb/", name="etb_manage_create",
     *                      defaults={"_id" = 0})
     */
    public function manageAction( Request $request, $_id = 0)
    {   
        $ownerConnected = $this->get('utils.user_security')->verifyOwnership($_id);
        if(!$ownerConnected){
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('AppBundle:Establishment');
        
        // Getting an existing establishment or a new one
        $establishment = $this->getEstablishment($rep, $_id);
        
        // Creating form
        $save_label = $this->get('translator')->trans("establishment.manage.save");
        $form = $this->createFormBuilder($establishment)
            ->add('name',       TextType)
            ->add('description',TextType)
            ->add('adress',     TextType)
            ->add('save',       SubmitType, array('label' => $save_label))
            ->getForm();

        $form->handleRequest($request);

        // Saving
        if ($form->isValid()) {
            $em->persist($establishment);
            $em->flush();
            return $this->redirect($this->generateUrl('etb_detail').'/'.$establishment->getId());
        }
        
        // Show form
        return $this->render('establishment/manage.html.twig', array(
            'form' => $form->createView(),
            'establishment' => $establishment,
            'activities' => $establishment->getActivities()
        ));
    }
    
    /**
     * @Route("/delete", name="etb_manage_delete")
     */
    public function delete(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        
        if($request->getMethod("POST")){
            $id = $request->get("id");
            $establishment = $em->getRepository("AppBundle:Establishment")
                                ->find($id);
            $this->denyAccessUnlessGranted('ROLE_USER', $establishment);
            $em->remove($establishment);
            $em->flush();
        }
        
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * Finds the establishment with the given id or creates a new one.
     * @param type $_rep Doctrine repository
     * @param type $_id Establishment ID : use 0 to create a new one
     * @return Establishment
     * @throws type NotFoundException
     */
    public function getEstablishment($_rep, $_id){
        if($_id != 0){
            $establishment = $_rep->find($_id);

            if (!$establishment) {
                throw $this->createNotFoundException(
                    'No establishment found for id '.$_id
                );
            }
        }
        // Creating a new one
        else{
            $establishment = new Establishment();
            $establishment->setIdUserOwner($this->getUser());
        }
        return $establishment;
    }
}


<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Controller\ControllerSpecial;
use AppBundle\Entity\Commitment;

/**
 * Description of CommitmentController
 *
 * @author Mat
 */
class CommitmentController extends ControllerSpecial {
    
    /**
     * @var AppBundle\Services\Business\CommitmentService
     */
    private $commitmentService;
    
    public function init(){
        $this->commitmentService = 
                $this->get( 'app.business_service_factory' )
                     ->build( 'Commitment' );
    }
    
    /**
     * @Route("/admin/commitment/{_id}", name="cmt_admin_update",
     *                            defaults={"_id" = 0})
     * @Route("/admin/commitment/", name="cmt_admin_create",
     *                      defaults={"_id" = 0})
     */
    public function adminAction ( Request $request, $_id = 0 )
    {
        // Getting an existing establishment or a new one
        $commitment = $this->getCommitment ( $_id );
        
        // Creating form
        $form = $this->buildForm ( $commitment );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $commitment = $this->commitmentService->save( $commitment );
            return $this->forward('AppBundle:Admin\Admin:index');
        }
        
        // Show form
        return $this->render( 'admin/commitment/manage.html.twig', array(
            'form' => $form->createView(),
            'commitment' => $commitment
        ));
    }
    
    /**
     * Create the commitment form
     * @param Commitment $commitment
     * @return Form
     */
    function buildForm ( $commitment )
    {
        $save_label = $this->get( 'translator' )->trans( "establishment.manage.save" );
        return $this->createFormBuilder($commitment)
            ->add( 'description',TextType::class )
            ->add( 'icon',       TextType::class )
            ->add( 'save',       SubmitType::class, array( 'label' => $save_label ))
            ->getForm();
    }
    
    /**
     * Finds the commitment with the given id or creates a new one.
     * @param type $_id Establishment ID : use 0 to create a new one
     * @return Commitment
     * @throws type NotFoundException
     */
    public function getCommitment($_id){
        if($_id != 0){
            $commitment = $this->commitmentService->get( $_id );
        }
        // Creating a new one
        else{
            $commitment = new Commitment();
        }
        return $commitment;
    }
}

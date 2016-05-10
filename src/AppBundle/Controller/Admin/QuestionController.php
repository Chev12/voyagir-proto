<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Admin\Form\QuestionType;
use AppBundle\Controller\ControllerSpecial;
use AppBundle\Entity\Question;

/**
 * Description of QuestionController
 *
 * @author Mat
 */
class QuestionController extends ControllerSpecial {
    
    /**
     * @var AppBundle\Services\Business\QuestionService
     */
    private $questionService;
    
    public function init(){
        $this->questionService = $this->getBusinessService ( 'CommitmentQuestion' );
    }
    
    /**
     * @Route("/admin/question/{_id}", name="qtn_admin_update",
     *                            defaults={"_id" = 0})
     * @Route("/admin/question/", name="qtn_admin_create",
     *                      defaults={"_id" = 0})
     */
    public function adminAction ( Request $request, $_id = 0 )
    {
        // Getting an existing question or a new one
        $question = $this->getQuestion ( $_id );
        
        // Creating form
        $form = $this->createForm ( QuestionType::class );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $question = $this->questionService->save( $question );
            return $this->forward('AppBundle:Admin\Admin:index');
        }
        
        // Show form
        return $this->render( 'admin/basicAdmin.html.twig', array(
            'object_name' => 'Controller',
            'form' => $form->createView(),
            'question' => $question
        ));
    }
    
    /**
     * Finds the question with the given id or creates a new one.
     * @param type $_id Question ID : use 0 to create a new one
     * @return Question
     * @throws type NotFoundException
     */
    public function getQuestion($_id){
        if($_id != 0){
            $question = $this->questionService->get( $_id );
        }
        // Creating a new one
        else{
            $question = new Question();
        }
        return $question;
    }
}

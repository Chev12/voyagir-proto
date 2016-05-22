<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Admin\Form\CategoryType;
use AppBundle\Controller\ControllerSpecial;
use AppBundle\Entity\Category;

/**
 * Description of CategoryController
 *
 * @author Mat
 */
class CategoryController extends ControllerSpecial {
    
    /**
     * @var AppBundle\Services\Business\CategoryService
     */
    private $categoryService;
    
    public function init(){
        $this->categoryService = $this->getBusinessService ( 'Category' );
    }
    
    /**
     * @Route("/admin/category/{_id}", name="cat_admin_update",
     *                            defaults={"_id" = 0})
     * @Route("/admin/category/", name="cat_admin_create",
     *                      defaults={"_id" = 0})
     */
    public function adminAction ( Request $request, $_id = 0 )
    {
        // Getting an existing category or a new one
        $category = $this->getCategory ( $_id );
        
        // Creating form
        $form = $this->createForm ( CategoryType::class, $category );
        $form->handleRequest ( $request );

        // Saving
        if ( $form->isValid() ) {
            $category = $this->categoryService->saveWithParent( $category, $form->get('parent')->getData() );
            return $this->forward('AppBundle:Admin\Admin:index');
        }
        
        // Show form
        return $this->render( 'admin/category.html.twig', array(
            'object_name' => 'Controller',
            'form' => $form->createView(),
            'category' => $category
        ));
    }
    
    /**
     * @Route("admin/delete/cat", name="cat_admin_delete")
     */
    public function deleteAction( Request $request ){
        if($request->getMethod( "POST" )){
            $id = $request->get( "idCat" );
            $category = $this->categoryService->get( $id );
            $this->categoryService->remove( $category );
        }
        
        return $this->redirectToRoute( 'admin_home' );
    }
    
    /**
     * Finds the category with the given id or creates a new one.
     * @param type $_id Category ID : use 0 to create a new one
     * @return Category
     * @throws type NotFoundException
     */
    public function getCategory ( $_id ) {
        if ( $_id != 0 ) {
            $category = $this->categoryService->getWithParents( $_id );
        }
        // Creating a new one
        else{
            $category = new Category();
        }
        return $category;
    }
}

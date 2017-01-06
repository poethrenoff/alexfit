<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    /**
     * Catalogue menu
     */
    public function menuAction(Request $request)
    {
        $catalogueList = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Catalogue')->findAll();
        
        return $this->render('AppBundle::Product/menu.html.twig', array(
           'catalogueList' => $catalogueList
        ));
    }
    
    /**
     * Catalogue item
     * 
     * @Route("/product/{catalogueName}", name="catalogueItem")
     */
    public function catalogueAction(Request $request, $catalogueName)
    {
        $catalogueItem = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Catalogue')->findOneByCatalogueName($catalogueName);
        
        if (!$catalogueItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        return $this->render('AppBundle::Product/catalogueItem.html.twig', array(
            'catalogueItem' => $catalogueItem
        ));
    }
    
    /**
     * Category item
     * 
     * @Route("/product/{catalogueName}/{categoryName}", name="categoryItem")
     */
    public function categoryAction(Request $request, $catalogueName, $categoryName)
    {
        $categoryItem = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Category')->findOneByCategoryName($categoryName);
        
        if (!$categoryItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        return $this->render('AppBundle::Product/categoryItem.html.twig', array(
            'categoryItem' => $categoryItem
        ));
    }
    
    /**
     * Product item
     * 
     * @Route("/product/{catalogueName}/{categoryName}/{id}", name="productItem")
     */
    public function productAction(Request $request, $catalogueName, $categoryName, $id)
    {
        $productItem = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Product')->find($id);
        
        if (!$productItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        return $this->render('AppBundle::Product/productItem.html.twig', array(
            'productItem' => $productItem
        ));
    }
}

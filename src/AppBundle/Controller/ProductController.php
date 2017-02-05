<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Lib\Pager;

class ProductController extends Controller
{
    /**
     * Catalogue menu
     */
    public function menuAction(Request $request)
    {
        $catalogueList = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Catalogue')->findAllActive();
        
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
        
        return $this->render('AppBundle::Product/catalogue.html.twig', array(
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
        
        return $this->render('AppBundle::Product/category.html.twig', array(
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
            ->getRepository('AppBundle:Product')->findActive($id);
        
        if (!$productItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        return $this->render('AppBundle::Product/product.html.twig', array(
            'productItem' => $productItem
        ));
    }
    
    /**
     * Search result
     * 
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $limit = 20;
        $page = max(1, $request->query->getInt('page', 1));
        $offset = ($page - 1) * $limit;

        $productList = array();
        
        $text = $request->query->get('text');
        if ($text !== '') {
            $productList = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Product')->findByText($text, $offset, $limit);
        }
        
        return $this->render('AppBundle::Product/result.html.twig', array(
            'productList' => $productList,
            'text' => $text,
            'count' => count($productList),
            'offset' => $offset,
            'pager' => Pager::create(count($productList), $limit, $page),
        ));
    }
    
    /**
     * Pricelist
     * 
     * @Route("/price", name="price")
     */
    public function priceAction(Request $request)
    {
        $catalogueList = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Catalogue')->findAllActive();
        
        return $this->render('AppBundle::Product/price.html.twig', array(
           'catalogueList' => $catalogueList
        ));
    }
}

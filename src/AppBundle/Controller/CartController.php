<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * Cart view
     * 
     * @Route("/cart", name="cart")
     */
    public function indexAction(Request $request)
    {
        $cart = $this->get('cart');
        
        $productList = array();
        foreach ($cart->getItems() as $item ) {
            $productList[$item->id] = $this->getProduct($item->id);
        }
        
        return $this->render('AppBundle::Cart/cart.html.twig', array(
            'cart' => $this->get('cart'), 'productList' => $productList
        ));
    }
    
    /**
     * Cart info
     * 
     * @Route("/cart/info", name="cart.info")
     */
    public function infoAction(Request $request)
    {
        return $this->render('AppBundle::Cart/info.html.twig', array(
            'cart' => $this->get('cart')
        ));
    }

    /**
     * Add product
     * 
     * @Route("/cart/add/{id}", name="cart.add")
     */
    public function addAction(Request $request, $id)
    {
        $productItem = $this->getProduct($id);
        
        $quantity = max(1, intval($request->query->get('quantity')));
        
        $this->get('cart')->add($productItem->getProductId(), $productItem->getProductPrice(), $quantity);
        
        return $this->infoAction($request);
    }

    /**
     * Inc product
     * 
     * @Route("/cart/inc/{id}", name="cart.inc")
     */
    public function incAction(Request $request, $id)
    {
        $quantity = max(1, intval($request->query->get('quantity')));
        
        $this->get('cart')->inc($id, $quantity);
        
        return $this->infoAction($request);
    }

    /**
     * Dec product
     * 
     * @Route("/cart/dec/{id}", name="cart.dec")
     */
    public function decAction(Request $request, $id)
    {
        $quantity = max(1, intval($request->query->get('quantity')));
        
        $this->get('cart')->dec($id, $quantity);
        
        return $this->infoAction($request);
    }
    
    /**
     * Delete product
     * 
     * @Route("/cart/delete/{id}", name="cart.delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $this->get('cart')->delete($id);
        
        return $this->redirectToRoute('cart');
    }

    /**
     * Clear cart
     * 
     * @Route("/cart/clear", name="cart.clear")
     */
    public function clearAction(Request $request)
    {
        $this->get('cart')->clear();
        
        return $this->redirectToRoute('cart');
    }
    
    /**
     * Get product
     */
    protected function getProduct($id)
    {
        $productItem = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Product')->find($id);

        if (!$productItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        return $productItem;
    }
}

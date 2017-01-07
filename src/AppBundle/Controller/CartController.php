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
            $productList[$item->id] = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Product')->find($item->id);
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
        $productItem = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Product')->find($id);
        
        if (!$productItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        $quantity = max(1, intval($request->query->get('quantity')));
        
        $this->get('cart')->add($productItem->getProductId(), $productItem->getProductPrice(), $quantity);
        
        return $this->infoAction($request);
    }

    /**
     * Save cart
     * 
     * @Route("/cart/save", name="cart.save")
     */
    public function saveAction(Request $request)
    {
        if ($request->isMethod('post')) {
            $cart = $request->get('cart');
            
            if (is_array($cart)) {
                $this->get('cart')->clear();
                
                foreach ($cart as $id => $quantity) {
                    $productItem = $this->getDoctrine()->getManager()
                        ->getRepository('AppBundle:Product')->find($id);

                    if (!$productItem) {
                        throw new NotFoundHttpException('Страница не найдена');
                    }                    
                    
                    $quantity = max(1, intval($quantity));
                    $this->get('cart')->add(
                        $productItem->getProductId(), $productItem->getProductPrice(), $quantity
                    );
                }
            }
        }
        
        return $this->infoAction($request);
    }
    
    
    
    protected function actionSave()
    {
        if (!empty($_POST)) {
            if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
                Cart::factory()->clear();

                foreach ($_POST['quantity'] as $id => $quantity) {
                    $product = $this->getProduct($id);
                    $quantity = max(1, intval($quantity));
                    Cart::factory()->add(
                        $product->getId(), $product->getProductPrice(), $quantity
                    );
                }
            }
        }
        $this->actionInfo();
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
}

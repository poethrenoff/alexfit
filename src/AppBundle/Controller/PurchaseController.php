<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Purchase;
use AppBundle\Entity\PurchaseItem;
use AppBundle\Form\PurchaseType;

class PurchaseController extends Controller
{
    /**
     *  Purchase order
     * 
     * @Route("/purchase", name="purchase")
     */
    public function indexAction(Request $request)
    {
        $flush = $this->get('session')->getFlashBag();
        
        foreach ($flush->get('success') as $message) {
            if ($message) {
                return $this->render('AppBundle::Purchase/success.html.twig');
            }
        }
        
        $cart = $this->get('cart');
        
        $productList = array();
        foreach ($cart->getItems() as $item ) {
            $productList[$item->id] = $this->getProduct($item->id);
        }
        
        $form = $this->createForm(PurchaseType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            
            try {
                $purchase = $form->getData();
                $purchase->setPurchaseSum($cart->getSum());
                
                foreach ($cart->getItems() as $item ) {
                    $purchaseItem = new PurchaseItem();
                    $purchaseItem
                        ->setItemPurchase($purchase)
                        ->setItemProduct($productList[$item->id])
                        ->setItemPrice($item->price)
                        ->setItemQuantity($item->quantity);
                    $purchase->addItem($purchaseItem);
                }
                
                $em->persist($purchase);
                $em->flush();
               
                $this->sendMessages($purchase);
                
                $em->getConnection()->commit();
            } catch (\Exception $e) {
                $em->getConnection()->rollBack();
                throw $e;
            }
            

            $cart->clear();
            
            $flush->add('success', true);
            
            return $this->redirectToRoute('purchase');
        }
        
        return $this->render('AppBundle::Purchase/form.html.twig', array(
            'cart' => $this->get('cart'), 'productList' => $productList, 'form' => $form->createView(),
        ));
    }
    
    /**
     * Send messages
     */
    protected function sendMessages($purchase)
    {
        $preference = $this->get('preference');

        $from_email = $preference->get('from_email');           
        $from_name = $preference->get('from_name');

        $manager_email= $preference->get('manager_email');           
        $manager_subject = sprintf(
            $preference->get('manager_subject'), $purchase->getPurchaseId()
        );
        $client_subject = $preference->get('client_subject');     

        $manager_message = \Swift_Message::newInstance()
            ->setSubject($manager_subject)
            ->setFrom($from_email, $from_name)
            ->setTo($manager_email)
            ->setBody(
                 $this->renderView('AppBundle::Purchase/manager_mail.html.twig', array(
                    'purchase' => $purchase
                )),
                'text/html'
            );
        $this->get('mailer')->send($manager_message);

        $client_message = \Swift_Message::newInstance()
            ->setSubject($client_subject)
            ->setFrom($from_email, $from_name)
            ->setTo($purchase->getPurchaseEmail())
            ->setBody(
                 $this->renderView('AppBundle::Purchase/client_mail.html.twig', array(
                    'purchase' => $purchase
                )),
                'text/html'
            );
        $this->get('mailer')->send($client_message);
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

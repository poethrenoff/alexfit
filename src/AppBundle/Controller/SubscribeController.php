<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\SubscribeType;

class SubscribeController extends Controller
{
    /**
     * Subscribe form
     * 
     * @Route("/subscribe", name="subscribe")
     */
    public function indexAction(Request $request)
    {
        $flush = $this->get('session')->getFlashBag();
        
        foreach ($flush->get('success') as $message) {
            if ($message) {
                return $this->render('AppBundle::Subscribe/success.html.twig');
            }
        }
        
        $form = $this->createForm(SubscribeType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $preference = $this->get('preference');
            
            $from_email = $preference->get('from_email');           
            $from_name = $preference->get('from_name');           
            $subscribe_email = $preference->get('subscribe_email');           
            $subscribe_subject = $preference->get('subscribe_subject');           
            
            $message = \Swift_Message::newInstance()
                ->setSubject($subscribe_subject)
                ->setFrom($from_email, $from_name)
                ->setTo($subscribe_email)
                ->setBody(
                     $this->renderView('AppBundle::Subscribe/mail.html.twig', array(
                        'subscribe' => $form->getData(), 'types' => SubscribeType::$types
                    )),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            
            $flush->add('success', true);
            
            return $this->redirectToRoute('subscribe');
        }
        
        return $this->render('AppBundle::Subscribe/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

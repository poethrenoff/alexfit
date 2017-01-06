<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubscribeController extends Controller
{
    /**
     * Subscribe form
     * 
     * @Route("/subscribe", name="subscribe")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle::Subscribe/form.html.twig', array(
            //
        ));
    }
}

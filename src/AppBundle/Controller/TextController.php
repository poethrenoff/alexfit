<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TextController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Route("/about", name="about")
     * @Route("/fitnesscenter", name="fitnesscenter")
     * @Route("/complex", name="complex")
     * @Route("/service", name="service")
     * @Route("/tobuy", name="tobuy")
     * @Route("/delivery", name="delivery")
     * @Route("/contact", name="contact")
     */
    public function textAction(Request $request)
    {
        $currentRoute = $request->get('_route');
        
        $textItem = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Text')->findOneByTextName($currentRoute);
        
        if (!$textItem) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        
        return $this->render('AppBundle::Text/textItem.html.twig', array(
            'textItem' => $textItem
        ));
    }
}

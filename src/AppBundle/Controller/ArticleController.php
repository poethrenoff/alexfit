<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
    public function articleAction(Request $request)
    {
        return $this->render('AppBundle::Article/article.html.twig', array(
            'articleList' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')
                ->findAll()
        ));
    }
    
    /**
     * @Route("/article/{id}", name="articleItem")
     */
    public function articleItemAction(Request $request, $id)
    {
        $articleItem = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')
            ->find($id);
        
        if (!$articleItem) {
            throw new NotFoundHttpException('Cтатья не найдена');
        }
        
        return $this->render('AppBundle::Article/articleItem.html.twig', array(
            'articleItem' => $articleItem
        ));
    }
}

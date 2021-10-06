<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
/**
     * @Route("/article", name="article")
     */
    public function index(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class,$article);
        if ($request->isMethod('POST')) { 
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                $this->addFlash('notice', 'Article inséré');
            }
            return $this->redirectToRoute('article');
        } 
        return $this->render('article/index.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}

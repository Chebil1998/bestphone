<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTime;

use App\Entity\Article;
use App\Form\ArticleType;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
 public function index()
    {   $repo=$this->getDoctrine()->getRepository(Article::class);
    	$articles=$repo->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles'=>$articles
        ]);
    }
 /**
     * @Route("/article/new", name="create_article")
     */
    public function create(Request $request)
    {   $article=new Article();
    	$form=$this->createForm(ArticleType::class, $article)->add('Enregistrer', SubmitType::class);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){
    		$article->setCreatedAt(new \DateTime());

        $em =$this->getDoctrine()->getManager();
    		$em->persist($article);
    		$em->flush();

     
            return $this->redirectToRoute('article');
    	}
        return $this->render('article/create.html.twig', ['formArticle' => $form->createView()]);
    }
    /**
     * @Route("/article/{id}", name="show_article")
     */
    public function show(Article $article){
    	
    	return $this->render('article/show.html.twig', ['article'=>$article]);
        return $this->redirectToRoute('article');
    }

     /**
    * @Route("/article/{id}/edit", name="edit_article")
    */
   public function edit(Article $article, Request $request)
{
        $form=$this->createForm(ArticleType::class, $article)->add('Enregistrer', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setCreatedAt(new \DateTime());

        $em =$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

      
            return $this->redirectToRoute('article');
        }
        return $this->render('article/edit.html.twig', ['formArticle' => $form->createView()]);
  
}

/**
     * @Route("/delete/{id}", name="delete_article")

     */
    public function delete(Article $article){
       
    
        $em =$this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
       
     return $this->redirectToRoute('article');
    }


     /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('article/home.html.twig');
    }
}

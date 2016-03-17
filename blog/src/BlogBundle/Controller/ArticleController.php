<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleController extends Controller
{
    public function indexAction()
    {
       
        if(!empty($this->getUser()))
            return $this->redirectToRoute('article_all');
        else
            return $this->redirectToRoute('article_all');
            // return $this->render('BlogBundle:Article:index.html.twig');
            
    }
    public function allAction(Request $request)
    {
        // all a task and give it some dummy data for this example
        $article = new Article();
        // $article->setArticle('Write a blog post');
        if(!empty($this->getUser())){
            $article->setDate(new \DateTime());
            $article->setAuthor($this->getUser());
        }

        $form = $this->createFormBuilder($article)
                ->add('title', TextType::class)
                ->add('content', TextType::class)
                ->add('submit', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);
        $articles = $this->getDoctrine()->getRepository('BlogBundle:Article')->findAll();

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_all');
        }

        return $this->render('BlogBundle:Article:all.html.twig', array(
            'form' => $form->createView(),
            'articles' => $articles
        ));
    }

    public function editAction()
    {
        return $this->render('BlogBundle:Article:edit.html.twig');
    }
    // public function allAction()
    // {
    //     $articles = $this->getDoctrine()->getRepository('BlogBundle:Article')->findAll();
    //     return $this->render('BlogBundle:Article:all.html.twig',["articles"=>$articles]);
    // }
    public function removeAction()
    {
        return $this->render('BlogBundle:Article:remove.html.twig');
    }
    public function pageAction()
    {
        return $this->render('BlogBundle:Article:page.html.twig');
    }
    public function displayByIdAction($id)
    {
        $article = $this->getDoctrine()->getRepository('BlogBundle:Article')->find($id);
        return $this->render('BlogBundle:Article:id.html.twig',["article"=>$article]);
    }
    public function displayByTitleAction($title)
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getRepository('BlogBundle:Article');
        $article = $manager->findOneByTitle($title); 
        if ($article)
            return $this->render('BlogBundle:Article:title.html.twig', ["article"=>$article]);
        else
            throw $this->createNotFoundException('No product found for title '.$title);
    }
    /*
        Pour chaque manager vous aurez les méthodes suivantes :
        findAll() -> récupère toute la liste des éléments
        find($id) -> qui va chercher un élément par son id
        findByProperty($value) -> qui va chercher tous les éléments ayant Property $value
        findOneByProperty($value) -> qui va chercher le premier éléments ayant Property $value
    */
}
       
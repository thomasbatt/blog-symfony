<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function createAction()
    {
        return $this->render('BlogBundle:Article:create.html.twig');
    }
    public function displayAllAction()
    {
		$articles = $this->getDoctrine()->getRepository('BlogBundle:Article')->findBy([], ['date'=>'desc'], 10);
    	return $this->render('BlogBundle:Article:articles.html.twig', ["articles"=>$articles]);
    }
    public function displayByIdAction($id)
    {
		$doctrine = $this->getDoctrine();
		$manager = $doctrine->getRepository('BlogBundle:Article');
		$article = $manager->find($id);
    	return $this->render('BlogBundle:Article:article.html.twig', ["article"=>$article]);
    }
    public function displayByTitleAction($title)
    {
		$doctrine = $this->getDoctrine();
		$manager = $doctrine->getRepository('BlogBundle:Article');
		$article = $manager->findOneByTitle($title);
		if ($article)
    		return $this->render('BlogBundle:Article:article.html.twig', ["article"=>$article]);
    	else
    		throw $this->createNotFoundException('No product found for title '.$title);
    }
}

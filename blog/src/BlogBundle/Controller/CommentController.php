<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentController extends Controller
{
    public function createAction(Request $request, $id)
    {
        // all a task and give it some dummy data for this example
        $comment = new Comment();
        // $comment->setcomment('Write a blog post');
        if(!empty($this->getUser())){
            $article = $this->getDoctrine()->getRepository('BlogBundle:Article')->findOneById($id);
            $comment->setArticle( $article );
            $comment->setDate(new \DateTime());
            $comment->setAuthor($this->getUser());
        }
        $form = $this->createFormBuilder($comment)
                ->setAction($this->generateUrl('comment_create', ['id'=> $article->getId() ] ))
                ->add('content', TextareaType::class)
                ->add('submit', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('article_display_title', ["title"=>$article->getTitle()]);
        }

        return $this->render('BlogBundle:Comment:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function allAction(Request $request)
    {
        // all a task and give it some dummy data for this example
        $comment = new Comment();
        // $comment->setcomment('Write a blog post');
        if(!empty($this->getUser())){
            $comment->setDate(new \DateTime());
            $comment->setAuthor($this->getUser());
        }
        $form = $this->createFormBuilder($comment)
                // ->setAction($this->generateUrl('comment_all'))
                ->add('content', TextareaType::class)
                ->add('submit', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);
        $comments = $this->getDoctrine()->getRepository('BlogBundle:Comment')->findAll();

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_all');
        }

        return $this->render('BlogBundle:Comment:all.html.twig', array(
            'form' => $form->createView(),
            'comments' => $comments
        ));
    }

    /*
        Pour chaque manager vous aurez les méthodes suivantes :
        findAll() -> récupère toute la liste des éléments
        find($id) -> qui va chercher un élément par son id
        findByProperty($value) -> qui va chercher tous les éléments ayant Property $value
        findOneByProperty($value) -> qui va chercher le premier éléments ayant Property $value
    */
}
       
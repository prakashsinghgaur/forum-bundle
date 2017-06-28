<?php

namespace PrakashSinghGaur\ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PrakashSinghGaur\ForumBundle\Entity\Forum;
use PrakashSinghGaur\ForumBundle\Entity\Topic;
use PrakashSinghGaur\ForumBundle\Entity\Comment;
use \DateTime;
use Symfony\Component\BrowserKit\Response;

class CommentController extends Controller
{
    /**
     * @Route("/forum/topic/comment/{id}", name="comment_list")
     */
    public function indexAction($id, Request $request)
    {
        
        $topic = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Topic')->find($id);
        $comments = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Comment')->findBy(array('topic'=>$topic));
        $forum = $topic->getForum();
        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
                ->add('description')
                ->add('save','submit')
                ->getForm();

        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $comment->setTopic($topic);
                $comment->setCreatedOn(new \DateTime('now'));
                $em->persist($comment);
                $em->flush();
                $this->addFlash(
                'notice',
                'comment posted'
                );

                 return $this->redirectToRoute('comment_list', array('id' => $topic->getId()));
    }

        return $this->render('PrakashSinghGaurForumBundle:comment:index.html.twig', array(
            'forum' => $forum,
            'topic' => $topic,
            'comments' => $comments,
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/forum/topic/comment/edit/{id}", name="comment_edit")
     */
    public function editAction($id,Request $request){

        $comment = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Comment')->find($id);
        $topic = $comment->getTopic();
        $forum = $topic->getForum();

        $comment->setDescription($comment->getDescription());

        $form = $this->createFormBuilder($comment)
                ->add('description')
                ->add('save','submit')
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $description = $form['description']->getData();
            $em = $this->getDoctrine()->getManager();
            $comment->setDescription($description);            
            $em->flush();

            $this->addFlash(
                'notice',
                'Comment Updated'
                );

            return $this->redirectToRoute('comment_list', array('id'=>$topic->getId()));
        }

        return $this->render('PrakashSinghGaurForumBundle:comment:edit.html.twig', array(
            'forum' => $forum,
            'topic'=>$topic,
            'comment'=>$comment,
            'form' => $form->createView()

            ));
    }

    /**
     * @Route("/forum/topic/delete/{id}", name="forumtopic_delete")
     */
    public function deleteAction($id, Request $request){


        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository('PrakashSinghGaurForumBundle:Topic')->find($id);

        $forum = $topic->getForum();

        $em2 = $this->getDoctrine()->getManager();
        $comment = $em2->getRepository('PrakashSinghGaurForumBundle:Comment')->findBy(array('topic' => $topic));

        if($comment){
            $this->addFlash(
                'warning',
                'Topic cannot be removed, as there are some comments in refernce.'
                );
        }
        else{

            $em->remove($topic);
            $em->flush();

            $this->addFlash(
                    'notice',
                    'Topic Deleted'
                    );
        }
            return $this->redirectToRoute('forumtopic_list', array('id'=>$forum->getId()));
    }
}

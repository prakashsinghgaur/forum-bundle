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
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

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
                ->add('description', CKEditorType::class, array('config_name' => 'my_config'))
                ->add('save','submit')
                ->getForm();

        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $comment->setTopic($topic);
                $comment->setCreatedBy($this->get('security.token_storage')->getToken()->getUser());
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
        $activeUser = $this->get('security.token_storage')->getToken()->getUser();

        if(!$comment->getCreatedBy() == $activeUser){
            throw $this->createAccessDeniedException('You are not author of this content');
        }
        $topic = $comment->getTopic();
        $forum = $topic->getForum();

        $comment->setDescription($comment->getDescription());

        $form = $this->createFormBuilder($comment)
                ->add('description', CKEditorType::class, array('config_name' => 'my_config'))
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
     * @Route("/forum/comment/delete/{id}", name="forumcomment_delete")
     */
    public function deleteAction($id, Request $request){


        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('PrakashSinghGaurForumBundle:Comment')->find($id);
        $forum = $comment->getTopic()->getForum();

        $activeUser = $this->get('security.token_storage')->getToken()->getUser();

        if(!$comment->getCreatedBy() == $activeUser){
            throw $this->createAccessDeniedException('You are not author of this content');
        }

            $em->remove($comment);
            $em->flush();

            $this->addFlash(
                    'notice',
                    'Comment Deleted'
                    );
            return $this->redirectToRoute('forumtopic_list', array('id'=>$forum->getId()));
    }
}

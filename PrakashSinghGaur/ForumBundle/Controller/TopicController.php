<?php

namespace PrakashSinghGaur\ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PrakashSinghGaur\ForumBundle\Entity\Forum;
use PrakashSinghGaur\ForumBundle\Entity\Topic;
use \DateTime;
use Symfony\Component\BrowserKit\Response;

class TopicController extends Controller
{
    /**
     * @Route("/forum/topic/{id}", name="forumtopic_list")
     */
    public function indexAction($id, Request $request)
    {
        $forum = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Forum')->find($id);
        $topics = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Topic')->findBy(array('forum'=>$forum));



        return $this->render('PrakashSinghGaurForumBundle:Topic:index.html.twig', array(
            'forum' => $forum,
            'topics' => $topics,
        ));
    }

    /**
     * @Route("/forum/topic/add/{id}", name="topic_add")
     */
    public function createAction($id, Request $request)
    {

    	$topic = new Topic();
        $forum = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Forum')->find($id);
        $form = $this->createFormBuilder($topic)
            ->add('title')
            ->add('description')
            ->add('save','submit')
            ->getForm();
                
	     $form->handleRequest($request);
	     if ($form->isSubmitted() && $form->isValid()) {
        	    $em = $this->getDoctrine()->getManager();
                //$forum->setTitle()
                $topic->setForum($forum);
                $topic->setCreatedOn(new \DateTime('now'));
			    $em->persist($topic);
    			$em->flush();
                $this->addFlash(
                'notice',
                'Forum topic created'
                );

                 return $this->redirectToRoute('forumtopic_list', array('id' => $id));
    }

        return $this->render('PrakashSinghGaurForumBundle:Forum:create.html.twig', array(
            'forum' => $forum,
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/forum/topic/edit/{id}", name="forumtopic_edit")
     */
    public function editAction($id,Request $request){

        $topic = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Topic')->find($id);
        $forum = $topic->getForum();

        $topic->setTitle($topic->getTitle());
        $topic->setDescription($topic->getDescription());

        $form = $this->createFormBuilder($topic)
                ->add('title')
                ->add('description', 'ckeditor', array('config_name' => 'my_config', 'label'=>'Topic description'))
                ->add('save','submit')
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $title = $form['title']->getData();
            $description = $form['description']->getData();
            $em = $this->getDoctrine()->getManager();
            $topic->setTitle($title);            
            $topic->setDescription($description);            
            $em->flush();

            $this->addFlash(
                'notice',
                'Topic Updated'
                );

            return $this->redirectToRoute('forumtopic_list', array('id'=>$forum->getId()));
        }

        return $this->render('PrakashSinghGaurForumBundle:Forum:edit.html.twig', array(
            'forum' => $forum,
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

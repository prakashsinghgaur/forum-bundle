<?php

namespace PrakashSinghGaur\ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PrakashSinghGaur\ForumBundle\Entity\Forum;
use Symfony\Component\BrowserKit\Response;

class ForumController extends Controller
{
    /**
     * @Route("/forum", name="forum_list")
     */
    public function indexAction(Request $request)
    {

        $forums = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Forum')->findAll();
        return $this->render('PrakashSinghGaurForumBundle:Forum:index.html.twig', array(
            'forums' => $forums,
        ));
    }

    /**
     * @Route("/forum/add", name="forum_add")
     */
    public function createAction(Request $request)
    {

    	$forum = new Forum();

        $form = $this->createFormBuilder($forum)
            ->add('title')
            ->add('save','submit')
            ->getForm();
                
	     $form->handleRequest($request);
	     if ($form->isSubmitted() && $form->isValid()) {
        	    $em = $this->getDoctrine()->getManager();
                //$forum->setTitle()
			    $em->persist($forum);
    			$em->flush();
                $this->addFlash(
                'notice',
                'Discussion Forum Created'
                );

                 return $this->redirectToRoute('forum_list');
    }

        return $this->render('PrakashSinghGaurForumBundle:Forum:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/forum/edit/{id}", name="forum_edit")
     */
    public function editAction($id,Request $request){

        $forum = $this->getDoctrine()->getRepository('PrakashSinghGaurForumBundle:Forum')->find($id);

        $forum->setTitle($forum->getTitle());

        $form = $this->createFormBuilder($forum)
                ->add('title')
                ->add('save','submit')
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $title = $form['title']->getData();
            $em = $this->getDoctrine()->getManager();
            $forum->setTitle($title);            
            $em->flush();

            $this->addFlash(
                'notice',
                'Forum Updated'
                );

            return $this->redirectToRoute('forum_list');
        }

        return $this->render('PrakashSinghGaurForumBundle:Forum:edit.html.twig', array(
            'forum' => $forum,
            'form' => $form->createView()

            ));
    }

    /**
     * @Route("/forum/delete/{id}", name="forum_delete")
     */
    public function deleteAction($id, Request $request){


        $em = $this->getDoctrine()->getManager();
        $forum = $em->getRepository('PrakashSinghGaurForumBundle:Forum')->find($id);

        $em2 = $this->getDoctrine()->getManager();
        $topic = $em2->getRepository('PrakashSinghGaurForumBundle:Topic')->findBy(array('forum' => $forum));

        if($topic){
            $this->addFlash(
                'warning',
                'Forum cannot be removed, as there are some topics in refernce.'
                );
        }
        else{

            $em->remove($forum);
            $em->flush();

            $this->addFlash(
                    'notice',
                    'Forum Deleted'
                    );
        }
            return $this->redirectToRoute('forum_list');
    }
}

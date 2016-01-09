<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\EventListener\PostListener;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        $msg = $this->container->get('app.post_manager')->savePost();

        $fb = $this->createFormBuilder()->addEventSubscriber(new PostListener($this->getDoctrine()->getManager(), $request, $this->get('session')->getFlashBag()));
        $form = $fb->getFormFactory()->create(PostType::class, new Post());

        return $this->render('@App/default/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}

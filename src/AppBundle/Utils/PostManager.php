<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PostManager
{

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var FlashBag
     */
    private $flash;

    public function __construct(EntityManager $em, RequestStack $request, FlashBag $flash)
    {

        $this->em = $em;
        $this->request = $request->getCurrentRequest();
        $this->flash = $flash;
    }

    public function savePost()
    {
        $post = new Post();
        $form = $this->getFormFactory()->create(PostType::class, $post);
        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();
            $this->flash->add('notice', 'form saved');
        }
        return false;
    }

    private function getFormFactory()
    {
        return Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();
    }
}
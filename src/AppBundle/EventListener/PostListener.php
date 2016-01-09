<?php

namespace AppBundle\EventListener;


use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PostListener implements EventSubscriberInterface
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

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];
    }

    public function __construct(EntityManager $em, Request $request, FlashBag $flash)
    {

        $this->em = $em;
        $this->request = $request;
        $this->flash = $flash;
    }
    
    public function onPostSubmit(FormEvent $event)
    {
        exit('onPostSubmitgit ');
        $data = $event->getData();
        $form = $event->getForm();

        if(! $data){
            return;
        }

        $form->handleRequest($this->request);
        if ($form->isValid()) {
            $this->em->persist($data);
            $this->em->flush();
            $this->flash->add('notice', 'form saved');
        }
        return false;
    }
}
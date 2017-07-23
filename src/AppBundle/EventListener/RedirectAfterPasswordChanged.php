<?php
/**
 * Created by PhpStorm.
 * User: FrederikPetersen
 * Date: 23/07/2017
 * Time: 22.01
 */

namespace AppBundle\EventListener;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RedirectAfterPasswordChanged implements EventSubscriberInterface
{
    private $router;

    public function __construct(RouterInterface $router){
        $this->router = $router;
    }

    public function onChangePasswordSuccess(FormEvent $event){
        $url = $this->router->generate('privateProfile');
        $response = new RedirectResponse($url);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(){

        return[
          FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onChangePasswordSuccess'
        ];
    }


}
<?php

namespace Store\BackendBundle\Notification;

use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Service de Notification
 * Class Notification
 * @package Store\BackendBundle\Notification
 */
class Notification{

    /**
     * @var session
     */
    protected $session;

    /**
     * Constructeur qui recevra
     * mon service session
     */
    public function __construct(Session $session){

        $this->session = $session;
    }

    /**
     * Methode qui va notifier une action
     * criticity: success - danger - warning - info
     */
    public function notify($message, $criticity = "success"){
        // la fonction set va me mettre en session
        // le message avec la clefs alert
        $this->session->set('alert', array(
            'message' => $message,
            'criticity' => $criticity,
        ));

    }






}











?>
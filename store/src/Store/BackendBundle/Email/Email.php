<?php

namespace Store\BackendBundle\Email;

/**
 * Email Service Class
 */
class Email {

    /**
     * @var \Swift_Mailer Swift Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment Twig Template Engine
     */
    protected $twig;

    /**
     * Constructeur de ma classe Email
     * J'ai besoin du service swift mailer et
     * du service Twig
     * En arguments: je récupère Swift Mailer,
     */
    public function __construct(\Swift_Mailer $mailer,
                                \Twig_Environment $twig){
        $this->mailer = $mailer; //je stoque mon
        $this->twig = $twig; //je stoque mon
    }

    /**
     * Fonction qui envoi un email à un utilisateur
     */
    public function send(){

        // je créer un message d'email en utilisant Swift Mailer de Symfony
        $message = \Swift_Message::newInstance()
            ->setSubject('Test email') //le sujet
            ->setFrom('julien@meetserious.com') // l'expediteur
            ->setTo('julien@meetserious.com') //le destinataire
            ->setContentType('text/html')
            ->setBody( //le corps du mail qui sera une vue en Twig
                $this->twig->render('StoreBackendBundle:Email:email.html.twig')
            );
        $this->mailer->send($message);
        //Utilise le service Mailer et envoi mon email
        //avec la methode send()
    }



    /**
     *  Send E-Mail
     * @param type $user
     * @param type $templating
     */
    public function sendparam($user = null,$sender = 'julien@meetserious.com',
                         $templating = null,$subject = "Bienvenue sur ALittleJewerly",
                         $to = null, $content = "") {

        // Sending Email
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom($sender)
            ->setContentType('text/html')
            ->setBody($this->twig->render($templating, array(
                'user' => $user,
                'content' => $content,
            )));

        $this->mailer->send($message);
    }



}

?>

<?php

namespace Store\BackendBundle\Email;

/**
 * Email Service Class.
 */
class Email
{
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
     * En arguments: je récupère Swift Mailer,.
     */
    public function __construct(\Swift_Mailer $mailer,
                                \Twig_Environment $twig)
    {
        $this->mailer = $mailer; //je stoque mon
        $this->twig = $twig; //je stoque mon
    }

    /**
     *  Send E-Mail.
     *
     * @param type $user
     * @param type $templating
     */
    public function sendparam($user = null, $sender = 'julien@meetserious.com',
                         $templating = null, $subject = 'Bienvenue sur ALittleJewerly',
                         $to = null, $content = '')
    {
        if (!$to && method_exists($user, 'getEmail')) {
            $to = $user->getEmail();
        }

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

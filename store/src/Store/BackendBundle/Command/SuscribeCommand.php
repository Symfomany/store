<?php

namespace Store\BackendBundle\Command;

use Store\BackendBundle\Entity\Jeweler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Création de jeweler
 * CRON task
 */
class SuscribeCommand extends ContainerAwareCommand {


    /**
     * Secure command linbe with param true
     */
    protected function configure() {
        $this->setName('backend:jeweler:create')
            ->setDescription("Remplissage d'utilisateur")
            ->addArgument('login', InputArgument::REQUIRED, 'Login ?')
            ->addArgument('email', InputArgument::REQUIRED, 'E-mail')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe?')
            ->addArgument(
                'role',
                InputArgument::OPTIONAL,
                'Quel est le role?'
            );
    }

    /**
     *  Execute command
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $login = $input->getArgument('login');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        //récupérer le service de doctrine manager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $jeweler = new Jeweler();
        $jeweler->setEmail($email);
        $jeweler->setUsername($login);

        //récupérer le service d'encodage de symfony 2
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($jeweler); //recupere l'encoder de l'entité jeweler contenu dans la sécurité
        $password = $encoder->encodePassword($password, $jeweler->getSalt()); //récupérer le mot de passe
        $jeweler->setPassword($password); //modifier le mot de passe encoder avec l'encodage
        $em->persist($jeweler); //enregistrement
        $em->flush();

        $output->writeln("<info>Création de l'utilisateur effectué!</info>");
        $output->writeln("<comment>Utilisateur prete a etre connecté: ".$jeweler->getUsername()." avec le role ROLE_JEWELER</comment>");
    }


}

?>

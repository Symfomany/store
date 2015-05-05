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
class NewsletterCommand extends ContainerAwareCommand {


    /**
     * Secure command linbe with param true
     */
    protected function configure() {
        $this->setName('backend:jeweler:newsletter')
            ->setDescription("Remplissage d'utilisateur")
            ->addArgument('mode', InputArgument::REQUIRED, 'Mot de passe?');

    }

    /**
     *  Execute command
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $mode = $input->getArgument('mode');

        //récupérer le service de doctrine manager
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $liste = $em->getRepository('StoreBackendBundle:Jeweler')->getJewelersOptin(1);

        //récupérer le service d'encodage de symfony 2
        $email = $this->getContainer()->get('store.backend.email');

        foreach($liste as $user){
            $email->sendparam($user, "julien@meetserious.com", "StoreBackendBundle:Email:newsletter.html.twig",
                '1er Newsletter', $user->getEmail());
        }

        $logger =  $this->getContainer()->get('logger');
        $logger->info('Nous avons envoyé la newsletter');

        $output->writeln("<info>Newsletter envoyée!</info>");

    }


}

?>

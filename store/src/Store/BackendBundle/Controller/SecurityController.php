<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Jeweler;
use Store\BackendBundle\Entity\JewelerMeta;
use Store\BackendBundle\Form\JewelerSubscribeTwoType;
use Store\BackendBundle\Form\JewelerSubscribeType;
use Store\BackendBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class SecurityController
 * @package Store\BackendBundle\Controller
 */
class SecurityController extends Controller{

    /**
     * Page Login
     */
    public function loginAction(Request $request){

        /**
         * On interroge le mecanisme de sécutité de Symfony 2 en session
         * Qui vérifie le bon login et le bon mot de passe en sécurité
         */
        $session = $request->getSession();

        $form =  $this->createForm(new LoginType());

        $form->handleRequest($request);

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }


        // je retourne la vue login de mon dossier Security
        return $this->render('StoreBackendBundle:Security:login.html.twig',
            array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
                'form' => $form->createView()
            ));

    }


    /**
     * Suscribe a Jeweler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmationAction(Request $request, $id, $token){
        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        $user = $em->getRepository('StoreBackendBundle:Jeweler')->findOneBy(
          array(
            'token' => $token,
            'id' => $id,
        ));

        if($user){
            if($user->getEnabled() == 0)
                $user->setEnabled(true);
                $em->persist($user);
                $em->flush();

            $this->get('session')->getFlashBag()->add(
                'info',
                "Bravo, vous avez activé votre compte ! Vous pouvez vous connecter sur l'outil d'administration"
            );

        }

        $this->get('session')->getFlashBag()->add(
            'danger',
            "Mauvais compte . Veuillez nous contacter"
        );

        return $this->redirectToRoute('store_backend_security_login'); //redirection selon la route
    }

    /**
     * Suscribe a Jeweler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscribeAction(Request $request){
        //je crée un nouveau jeweler
        $jeweler =  new Jeweler();

        //Je crée mon formulaire d'inscription au jeweler que j'associe à mon nouveau jeweler
        $form = $this->createForm(new JewelerSubscribeType(), $jeweler, array(
            'validation_groups' => 'suscribe',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_security_subscribe')
            )
        ));

        // Je lie le formulaire à la requete
        $form->handleRequest($request);

        // je valide mon formulaire
        if($form->isValid()){

            //1. je récupere la valeur mon champ password
            $password = $form['password']->getData();

            //récupérer le service d'encodage de la sécurité de Symfony 2
            $factory = $this->get('security.encoder_factory');

            // 2. je récupere l'encoder de mon jeweler (sha512)
            $encoder = $factory->getEncoder($jeweler); //recupere l'encoder de l'entité jeweler contenu dans la sécurité

            // 3. Avec l'encoder de sécurité, j'encode mon mot de passe et j'y ajoute le salt
            $password = $encoder->encodePassword($password, $jeweler->getSalt()); //récupérer le mot de passe

            // 4. Je renseigne le mot de passe ancode de mon jeweler
            $jeweler->setPassword($password); //modifier le mot de passe encoder avec l'encodage

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

            //5. je récupere le role ROLE_JEWELER par les ROLES
            // Je récupere le 1er groupe/role: ROLE_JEWELER
            $group = $em->getRepository('StoreBackendBundle:Groups')->find(1);

            //J'associe mon jeweler au role ROLE_JEWELER
            $jeweler->addGroup($group);

            $meta = new JewelerMeta();
            $meta->setJeweler($jeweler);
            $jeweler->setMeta($meta);

            $em->persist($meta); //enregistrement
            $em->persist($jeweler);
            $em->flush();

            $this->get('session')->set('iduser', $jeweler->getId());

            $this->get('store.backend.email')->sendparam(
                $jeweler, 'ecrindebijoux@gmail.com',
                'StoreBackendBundle:Email:subscribe.html.twig', "[ALittleJewerly] Confirmation de votre compte",
                $jeweler->getEmail()
            );

            return $this->redirectToRoute('store_backend_security_subscribe_steptwo'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Security:subscribe.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }


    /**
     * Suscribe a Jeweler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function diaporamaAction(Request $request)
    {

        if($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

            $id = $this->get('session')->get('iduser');

            if (!$id) {
                return $this->redirectToRoute('store_backend_suscribe');
            }

            $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find($id);

            if (!$jeweler) {
                return $this->redirectToRoute('store_backend_suscribe');
            }

            $diaporamas = $jeweler->getMeta()->getDiaporama();
            $diaporamas = unserialize($diaporamas);

            $file = $request->files->get('file');

            if(!isset($diaporamas[$file->getClientSize()])){
                $diaporamas[$file->getClientSize()] = $file->getClientOriginalName();
                $file->move($jeweler->getUploadRootDir().'/'.$id, $file->getClientOriginalName());
                $file = null;
            }

            $meta = $jeweler->getMeta();
            $meta->setDiaporama(serialize($diaporamas));

            $em->persist($meta);
            $em->flush();

            $response = new JsonResponse();
            $response->setData(array(
                'data' => true
            ));

            return $response;
        }
        $response = new JsonResponse();
        $response->setData(array(
            'data' => false
        ));
        return $response;
    }

    /**
     * Suscribe a Jeweler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscribeStepTwoAction(Request $request){

        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        $id = $this->get('session')->get('iduser');

        if(!$id){
            return $this->redirectToRoute('store_backend_suscribe');
        }

        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find($id);

        if(!$jeweler){
            return $this->redirectToRoute('store_backend_suscribe');
        }

        //Je crée mon formulaire d'inscription au jeweler que j'associe à mon nouveau jeweler
        $form = $this->createForm(new JewelerSubscribeTwoType(), $jeweler, array(
            'validation_groups' => 'suscribetwo',
        ));

        // Je lie le formulaire à la requete
        $form->handleRequest($request);

        // je valide mon formulaire
        if($form->isValid()){

            $jeweler->upload($jeweler->getId());

            $city = $form['meta']->getData()->getCity();
            $zipcode = $form['meta']->getData()->getZipcode();

            if(!empty($city)){
                $coordonates = $em->getRepository('StoreBackendBundle:Villes')
                    ->getCordonneesByCity($city);

                if(!$coordonates){
                    $coordonates = $em->getRepository('StoreBackendBundle:Villes')
                        ->getCordonneesByCity($zipcode);
                }

                if(!empty($coordonates)){
                    $jeweler->getMeta()->setLongitude($coordonates['longitude']);
                    $jeweler->getMeta()->setLatitude($coordonates['latitude']);
                }
            }

            $em->persist($jeweler);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre compte a bien été crée. Un emailo de confirmation a été envoyé à '.$jeweler->getEmail()
            );
            $this->get('session')->getFlashBag()->add(
                'info',
                "Vous devez activer votre compte pour pouvoir se connecter sur l'outil d'administration"
            );
            return $this->redirectToRoute('store_backend_security_login'); //redirection selon la route
        }



        return $this->render('StoreBackendBundle:Security:subscribesteptwo.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }



}






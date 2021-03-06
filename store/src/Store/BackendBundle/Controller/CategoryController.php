<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CategoryController.
 */
class CategoryController extends Controller
{
    /**
     * List my categories.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        $categories = $em->getRepository('StoreBackendBundle:Category')
            ->getCategoryByUser($user);

        //paginate to bundle
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('StoreBackendBundle:Category:list.html.twig', array(
            'categories' => $pagination,
        ));
    }

    /**
     * New category page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();

        $user = $this->getUser();

        $category->setJeweler($user); //j'associe mon jeweler 1 à mon produit

        // je crée un formulaire de produit
        $form = $this->createForm(new CategoryType($user), $category,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_category_new'),
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

            // j'upload mon fichier en faisant appel a la methode upload()
            $category->upload();

            $em->persist($category); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoie ma requete d'insert à ma table product

            // création de l'ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($category);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
            $tokenStorage = $this->get('security.token_storage');
            $user = $tokenStorage->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // donne accès au propriétaire
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre catégorie a bien été crée'
            );

            return $this->redirectToRoute('store_backend_category_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Category:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * New category page.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Category $id)
    {
        $authChecker = $this->get('security.authorization_checker');

        // check for edit access
        if (false === $authChecker->isGranted('EDIT', $id)) {
            throw new AccessDeniedException();
        }

        // je crée un formulaire de produit
        $form = $this->createForm(new CategoryType(1), $id,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_category_edit', array('id' => $id->getId())),
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            // j'upload mon fichier en faisant appel a la methode upload()
            $id->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
                $em->persist($id); //j'enregistre mon objet product dans doctrine
                $em->flush(); //j'envoi ma requete d'insert à ma table product

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Votre catégorie a bien été modifiée'
                );

            return $this->redirectToRoute('store_backend_category_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Category:edit.html.twig', array(
            'form' => $form->createView(),
            'category' => $id,
        ));
    }

    /**
     * Action de suppression.
     *
     * @Security("is_granted('', id)")
     */
    public function removeAction(Category $id)
    {

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        $em->remove($id);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre catégorie a bien été supprimé'
        );

        return $this->redirectToRoute('store_backend_category_list');
    }
}

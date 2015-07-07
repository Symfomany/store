<?php

namespace Store\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MessageRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends EntityRepository
{
    /**
     * Récupère les messages de l'utilisateur.
     *
     * @param int $user
     *
     * @return array
     */
    public function getLastMessagesByUser($user, $limit = 5)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                '
                 SELECT m
                 FROM StoreBackendBundle:Message m
                 WHERE m.jeweler = :user
                 ORDER BY m.id DESC'
            )
            ->setParameter('user', $user)
            ->setMaxResults($limit);

        return $query->getResult();
    }
}

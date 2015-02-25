<?php

namespace ZF2Essentials\Model;

class DefaultModel {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Doctrine\ORM\EntityRepository          
     */
    private $entity;
    private $entity_name;
    private $rows;

    public function __construct($em) {
        $this->em = $em;
    }

    public function setEntity($entity) {
        $this->entity = $this->em->getRepository($entity);
        $this->entity_name = $entity;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function delete($id) {
        /*
          $em->remove($user);
          $em->flush();
         */

        return $this->delete($id);
    }

    public function edit(array $params) {
        /*
          $user = new User;
          $user->setName('Mr.Right');
          $em->persist($user);
          $em->flush();
         */

        // return $user->getId();
    }

    public function insert(array $params) {
        /*
          $user = new User;
          $user->setName('Mr.Right');
          $em->persist($user);
          $em->flush();
         */

        // return $user->getId();
    }

    public function getTotalResults() {
        return $this->rows;
    }

    public function get($id = null, $page = 1, $limit = 100) {
        if ($id) {
            return $this->toArray($this->entity->find($id));
        } else {

            $query = $this->entity->createQueryBuilder('e')
                    ->select('e')
                    ->getQuery()
                    ->setFirstResult($limit * ($page - 1))
                    ->setMaxResults($limit);

            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
            $this->rows = count($paginator);

            return $query->getArrayResult();
        }
    }

    public function toArray($data) {
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->em, $this->entity_name);
        return $hydrator->extract($data);
    }

}

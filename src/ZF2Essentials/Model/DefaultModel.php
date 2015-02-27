<?php

namespace ZF2Essentials\Model;

use Doctrine\ORM\Tools\Pagination\Paginator;

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

    public function getFields() {
        //print_r($this->em->getClassMetadata($this->entity_name)->getFieldNames());
        //print_r($this->em->getClassMetadata($this->entity_name)->getAssociationNames());
        //print_r($this->em->getClassMetadata($this->entity_name)->getAssociationMappings());
    }

    public function getWithParent($id, $entity_parent, $page = 1, $limit = 100) {
        $table = $this->em->getClassMetadata($this->entity_name)->getTableName();
        $qbp = $this->em->getRepository('Entity\\' . lcfirst($entity_parent))->createQueryBuilder('e')->select('e');
        $qb = $this->entity->createQueryBuilder('e')->select('e');
        $parent = strtolower($entity_parent);
        $data[$parent] = $qbp->where('e.id=' . $id)->getQuery()->getArrayResult()[0];
        $data[$parent][strtolower($table)] = $qb->where('e.' . $parent . '=' . $id)->getQuery()->getArrayResult();
        $query = $qb->getQuery()->setFirstResult($limit * ($page - 1))->setMaxResults($limit);
        $paginator = new Paginator($query);
        $this->rows = count($paginator);
        return $data;
    }

    public function get($id = null, $page = 1, $limit = 100) {
        $qb = $this->entity->createQueryBuilder('e')->select('e');
        if ($id) {
            return $qb->where('e.id=' . $id)->getQuery()->getArrayResult();
        } else {
            $query = $qb->getQuery()->setFirstResult($limit * ($page - 1))->setMaxResults($limit);
            $paginator = new Paginator($query);
            $this->rows = count($paginator);
            return $query->getArrayResult();
        }
    }

    public function toArray($data) {
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->em, $this->entity_name);
        return $hydrator->extract($data);
    }

}

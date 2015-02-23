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
        return $this->delete($id);
    }

    public function edit(array $params) {
        
    }

    public function insert(array $params) {
        
    }

    public function get($id = null) {
        if ($id) {
            return $this->toArray($this->entity->find($id));
        } else {
            return $this->entity->findAll();
        }
    }

    public function toArray($data) {
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->em, $this->entity_name);
        return $hydrator->extract($data);
    }

}

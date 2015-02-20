<?php

namespace ZF2Essentials;

use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class DiscoveryModel {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct($em) {
        $this->setEntityManager($em);
    }

    /**
     * Return a EntityManager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->em;
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function discovery($route) {
        /*
          echo '<pre>';
          print_r($route);
          $user = $this->getEntityManager()->getRepository('Entity\User')->find(1);
          print_r($user);
          print_r($this->getEntityManager()->getRepository('Entity\Adress')->find($user));
          echo '</pre>';

          return new ViewModel(array(
          'users' => $user
          ));
         * 
         */
    }

}

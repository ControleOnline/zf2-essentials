<?php

namespace ZF2Essentials;

use Zend\View\Model\ViewModel;

class DiscoveryModel {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $method;

    public function __construct($em, $method) {
        $this->setEntityManager($em);
        $this->setMethod($method);
    }

    /**
     * Return a EntityManager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->em;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function discovery($route) {
        switch ($this->getMethod()) {
            case 'POST':
                break;
            case 'PUT':
                break;
            case 'DELETE':
                break;
            case 'GET':
            default:
                echo '<pre>';
                print_r($route);
                print_r($_SERVER['REQUEST_METHOD']);
                echo '</pre>';
                break;
        }


        /*
          $user = $this->getEntityManager()->getRepository('Entity\User')->find(1);
          print_r($user);
          print_r($this->getEntityManager()->getRepository('Entity\Adress')->find($user));
          echo '</pre>';

          return new ViewModel(array(
          'users' => $user
          ));
         */
    }

}

<?php

namespace ZF2Essentials\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;


class ScaffoldingController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Return a EntityManager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->em;
    }

    public function indexAction() {
        
        echo '<pre>';
        print_r($this->params('scaffolding'));
        echo '</pre>';
        die();
        
        return new ViewModel(array(
            'albums' => $this->getEntityManager()->getRepository('Entity\User')->findAll()
        ));
    }
}

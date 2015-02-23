<?php

namespace ZF2Essentials\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use ZF2Essentials\DiscoveryModel;

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
        $method = strtoupper($this->params('method') ? : $_SERVER['REQUEST_METHOD']);
        $DiscoveryModel = new DiscoveryModel($this->getEntityManager(), $method, $this->getRequest());
        return $DiscoveryModel->discovery($this->params('scaffolding'));
    }

}

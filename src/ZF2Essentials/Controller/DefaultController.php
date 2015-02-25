<?php

namespace ZF2Essentials\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use ZF2Essentials\DiscoveryModel;
use \Zend\View\Model\ViewModel;

class DefaultController extends AbstractActionController {

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
        $method = strtoupper($this->params()->fromQuery('method') ? : $_SERVER['REQUEST_METHOD']);
        $DiscoveryModel = new DiscoveryModel($this->getEntityManager(), $method, $this->getRequest());
        $page = $this->params()->fromQuery('page') ? : 1;

        try {
            $data = $DiscoveryModel->discovery($this->params('scaffolding'));
            $total = $DiscoveryModel->getTotalResults();
            if ($data && is_array($data)) {
                $return = array(
                    'data' => $data,
                    'count' => count($data),
                    'total' => (int) $total,
                    'page' => (int) $page,
                    'success' => true
                );
            } elseif ($data) {
                $return = array(
                    'data' => array(
                        'id' => $data
                    ),
                    'count' => count($data),
                    'total' => (int) $total,
                    'page' => (int) $page,
                    'success' => true
                );
            } else {
                $return = array(
                    'data' => $data,
                    'count' => count($data),
                    'total' => (int) $total,
                    'page' => (int) $page,
                    'success' => true
                );
            }
            return new ViewModel($return);
        } catch (Doctrine_Connection_Exception $e) {
            $return = array(
                'error' => array(
                    'code' => $e->getPortableCode(),
                    'message' => $e->getPortableMessage(),
                ),
                'success' => false
            );

            return new ViewModel($return);
        }
    }

}

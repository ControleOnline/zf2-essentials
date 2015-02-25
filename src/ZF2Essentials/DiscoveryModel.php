<?php

namespace ZF2Essentials;

class DiscoveryModel {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $params;
    private $method;

    public function __construct($em, $method, $params) {
        $this->setEntityManager($em);
        $this->setMethod($method);
        $this->setParams($this->prepareParams($params));
    }

    /**
     * Return a EntityManager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->em;
    }

    public function getParams() {
        return $this->params;
    }

    public function setParams(array $params) {
        $this->params = $params;
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

    public function prepareParams(\Zend\Http\PhpEnvironment\Request $params) {
        return array_merge(
                $params->getQuery()->toArray(), $params->getPost()->toArray()
        );
    }

    public function discovery($route) {

        $default_model = new Model\DefaultModel($this->getEntityManager());
        $default_model->setEntity('Entity\\' . $route['controller']);

        switch ($this->getMethod()) {
            case 'POST':
                return $default_model->insert($this->params);
                break;
            case 'PUT':
                return $default_model->edit($this->params);
                break;
            case 'DELETE':
                return $default_model->delete($this->params['id']);
                break;
            case 'GET':
            default:
                $id = isset($this->params['id']) ? $this->params['id'] : null;
                $page = isset($this->params['page']) ? $this->params['page'] : 1;
                $limit = isset($this->params['limit']) ? $this->params['limit'] : 100;
                return $default_model->get($id, $page, $limit);
                break;
        }
    }

}

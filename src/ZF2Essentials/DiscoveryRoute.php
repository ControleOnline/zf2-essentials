<?php

namespace ZF2Essentials;

use Zend\Stdlib\RequestInterface as Request;

class DiscoveryRoute {

    protected $_controller;
    protected $_module;
    protected $_action;
    protected $_entity;
    protected $_vars;
    protected $_url;
    protected $_defaultRoute;

    public function __construct($defaultRoute) {
        $this->setDefaultRoute($defaultRoute);
    }

    public function getRoute() {
        $return = array_merge($this->getDefaultRoute(), array(
            'path' => implode('/', $this->getUrl())
        ));
        return $this->discoveryRoute($return);
    }

    public function setGetParams(Request $request) {
        $params = $this->getUrl();
        $qtde = count($params);
        for ($i = 0; $i < $qtde; $i += 2) {
            $key = str_replace('.json', '', $params[$i]);
            $value = isset($params[$i + 1]) ? str_replace('.json', '', $params[$i + 1]) : null;
            $request->getQuery()->set($key, $value);
        }
    }

    protected function formarClass($class, $type, $module = null) {
        if ($module) {
            return '\\' . $module . '\\' . $type . '\\' . $class;
        } else {
            return '\\' . $type . '\\' . $class;
        }
    }

    protected function discoveryByController($routes) {

        $defaultRoute = $this->getDefaultRoute();
        $module = $this->camelCase((isset($routes[0]) ? str_replace('.json', '', $routes[0]) : $defaultRoute['module']));
        $class_name = $this->camelCase((isset($routes[1]) ? str_replace('.json', '', $routes[1]) : $defaultRoute['controller']));
        $controller = $this->formarClass($class_name, 'Controller', $module);

        if (class_exists($controller)) {
            $this->setModule($module);
            $this->setController($controller);
            $url = $this->getUrl();
            unset($url[0]);
            unset($url[1]);
            $this->setUrl($url);
        }
    }

    protected function discoveryByEntity($routes) {
        $defaultRoute = $this->getDefaultRoute();
        $entity = $this->camelCase((isset($routes[0]) ? str_replace('.json', '', $routes[0]) : null));
        $this->setModule($defaultRoute['module']);
        $this->setController($this->formarClass($defaultRoute['controller'], 'Controller', $defaultRoute['module']));
        $this->setAction($defaultRoute['action']);

        if ($entity) {
            $class_name = $this->formarClass($entity, 'Entity');
            if (class_exists($class_name)) {
                $this->setEntity($entity);
                $url = $this->getUrl();
                unset($url[0]);
                $this->setUrl($url);
            }
        }
    }

    protected function discoveryAction($routes) {
        $defaultRoute = $this->getDefaultRoute();
        $action = lcfirst($this->camelCase((isset($routes[2]) ? $routes[2] : $defaultRoute['action'])));
        $class = $this->getController();
        $testClass = new $class();
        if (method_exists($testClass, $action . 'Action')) {
            $this->setAction($action);
            $url = $this->getUrl();
            unset($url[0]);
            $this->setUrl($url);
        } else {
            $this->setAction($defaultRoute['action']);
        }
    }

    protected function discoveryRoute($default) {
        $routes = $this->getUrl();
        $this->discoveryByController($routes);
        if ($this->getController()) {
            $this->discoveryAction($routes);
        } else {
            $this->discoveryByEntity($routes);
        }

        $return = array(
            'module' => $this->getModule(),
            'controller' => $this->getController(),
            'action' => $this->getAction(),
            'entity' => $this->getEntity()
        );
        return array_merge($default, $return);
    }

    protected function camelCase($string) {
        return str_replace(' ', '', ucfirst($string));
    }

    public function getController() {
        return $this->_controller;
    }

    public function getModule() {
        return $this->_module;
    }

    public function getAction() {
        return $this->_action;
    }

    public function getEntity() {
        return $this->_entity;
    }

    public function getVars() {
        return $this->_vars;
    }

    public function getUrl() {
        return array_values($this->_url);
    }

    public function setController($controller) {
        $this->_controller = $controller;
        return $this;
    }

    public function setModule($module) {
        $this->_module = $module;
        return $this;
    }

    public function setAction($action) {
        $this->_action = $action;
        return $this;
    }

    public function setEntity($entity) {
        $this->_entity = $entity;
        return $this;
    }

    public function setVars($vars) {
        $this->_vars = $vars;
        return $this;
    }

    public function setUrl($url) {
        if (is_array($url)) {
            $routes = $url;
        } else {
            $routes = array_filter(explode('/', $url));
        }
        $this->_url = array_values($routes);
        return $this;
    }

    public function getDefaultRoute() {
        return $this->_defaultRoute;
    }

    public function setDefaultRoute($defaultRoute) {
        $this->_defaultRoute = $defaultRoute;
        return $this;
    }

}

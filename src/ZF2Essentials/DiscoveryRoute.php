<?php

namespace ZF2Essentials;

class DiscoveryRoute {

    protected $controller;
    protected $module;
    protected $action;

    public function getRoute($alias, $options) {

        $return = array_merge($options, array(
            'path' => $alias
        ));
        print_r($this->discoveryRoute($alias, $return));
        return $this->discoveryRoute($alias, $return);
    }

    protected function discoveryRoute($alias, $options) {
        $routes = explode('/', $alias);
        if (!empty(array_filter($routes))) {
            $return['module'] = $this->camelCase((isset($routes[0]) ? $routes[0] : $options['module']));
            $return['action'] = lcfirst($this->camelCase((isset($routes[2]) ? $routes[2] : $options['action'])));
            $return['controller'] = $return['module'] . '\Controller\\' . $this->camelCase((isset($routes[1]) ? $routes[1] : $options['controller']));            
            if (!class_exists($return['controller'] . 'Controller')) {
                $return = $options;
                $return['controller'] = $options['module'] . '\Controller\\' . $options['controller'];
            }
        } else {
            $return['controller'] = $options['module'] . '\Controller\\' . $options['controller'];
        }
        return array_merge($options, $return);
    }

    protected function camelCase($string) {
        return str_replace(' ', '', ucfirst($string));
    }

}

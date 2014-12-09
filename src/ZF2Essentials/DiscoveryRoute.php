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
        return $this->discoveryRoute($alias, $return);
    }

    public function setGetParams($url, $request, $route) {

        $url = explode('/', $url);
        $route = explode('\\', $route['controller']);
        foreach ($url as $key => $u) {
            if ($key < 3) {
                if (strtolower($u) != strtolower($route[$key])) {
                    $params[] = $u;
                }
            } else {
                $params[] = $u;
            }
        }
        $qtde = count($params);
        for ($i = 0; $i < $qtde; $i += 2) {
            $request->getQuery()->set($params[$i], isset($params[$i + 1]) ? $params[$i + 1] : null);
        }
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
            } else {
                $class = $return['controller'] . 'Controller';
                $testClass = new $class();
                if (!method_exists($testClass, $return['action'] . 'Action')) {
                    $return['action'] = $options['action'];
                }
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

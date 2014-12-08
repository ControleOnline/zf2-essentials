<?php

namespace ZF2Essentials;

use Zend\Mvc\Router\Http\RouteInterface;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ArrayUtils;
use Zend\Mvc\Router\Exception\InvalidArgumentException;
use Zend\Mvc\Router\Http\RouteMatch;

class ZF2Essentials implements RouteInterface {

    protected $defaults = array();

    /**
     * Create a new page route.
     */
    public function __construct(array $defaults = array()) {
        $this->defaults = $defaults;
    }

    /**
     * Create a new route with given options.
     */
    public static function factory($options = array()) {
        if ($options instanceof \Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = array();
        }

        return new static($options['defaults']);
    }

    /**
     * Match a given request.
     */
    public function match(Request $request, $pathOffset = null) {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        $uri = $request->getUri();
        $fullPath = $uri->getPath();

        $path = substr($fullPath, $pathOffset);
        $alias = trim($path, '/');

        $options = $this->defaults;
        $options = array_merge($options, array(
            'path' => $alias
        ));

        $options['module'] = 'Application';
        $options['controller'] = 'Application\Controller\Index';
        $options['action'] = 'index';

        print_r($options);
        return new RouteMatch($options);
    }

    /**
     * Assemble the route.
     */
    public function assemble(array $params = array(), array $options = array()) {
        if (array_key_exists('path', $params)) {
            return '/' . $params['path'];
        }

        return '/';
    }

    /**
     * Get a list of parameters used while assembling.
     */
    public function getAssembledParams() {
        return array();
    }

}

<?php

namespace ZF2Essentials;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Http\Response;
use Zend\Json\Json;

class Module {

    protected $sm;
    protected $config;
    protected $em;

    public function getDefaultConfig($config) {
        $config['jsonStrategy'] = (isset($config['jsonStrategy']) ? $config['jsonStrategy'] : true);
        return $config;
    }

    public function onBootstrap(MvcEvent $e) {

        $this->sm = $e->getApplication()->getServiceManager();
        $this->em = $this->sm->get('Doctrine\ORM\EntityManager');
        $config = $this->sm->get('config');

        $this->config = $this->getDefaultConfig(
                (isset($config['zf2_essentials']) ? $config['zf2_essentials'] : array())
        );

        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->setResponseType($e);

        if (isset($config['doctrine']['connection']['orm_default']['params'])) {
            $dbConfig = $config['doctrine']['connection']['orm_default']['params'];
            $entity = new DiscoveryEntity($this->em, $dbConfig);
            $entity->checkEntities();
        }
    }

    public function finishJsonStrategy($e) {
        if ($this->config['jsonStrategy']) {
            $response = new Response();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
            $response->setContent(Json::encode($e->getResult()->getVariables(), true));
            $e->setResponse($response);
        }
    }

    public function setResponseType(MvcEvent $e) {
        if ($this->config['jsonStrategy']) {

            $request = $e->getRequest();
            $headers = $request->getHeaders();
            $uri = $e->getRequest()->getUri()->getPath();
            $compare = '.json';
            $is_json = substr_compare($uri, $compare, strlen($uri) - strlen($compare), strlen($compare)) === 0;
            if ($headers->has('accept') || $is_json) {
                $accept = $headers->get('accept');
                $match = $accept->match('application/json');
                if ($is_json || ($match && $match->getTypeString() != '*/*')) {
                    $e->getApplication()->getEventManager()->attach('render', array($this, 'registerJsonStrategy'), 100);
                    $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_FINISH, array($this, 'finishJsonStrategy'));
                }
            }
        }
    }

    public function registerJsonStrategy($e) {
        if ($this->config['jsonStrategy']) {
            $app = $e->getTarget();
            $locator = $app->getServiceManager();
            $view = $locator->get('Zend\View\View');
            $jsonStrategy = $locator->get('ViewJsonStrategy');
            $view->getEventManager()->attach($jsonStrategy, 100);
        }
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}

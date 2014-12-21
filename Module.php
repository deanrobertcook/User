<?php

namespace User;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface {

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					// if we're in a namespace deeper than one level we need to fix the \ in the path
					__NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
				),
			),
		);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function onBootstrap(MvcEvent $e) {
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		$serviceManager = $e->getApplication()->getServiceManager();
		$dbAdapter = $serviceManager->get('database');
		GlobalAdapterFeature::setStaticAdapter($dbAdapter);
		
		$eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'protectPage'), -100);
	}
	
	public function protectPage(MvcEvent $event) {
		$match = $event->getRouteMatch();
		
		if (!$match) {
			return;
		}
		
		$controller = $match->getParam('controller');
		$action = $match->getParam('action');
		
		$namespace = $match->getParam('__NAMESPACE__');
		
	}

}

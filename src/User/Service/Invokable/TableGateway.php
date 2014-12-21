<?php

namespace User\Service\Invokable;

use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of TableGateway
 *
 * @author Dean
 */
class TableGateway implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var array
     */
    protected $cache;

    public function get($tableName, $features = null, $resultSetPrototype = null)
    {
        $cacheKey = $tableName;
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        $config = $this->serviceLocator->get('config');
        $tableGatewayMap = $config['table-gateway']['map'];
        if (isset($tableGatewayMap)) {
            $className = $tableGatewayMap[$tableName];
            $this->cache[$cacheKey] = new $className();
        } else {
            $db = $this->serviceLocator->get('database');
            $tableGateway = new TableGateway($tableName, $db, $features, $resultSetPrototype);
        }

        return $this->cache[$cacheKey];
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}

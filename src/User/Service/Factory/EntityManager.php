<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Service\Factory;

use Doctrine\ORM\Tools\Setup;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of EntityManager
 *
 * @author dean
 */
class EntityManager implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $doctrineDbConfig = (array) $config['db'];
        $doctrineDbConfig['driver'] = strtolower($doctrineDbConfig['driver']);
        if (!isset($doctrineDbConfig['dbname'])) {
            $doctrineDbConfig['dbname'] = $doctrineDbConfig['database'];
        }

        if (!isset($doctrineDbConfig['host'])) {
            $doctrineDbConfig['host'] = $doctrineDbConfig['hostname'];
        }

        if (!isset($doctrineDbConfig['user'])) {
            $doctrineDbConfig['user'] = $doctrineDbConfig['username'];
        }

        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($config['doctrine']['entity_path'], true);
        $entityManager = \Doctrine\ORM\EntityManager::create($doctrineDbConfig, $doctrineConfig);

        return $entityManager;
    }

//put your code here
}

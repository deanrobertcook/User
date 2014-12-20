<?php

namespace User\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Description of User
 *
 * @author Dean
 */
class User extends AbstractTableGateway {
	
	public function __construct() {
		$this->table = 'users';
		
		$this->featureSet = new FeatureSet();
		$this->featureSet->addFeature(new GlobalAdapterFeature());
		$this->initialize();
	}
}
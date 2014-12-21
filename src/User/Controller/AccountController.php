<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use User\Form\UserForm;
use User\Model\User;
use Zend\Mvc\Controller\AbstractActionController;

class AccountController extends AbstractActionController {

	public function indexAction() {
		return array();
	}

	public function addAction() {
		$form = new UserForm();
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost()->toArray();
			$form->setData($data);
			if ($form->isValid()) {
				$model = new User();
				$id = $model->insert($form->getData());

				//REDIRECT USER TO VIEW USER ACTION
			}
		}
		return array(
			'form1' => $form
		);
	}

	public function registerAction() {
		return array();
	}

	public function viewAction() {
		return array();
	}

	public function editAction() {
		return array();
	}

	public function deleteAction() {
		$id = $this->params()->fromRoute('id');
		if($id) {
			$userModel = new User();
			$userModel->delete(array('id' => $id));
		}
		return $this->redirect()->toRoute('user');
	}

}

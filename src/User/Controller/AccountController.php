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
use User\Model\UserGateway;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;

class AccountController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function addAction()
    {
        $builder = new AnnotationBuilder();
        $entity = $this->serviceLocator->get('user-entity');
        $form = $builder->createForm($entity);

        //Since these form elements aren't part of the Entity, the Annotation
        //builder doesn't know about them, so we have to make them manually
        $form->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Verify Password:'
            ),
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
            )),
        array(
            'priority' => $form->get('password')->getOption('priority'),
        ));

        $form->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
        $form->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'submit',
                'required' => 'false',
            )
        ));

        $form->bind($entity);

//        $form = new UserForm();
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray();
            $form->setData($data);
            if ($form->isValid()) {
                $entityManager = $this->serviceLocator->get('entity-manager');
                $entityManager->persist($entity);
                $entityManager->flush();

                //REDIRECT USER TO VIEW USER ACTION
            }
        }
        return array(
            'form1' => $form
        );
    }

    public function registerAction()
    {
        //demonstrates forwarding to the addAction
        $result = $this->forward()->dispatch(
            'User\Controller\Account',
            array('action' => 'add')
        );

        return $result;
    }

    public function viewAction()
    {
        return array();
    }

    public function editAction()
    {
        return array();
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        if($id) {
            $userModel = new UserGateway();
            $userModel->delete(array('id' => $id));
        }
        return $this->redirect()->toRoute(
            'user/default',
            array(
                'controller' => 'account',
                'action' => 'view',
            )
        );
    }

}

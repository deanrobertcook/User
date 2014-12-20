<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
/**
 * Description of UserForm
 *
 * @author Dean
 */
class UserForm extends Form {
	
	public function __construct() {
		parent::__construct();
		
		//here we can set attributes for the HTML form element
		$this->setAttribute('method', 'post');
		
		//EMAIL
		$this->add(array(
			'name' => 'email',
			'type' => 'Zend\Form\Element\Email', //must be a valid Zend Element
			'options' => array(
				'label' => 'Email:'
			),
			'attributes' => array(
				'type' => 'email',
				'required' => 'required',
				'placeholder' => 'Email Address'
			)
		));
		
		//PASSWORD
		$this->add(array(
			'name' => 'password',
			'type' => 'Zend\Form\Element\Password',
			'options' => array(
				'label' => 'Password:'
			),
			'attributes' => array(
				'type' => 'password',
				'required' => 'required',
			)
		));
		
		//PASSWORD VERIFY
		$this->add(array(
			'name' => 'password_verify',
			'type' => 'Zend\Form\Element\Password',
			'options' => array(
				'label' => 'Verify Password:'
			),
			'attributes' => array(
				'type' => 'password',
				'required' => 'required',
			)
		));
		
		//PHONE
		$this->add(array(
			'name' => 'phone',
			'options' => array(
				'label' => 'Phone:'
			),
			'attributes' => array(
				'type' => 'tel',
				'required' => 'required',
				'pattern' => '^[\d-/]+$'
			)
		));
		
		//PHOTO
		$this->add(array(
			'name' => 'photo',
			'type' => 'Zend\Form\Element\File',
			'options' => array(
				'label' => 'Your Photo:'
			),
			'attributes' => array(
				'required' => 'required',
				'id' => 'photo'
			)
		));
		
		$this->add(array(
			'name' => 'csrf',
			'type' => 'Zend\Form\Element\Csrf',
		));
		
		//PHONE
		$this->add(array(
			'name' => 'submit',
			'type' => 'Zend\Form\Element\Submit',
			'attributes' => array(
				'value' => 'submit',
				'required' => 'false',
			)
		));
				
	}
	
	public function getInputFilter() {
		if (!$this->filter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			
			//EMAIL
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'email',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'EmailAddress',
						'options' => array(
							'messages' => array(
								'emailAddressInvalidFormat' => 'Email address is not valid.',
							),
						),
					),
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								'isEmpty' => 'Email address is required.'
							)
						),
					),
				),
			)));
			
			//NAME
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'name',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								'isEmpty' => 'Name is required.'
							)
						),
					),
				),
			)));
			
			//PASSWORD
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'password',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								'isEmpty' => 'Password is required.'
							)
						),
					),
				),
			)));
			
			//PASSWORD VERIFY
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'password_verify',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						//this validator checks to see that the input is the same as the supplied token
						'name' => 'identical',
						'options' => array(
							'token' => 'password'
						),
					),
				),
			)));
			
			//PHOTO
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'photo',
				'filters' => array(
					array(
						'name' => 'filerenameupload',
						'options' => array(
							//note, if the folder does not exist, we'll get a strange warning saying the 
							//field is empty, and validation will fail.
							'target' => 'data/image/photos',
							'randomize' => true,
						),
					),
				),
				'validators' => array(
					array(
						'name' => 'filesize',
						'options' => array(
							'max' => '2097152' //2MB
						),
					),
					array(
						'name' => 'filemimetype',
						'options' => array(
							'mimeType' => 'image/png, image/x-png, image/jpg, image/jpeg, image/gif'
						),
					),
					array(
						'name' => 'fileimagesize',
						'options' => array(
							'maxWidth' => '200',
							'maxHeight' => '200',
						),
					),
				),
			)));
			
			//PHONE
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'phone',
				'filters' => array(
					array('name' => 'digits'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'regex',
						'options' => array(
							'pattern' => '/^[\d-\/]+$/'
						),
					),
				),
			)));
			
			$this->filter = $inputFilter;
		}
		return $this->filter;
	}
	
	/**
	 * @Overide throws exception to disallow modifying the input filter for the form
	 */
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new Exception('Modifying input filter not allowed');
	}
}

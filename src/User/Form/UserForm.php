<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use ZendTest\XmlRpc\Server\Exception;
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
		
		$this->add(array(
			'name' => 'first_name',
			'options' => array(
				'label' => 'First Name:'
			),
			'attributes' => array(
				'type' => 'text',
				'required' => 'required',
				'placeholder' => 'First Name'
			)
		));
		
		$this->add(array(
			'name' => 'last_name',
			'options' => array(
				'label' => 'Last Name:'
			),
			'attributes' => array(
				'type' => 'text',
				'required' => 'required',
				'placeholder' => 'Last Name'
			)
		));
		
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
		
		
//		$this->add(array(
//			'name' => 'phone',
//			'options' => array(
//				'label' => 'Phone:'
//			),
//			'attributes' => array(
//				'type' => 'tel',
//				'required' => 'required',
//				'pattern' => '^[\d-/]+$'
//			)
//		));
		

//		$this->add(array(
//			'name' => 'photo',
//			'type' => 'Zend\Form\Element\File',
//			'options' => array(
//				'label' => 'Your Photo:'
//			),
//			'attributes' => array(
//				'required' => 'required',
//				'id' => 'photo'
//			)
//		));
		
		$this->add(array(
			'name' => 'csrf',
			'type' => 'Zend\Form\Element\Csrf',
		));
		
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
								EmailAddress::INVALID_FORMAT => 'Email address is not valid.',
							),
						),
					),
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								NotEmpty::IS_EMPTY => 'Email address is required.'
							)
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'first_name',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								NotEmpty::IS_EMPTY => 'First name is required.'
							)
						),
					),
					array(
						'name' => 'Regex',
						'options' => array(
							'pattern' => '/^[a-zA-Z]+$/',
							'messages' => array(
								Regex::NOT_MATCH => 'Please enter a valid name.'
							)
						),
					),
				),
			)));
			
			$inputFilter->add($factory->createInput(array(
				//This name tells us the validators and filters will be applied to related input
				'name' => 'last_name',
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								NotEmpty::IS_EMPTY => 'First name is required.'
							)
						),
					),
					array(
						'name' => 'Regex',
						'options' => array(
							'pattern' => '/^[a-zA-Z]+$/',
							'messages' => array(
								Regex::NOT_MATCH => 'Please enter a valid name.'
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
								NotEmpty::IS_EMPTY => 'Password is required.'
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
						'name' => 'NotEmpty',
						'options' => array(
							'messages' => array(
								NotEmpty::IS_EMPTY => 'Please verify the password.'
							)
						),
					),
					array(
						//this validator checks to see that the input is the same as the supplied token
						'name' => 'Identical',
						'options' => array(
							'token' => 'password',
							'messages' => array(
								Identical::NOT_SAME => "Passwords do not match",
							)
						),
					),
				),
			)));
			
//			//PHOTO
//			$inputFilter->add($factory->createInput(array(
//				//This name tells us the validators and filters will be applied to related input
//				'name' => 'photo',
//				'filters' => array(
//					array(
//						'name' => 'File\RenameUpload',
//						'options' => array(
//							//note, if the folder does not exist, we'll get a strange warning saying the 
//							//field is empty, and validation will fail.
//							'target' => 'data/image/photos',
//							'use_upload_extension' => true,
//							'randomize' => true,
//						),
//					),
//				),
//				'validators' => array(
//					array(
//						'name' => 'File\Size',
//						'options' => array(
//							'max' => '2097152', //2MB
//							'messages' => array(
//								Size::TOO_BIG=> 'The photo exceeds the maximum allowed limit of 2MB.'
//							)
//						),
//					),
//					array(
//						'name' => 'File\ImageSize',
//						'options' => array(
//							'maxWidth' => '500',
//							'maxHeight' => '500',
//							'messages' => array(
//								ImageSize::HEIGHT_TOO_BIG => 'Please make sure the image height is less than 500px',
//								ImageSize::WIDTH_TOO_BIG => 'Please make sure the image width is less than 500px'
//							)
//						),
//					),
//				),
//			)));
//			
//			//PHONE
//			$inputFilter->add($factory->createInput(array(
//				//This name tells us the validators and filters will be applied to related input
//				'name' => 'phone',
//				'filters' => array(
//					array('name' => 'digits'),
//					array('name' => 'StringTrim'),
//				),
//				'validators' => array(
//					array(
//						'name' => 'regex',
//						'options' => array(
//							'pattern' => '/^[\d-\/]+$/'
//						),
//					),
//				),
//			)));
			
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

<?php

namespace User\Mode\Entity;

use Zend\Form\Annotation;

/**
 * Description of User
 * @Annotation\Name("users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @author dean
 */
class User
{

    /**
     * @Annotation\Exclude()
     */
    protected $id;

    /**
     *@Annotation\Type("Zend\Form\Element\Email")
     *@Annotation\Options({
     *		"label": "Your Email:"
     *		"priority": "100"
     * })
     *@Annotation\Flags({"priority": "100"})
     *@Annotation\Filter({"name": "StripTags"})
     *@Annotation\Filter({"name": "StringTrim"})
     *@Annotation\Validator({
     *		"name": "EmailAddress"
     * })
     * @Annotation\Validator({
     *		"name": "NotEmpty"
     * })
     *@Annotation\Attributes({
     *		"type": "email",
     *		"required": true,
     *		"placeholder": "Email Address"
     * })
     */
    protected $email;

    /**
     *@Annotation\Type("Zend\Form\Element\Text")
     *@Annotation\Options({
     *		"label": "Your first name:"
     *		"priority": "200"
     * })
     *@Annotation\Flags({"priority": "200"})
     *@Annotation\Filter({"name": "StripTags"})
     *@Annotation\Filter({"name": "StringTrim"})
     *@Annotation\Validator({
     *		"name": "NotEmpty"
     * })
     * *@Annotation\Validator({
     *		"name": "RegEx",
     *		"options": {
     *			"pattern": "/^[a-zA-Z]+$/"
     *		}
     * })
     *@Annotation\Attributes({
     *		"type": "text",
     *		"required": true,
     *		"placeholder": "First Name"
     * })
     */
    protected $firstName;

    /**
     *@Annotation\Type("Zend\Form\Element\Text")
     *@Annotation\Options({
     *		"label": "Your last name:"
     *		"priority": "300"
     * })
     *@Annotation\Flags({"priority": "300"})
     *@Annotation\Filter({"name": "StripTags"})
     *@Annotation\Filter({"name": "StringTrim"})
     *@Annotation\Validator({
     *		"name": "NotEmpty"
     * })
     * *@Annotation\Validator({
     *		"name": "RegEx",
     *		"options": {
     *			"pattern": "/^[a-zA-Z]+$/"
     *		}
     * })
     *@Annotation\Attributes({
     *		"type": "text",
     *		"required": true,
     *		"placeholder": "Last Name"
     * })
     */
    protected $lastName;

    /**
     *@Annotation\Type("Zend\Form\Element\Text")
     *@Annotation\Options({
     *		"label": "Password:"
     *		"priority": "400"
     * })
     *@Annotation\Flags({"priority": "400"})
     *@Annotation\Filter({"name": "StripTags"})
     *@Annotation\Filter({"name": "StringTrim"})
     *@Annotation\Validator({
     *		"name": "NotEmpty"
     * })
     *@Annotation\Attributes({
     *		"type": "password",
     *		"required": true,
     * })
     */
    protected $password;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $this->hashPassword($password);
    }

    public function verifyPassword($password)
    {
        return ($this->password == $this->hashPassword($password));
    }

    public function hashPassword($password)
    {
        return md5($password);
    }

}

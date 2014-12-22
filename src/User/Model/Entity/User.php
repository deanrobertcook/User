<?php

namespace User\Mode\Entity;

/**
 * Description of User
 *
 * @author dean
 */
class User
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;

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
}

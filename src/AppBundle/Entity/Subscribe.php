<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subscribe
 */
class Subscribe
{
    /**
     * @var string
     *
     * @Assert\Email(message="Неверное значение email")
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     */
    private $name;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     * 
     * @Assert\Choice({"wholesale", "retail"}, message="Неверное значение типа компании")
     */
    private $type;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $url;

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Subscribe
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Subscribe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Subscribe
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Subscribe
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Subscribe
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Subscribe
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Subscribe
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}

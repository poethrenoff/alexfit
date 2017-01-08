<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;

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
    private $subscribe_email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     */
    private $subscribe_person;

    /**
     * @var string
     */
    private $subscribe_company;

    /**
     * @var string
     * 
     * @Assert\Choice({"wholesale", "retail"}, message="Неверное значение типа компании")
     */
    private $subscribe_type;

    /**
     * @var string
     */
    private $subscribe_phone;

    /**
     * @var string
     */
    private $subscribe_fax;

    /**
     * @var string
     */
    private $subscribe_url;

    /**
     * Set email
     *
     * @param string $subscribeEmail
     *
     * @return Subscribe
     */
    public function setSubscribeEmail($subscribeEmail)
    {
        $this->subscribe_email = $subscribeEmail;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getSubscribeEmail()
    {
        return $this->subscribe_email;
    }

    /**
     * Set person
     *
     * @param string $subscribePerson
     *
     * @return Subscribe
     */
    public function setSubscribePerson($subscribePerson)
    {
        $this->subscribe_person = $subscribePerson;

        return $this;
    }

    /**
     * Get person
     *
     * @return string
     */
    public function getSubscribePerson()
    {
        return $this->subscribe_person;
    }

    /**
     * Set company
     *
     * @param string $subscribeCompany
     *
     * @return Subscribe
     */
    public function setSubscribeCompany($subscribeCompany)
    {
        $this->subscribe_company = $subscribeCompany;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getSubscribeCompany()
    {
        return $this->subscribe_company;
    }

    /**
     * Set type
     *
     * @param string $subscribeType
     *
     * @return Subscribe
     */
    public function setSubscribeType($subscribeType)
    {
        $this->subscribe_type = $subscribeType;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getSubscribeType()
    {
        return $this->subscribe_type;
    }

    /**
     * Set phone
     *
     * @param string $subscribePhone
     *
     * @return Subscribe
     */
    public function setSubscribePhone($subscribePhone)
    {
        $this->subscribe_phone = $subscribePhone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getSubscribePhone()
    {
        return $this->subscribe_phone;
    }

    /**
     * Set fax
     *
     * @param string $subscribeFax
     *
     * @return Subscribe
     */
    public function setSubscribeFax($subscribeFax)
    {
        $this->subscribe_fax = $subscribeFax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getSubscribeFax()
    {
        return $this->subscribe_fax;
    }

    /**
     * Set url
     *
     * @param string $subscribeUrl
     *
     * @return Subscribe
     */
    public function setSubscribeUrl($subscribeUrl)
    {
        $this->subscribe_url = $subscribeUrl;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getSubscribeUrl()
    {
        return $this->subscribe_url;
    }
    
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContext $context, $payload)
    {
        if ($this->getSubscribeCompany()) {
            if (empty($this->getSubscribeType())) {
                $context->buildViolation('Поле обязательно к заполнению')
                    ->atPath('subscribe_type')
                    ->addViolation();
            }
            if (empty($this->getSubscribePhone())) {
                $context->buildViolation('Поле обязательно к заполнению')
                    ->atPath('subscribe_phone')
                    ->addViolation();
            }
            if (empty($this->getSubscribeFax())) {
                $context->buildViolation('Поле обязательно к заполнению')
                    ->atPath('subscribe_fax')
                    ->addViolation();
            }
        } 
    }    
}

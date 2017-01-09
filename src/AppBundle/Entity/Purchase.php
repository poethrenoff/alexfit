<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Purchase
 * 
 * @ORM\Table(name="purchase")
 * @ORM\Entity
 */
class Purchase
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $purchase_id;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     * @ORM\Column(type="string")
     */
    private $purchase_person;

    /**
     * @var string
     * 
     * @Assert\Email(message="Неверное значение email")
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     * @ORM\Column(type="string")
     */
    private $purchase_email;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     * @ORM\Column(type="string")
     */
    private $purchase_phone;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Поле обязательно к заполнению")
     * @ORM\Column(type="text")
     */
    private $purchase_address;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $purchase_comment;

    /**
     * @var date
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private $purchase_date;

    /**
     * @var double
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $purchase_sum = 0;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @Assert\Choice({"new", "confirm", "deliver", "complete", "cancel"})
     * @ORM\Column(type="string")
     */
    private $purchase_status = 'new';
    
    /**
     * @ORM\OneToMany(targetEntity="PurchaseItem", mappedBy="item_purchase", cascade={"all"})
     */
    private $items;

    public function __construct()
    {
        $this->purchase_date = new \DateTime();
        $this->items = new ArrayCollection();
    }
    
    public function __toString()
    {
        return 'Заказ №' . $this->getPurchaseId();
    }

    /**
     * Get purchaseId
     *
     * @return integer
     */
    public function getPurchaseId()
    {
        return $this->purchase_id;
    }

    /**
     * Set purchasePerson
     *
     * @param string $purchasePerson
     *
     * @return Purchase
     */
    public function setPurchasePerson($purchasePerson)
    {
        $this->purchase_person = $purchasePerson;

        return $this;
    }

    /**
     * Get purchasePerson
     *
     * @return string
     */
    public function getPurchasePerson()
    {
        return $this->purchase_person;
    }

    /**
     * Set purchaseEmail
     *
     * @param string $purchaseEmail
     *
     * @return Purchase
     */
    public function setPurchaseEmail($purchaseEmail)
    {
        $this->purchase_email = $purchaseEmail;

        return $this;
    }

    /**
     * Get purchaseEmail
     *
     * @return string
     */
    public function getPurchaseEmail()
    {
        return $this->purchase_email;
    }

    /**
     * Set purchasePhone
     *
     * @param string $purchasePhone
     *
     * @return Purchase
     */
    public function setPurchasePhone($purchasePhone)
    {
        $this->purchase_phone = $purchasePhone;

        return $this;
    }

    /**
     * Get purchasePhone
     *
     * @return string
     */
    public function getPurchasePhone()
    {
        return $this->purchase_phone;
    }

    /**
     * Set purchaseAddress
     *
     * @param string $purchaseAddress
     *
     * @return Purchase
     */
    public function setPurchaseAddress($purchaseAddress)
    {
        $this->purchase_address = $purchaseAddress;

        return $this;
    }

    /**
     * Get purchaseAddress
     *
     * @return string
     */
    public function getPurchaseAddress()
    {
        return $this->purchase_address;
    }

    /**
     * Set purchaseComment
     *
     * @param string $purchaseComment
     *
     * @return Purchase
     */
    public function setPurchaseComment($purchaseComment)
    {
        $this->purchase_comment = $purchaseComment;

        return $this;
    }

    /**
     * Get purchaseComment
     *
     * @return string
     */
    public function getPurchaseComment()
    {
        return $this->purchase_comment;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     *
     * @return Purchase
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchase_date = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchase_date;
    }

    /**
     * Set purchaseSum
     *
     * @param string $purchaseSum
     *
     * @return Purchase
     */
    public function setPurchaseSum($purchaseSum)
    {
        $this->purchase_sum = $purchaseSum;

        return $this;
    }

    /**
     * Get purchaseSum
     *
     * @return string
     */
    public function getPurchaseSum()
    {
        return $this->purchase_sum;
    }

    /**
     * Set purchaseStatus
     *
     * @param string $purchaseStatus
     *
     * @return Purchase
     */
    public function setPurchaseStatus($purchaseStatus)
    {
        $this->purchase_status = $purchaseStatus;

        return $this;
    }

    /**
     * Get purchaseStatus
     *
     * @return string
     */
    public function getPurchaseStatus()
    {
        return $this->purchase_status;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\PurchaseItem $item
     *
     * @return Purchase
     */
    public function addItem(\AppBundle\Entity\PurchaseItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\PurchaseItem $item
     */
    public function removeItem(\AppBundle\Entity\PurchaseItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}

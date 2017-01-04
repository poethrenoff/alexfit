<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PurchaseItem
 * 
 * @ORM\Table(name="purchase_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseItemRepository")
 */
class PurchaseItem
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $item_id;
    
    /**
     * @var int
     * 
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Purchase", inversedBy="items")
     * @ORM\JoinColumn(name="item_purchase", referencedColumnName="purchase_id")
     */
    private $item_purchase;

    /**
     * @var int
     * 
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="item_product", referencedColumnName="product_id")
     */
    private $item_product;

    /**
     * @var double
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $item_price;

    /**
     * @var int
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $item_quantity;

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set itemPrice
     *
     * @param string $itemPrice
     *
     * @return PurchaseItem
     */
    public function setItemPrice($itemPrice)
    {
        $this->item_price = $itemPrice;

        return $this;
    }

    /**
     * Get itemPrice
     *
     * @return string
     */
    public function getItemPrice()
    {
        return $this->item_price;
    }

    /**
     * Set itemQuantity
     *
     * @param integer $itemQuantity
     *
     * @return PurchaseItem
     */
    public function setItemQuantity($itemQuantity)
    {
        $this->item_quantity = $itemQuantity;

        return $this;
    }

    /**
     * Get itemQuantity
     *
     * @return integer
     */
    public function getItemQuantity()
    {
        return $this->item_quantity;
    }

    /**
     * Set itemPurchase
     *
     * @param \AppBundle\Entity\Purchase $itemPurchase
     *
     * @return PurchaseItem
     */
    public function setItemPurchase(\AppBundle\Entity\Purchase $itemPurchase = null)
    {
        $this->item_purchase = $itemPurchase;

        return $this;
    }

    /**
     * Get itemPurchase
     *
     * @return \AppBundle\Entity\Purchase
     */
    public function getItemPurchase()
    {
        return $this->item_purchase;
    }

    /**
     * Set itemProduct
     *
     * @param \AppBundle\Entity\Product $itemProduct
     *
     * @return PurchaseItem
     */
    public function setItemProduct(\AppBundle\Entity\Product $itemProduct = null)
    {
        $this->item_product = $itemProduct;

        return $this;
    }

    /**
     * Get itemProduct
     *
     * @return \AppBundle\Entity\Product
     */
    public function getItemProduct()
    {
        return $this->item_product;
    }
}

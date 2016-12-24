<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 * 
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $product_id;
    
    /**
     * @var int
     * 
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="product_category", referencedColumnName="category_id")
     */
    private $product_category;
    
    /**
     * @var int
     * 
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="product_brand", referencedColumnName="brand_id")
     */
    private $product_brand;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $product_title;
    
    /**
     * @var double
     * 
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $product_price;
    
    /**
     * @var double
     * 
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $product_price_old;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $product_short_desctiption;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $product_full_desctiption;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $product_instruction;
    private $product_instruction_file;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    private $product_active = true;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductPicture", mappedBy="product_picture")
     */
    private $pictures;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getProductTitle();
    }
    
    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set productTitle
     *
     * @param string $productTitle
     *
     * @return Product
     */
    public function setProductTitle($productTitle)
    {
        $this->product_title = $productTitle;

        return $this;
    }

    /**
     * Get productTitle
     *
     * @return string
     */
    public function getProductTitle()
    {
        return $this->product_title;
    }

    /**
     * Set productPrice
     *
     * @param string $productPrice
     *
     * @return Product
     */
    public function setProductPrice($productPrice)
    {
        $this->product_price = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return string
     */
    public function getProductPrice()
    {
        return $this->product_price;
    }

    /**
     * Set productPriceOld
     *
     * @param string $productPriceOld
     *
     * @return Product
     */
    public function setProductPriceOld($productPriceOld)
    {
        $this->product_price_old = $productPriceOld;

        return $this;
    }

    /**
     * Get productPriceOld
     *
     * @return string
     */
    public function getProductPriceOld()
    {
        return $this->product_price_old;
    }

    /**
     * Set productShortDesctiption
     *
     * @param string $productShortDesctiption
     *
     * @return Product
     */
    public function setProductShortDesctiption($productShortDesctiption)
    {
        $this->product_short_desctiption = $productShortDesctiption;

        return $this;
    }

    /**
     * Get productShortDesctiption
     *
     * @return string
     */
    public function getProductShortDesctiption()
    {
        return $this->product_short_desctiption;
    }

    /**
     * Set productFullDesctiption
     *
     * @param string $productFullDesctiption
     *
     * @return Product
     */
    public function setProductFullDesctiption($productFullDesctiption)
    {
        $this->product_full_desctiption = $productFullDesctiption;

        return $this;
    }

    /**
     * Get productFullDesctiption
     *
     * @return string
     */
    public function getProductFullDesctiption()
    {
        return $this->product_full_desctiption;
    }

    /**
     * Set productInstruction
     *
     * @param string $productInstruction
     *
     * @return Product
     */
    public function setProductInstruction($productInstruction)
    {
        $this->product_instruction = $productInstruction;

        return $this;
    }

    /**
     * Get productInstruction
     *
     * @return string
     */
    public function getProductInstruction()
    {
        return $this->product_instruction;
    }

    /**
     * Set productInstructionFile
     *
     * @param string $productInstructionFile
     *
     * @return Product
     */
    public function setProductInstructionFile($productInstructionFile)
    {
        $this->product_instruction_file = $productInstructionFile;

        return $this;
    }

    /**
     * Get productInstructionFile
     *
     * @return string
     */
    public function getProductInstructionFile()
    {
        return $this->product_instruction_file;
    }

    /**
     * Set productCategory
     *
     * @param \AppBundle\Entity\Category $productCategory
     *
     * @return Product
     */
    public function setProductCategory(\AppBundle\Entity\Category $productCategory = null)
    {
        $this->product_category = $productCategory;

        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \AppBundle\Entity\Category
     */
    public function getProductCategory()
    {
        return $this->product_category;
    }

    /**
     * Set productBrand
     *
     * @param \AppBundle\Entity\Brand $productBrand
     *
     * @return Product
     */
    public function setProductBrand(\AppBundle\Entity\Brand $productBrand = null)
    {
        $this->product_brand = $productBrand;

        return $this;
    }

    /**
     * Get productBrand
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getProductBrand()
    {
        return $this->product_brand;
    }

    /**
     * Add picture
     *
     * @param \AppBundle\Entity\ProductPicture $picture
     *
     * @return Product
     */
    public function addPicture(\AppBundle\Entity\ProductPicture $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \AppBundle\Entity\ProductPicture $picture
     */
    public function removePicture(\AppBundle\Entity\ProductPicture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set productActive
     *
     * @param boolean $productActive
     *
     * @return Product
     */
    public function setProductActive($productActive)
    {
        $this->product_active = $productActive;

        return $this;
    }

    /**
     * Get productActive
     *
     * @return boolean
     */
    public function getProductActive()
    {
        return $this->product_active;
    }
}

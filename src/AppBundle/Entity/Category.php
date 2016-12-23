<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 * 
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $category_id;
    
    /**
     * @var int
     * 
     * @ORM\ManyToOne(targetEntity="Catalogue", inversedBy="categories")
     * @ORM\JoinColumn(name="category_catalogue", referencedColumnName="catalogue_id")
     */
    private $category_catalogue;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $category_title;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $category_short_title;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $category_name;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $category_description;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $category_picture;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $category_order;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    private $category_active = true;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="product_category")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getCategoryTitle();
    }

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Upload directory
     */
    private $upload_directory;

    /**
     * Set upload directory
     */
    public function setUploadDirectory($upload_directory)
    {
        $this->upload_directory = $upload_directory;
    }

    /**
     * Get upload directory
     */
    public function getUploadDirectory()
    {
        return $this->upload_directory;
    }

    /**
     * Upload alias
     */
    private $upload_alias;

    /**
     * Set upload alias
     */
    public function setUploadAlias($upload_alias)
    {
        $this->upload_alias = $upload_alias;
    }

    /**
     * Get upload alias
     */
    public function getUploadAlias()
    {
        return $this->upload_alias;
    }

    /**
     * Upload file
     */
    public function upload()
    {    
        if (null === $this->getFile()) {
            return;
        }
        
        $this->getFile()->move(
            $this->getUploadDirectory(), $this->getFile()->getClientOriginalName()
        );

        $this->setCategoryPicture(
            $this->getUploadAlias() . $this->getFile()->getClientOriginalName()
        );

        $this->setFile(null);
    }
   
    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set categoryTitle
     *
     * @param string $categoryTitle
     *
     * @return Category
     */
    public function setCategoryTitle($categoryTitle)
    {
        $this->category_title = $categoryTitle;

        return $this;
    }

    /**
     * Get categoryTitle
     *
     * @return string
     */
    public function getCategoryTitle()
    {
        return $this->category_title;
    }

    /**
     * Set categoryShortTitle
     *
     * @param string $categoryShortTitle
     *
     * @return Category
     */
    public function setCategoryShortTitle($categoryShortTitle)
    {
        $this->category_short_title = $categoryShortTitle;

        return $this;
    }

    /**
     * Get categoryShortTitle
     *
     * @return string
     */
    public function getCategoryShortTitle()
    {
        return $this->category_short_title;
    }

    /**
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->category_name = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * Set categoryDescription
     *
     * @param string $categoryDescription
     *
     * @return Category
     */
    public function setCategoryDescription($categoryDescription)
    {
        $this->category_description = $categoryDescription;

        return $this;
    }

    /**
     * Get categoryDescription
     *
     * @return string
     */
    public function getCategoryDescription()
    {
        return $this->category_description;
    }

    /**
     * Set categoryPicture
     *
     * @param string $categoryPicture
     *
     * @return Category
     */
    public function setCategoryPicture($categoryPicture)
    {
        $this->category_picture = $categoryPicture;

        return $this;
    }

    /**
     * Get categoryPicture
     *
     * @return string
     */
    public function getCategoryPicture()
    {
        return $this->category_picture;
    }

    /**
     * Set categoryOrder
     *
     * @param integer $categoryOrder
     *
     * @return Category
     */
    public function setCategoryOrder($categoryOrder)
    {
        $this->category_order = $categoryOrder;

        return $this;
    }

    /**
     * Get categoryOrder
     *
     * @return integer
     */
    public function getCategoryOrder()
    {
        return $this->category_order;
    }

    /**
     * Set categoryActive
     *
     * @param boolean $categoryActive
     *
     * @return Category
     */
    public function setCategoryActive($categoryActive)
    {
        $this->category_active = $categoryActive;

        return $this;
    }

    /**
     * Get categoryActive
     *
     * @return boolean
     */
    public function getCategoryActive()
    {
        return $this->category_active;
    }

    /**
     * Set categoryCatalogue
     *
     * @param \AppBundle\Entity\Catalogue $categoryCatalogue
     *
     * @return Category
     */
    public function setCategoryCatalogue(\AppBundle\Entity\Catalogue $categoryCatalogue = null)
    {
        $this->category_catalogue = $categoryCatalogue;

        return $this;
    }

    /**
     * Get categoryCatalogue
     *
     * @return \AppBundle\Entity\Catalogue
     */
    public function getCategoryCatalogue()
    {
        return $this->category_catalogue;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Category
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}

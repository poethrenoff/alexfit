<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Catalogue
 * 
 * @ORM\Table(name="catalogue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CatalogueRepository")
 */
class Catalogue
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $catalogue_id;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $catalogue_title;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $catalogue_name;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $catalogue_description;
    
    /**
     * @var int
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $catalogue_order;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    private $catalogue_active = true;
    
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="category_catalogue")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getCatalogueTitle();
    }

    /**
     * Get catalogueId
     *
     * @return integer
     */
    public function getCatalogueId()
    {
        return $this->catalogue_id;
    }

    /**
     * Set catalogueTitle
     *
     * @param string $catalogueTitle
     *
     * @return Catalogue
     */
    public function setCatalogueTitle($catalogueTitle)
    {
        $this->catalogue_title = $catalogueTitle;

        return $this;
    }

    /**
     * Get catalogueTitle
     *
     * @return string
     */
    public function getCatalogueTitle()
    {
        return $this->catalogue_title;
    }

    /**
     * Set catalogueName
     *
     * @param string $catalogueName
     *
     * @return Catalogue
     */
    public function setCatalogueName($catalogueName)
    {
        $this->catalogue_name = $catalogueName;

        return $this;
    }

    /**
     * Get catalogueName
     *
     * @return string
     */
    public function getCatalogueName()
    {
        return $this->catalogue_name;
    }

    /**
     * Set catalogueDescription
     *
     * @param string $catalogueDescription
     *
     * @return Catalogue
     */
    public function setCatalogueDescription($catalogueDescription)
    {
        $this->catalogue_description = $catalogueDescription;

        return $this;
    }

    /**
     * Get catalogueDescription
     *
     * @return string
     */
    public function getCatalogueDescription()
    {
        return $this->catalogue_description;
    }

    /**
     * Set catalogueOrder
     *
     * @param integer $catalogueOrder
     *
     * @return Catalogue
     */
    public function setCatalogueOrder($catalogueOrder)
    {
        $this->catalogue_order = $catalogueOrder;

        return $this;
    }

    /**
     * Get catalogueOrder
     *
     * @return integer
     */
    public function getCatalogueOrder()
    {
        return $this->catalogue_order;
    }

    /**
     * Set catalogueActive
     *
     * @param boolean $catalogueActive
     *
     * @return Catalogue
     */
    public function setCatalogueActive($catalogueActive)
    {
        $this->catalogue_active = $catalogueActive;

        return $this;
    }

    /**
     * Get catalogueActive
     *
     * @return boolean
     */
    public function getCatalogueActive()
    {
        return $this->catalogue_active;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Catalogue
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

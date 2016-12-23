<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 * 
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BrandRepository")
 */
class Brand
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $brand_id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $brand_title;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $brand_country;
    
    public function __toString()
    {
        return $this->getBrandTitle();
    }

    /**
     * Get brandId
     *
     * @return integer
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set brandTitle
     *
     * @param string $brandTitle
     *
     * @return Brand
     */
    public function setBrandTitle($brandTitle)
    {
        $this->brand_title = $brandTitle;

        return $this;
    }

    /**
     * Get brandTitle
     *
     * @return string
     */
    public function getBrandTitle()
    {
        return $this->brand_title;
    }

    /**
     * Set brandCountry
     *
     * @param string $brandCountry
     *
     * @return Brand
     */
    public function setBrandCountry($brandCountry)
    {
        $this->brand_country = $brandCountry;

        return $this;
    }

    /**
     * Get brandCountry
     *
     * @return string
     */
    public function getBrandCountry()
    {
        return $this->brand_country;
    }
}

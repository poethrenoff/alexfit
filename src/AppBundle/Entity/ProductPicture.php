<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;

/**
 * ProductPicture
 * 
 * @ORM\Table(name="product_picture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductPictureRepository")
 */
class ProductPicture
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $picture_id;
    
    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Product",  inversedBy="pictures")
     * @ORM\JoinColumn(name="picture_product", referencedColumnName="product_id", onDelete="CASCADE")
     */
    private $picture_product;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $picture_image;
    private $picture_image_file;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $picture_order;
   
    /**
     * Get pictureId
     *
     * @return integer
     */
    public function getPictureId()
    {
        return $this->picture_id;
    }

    /**
     * Set pictureImage
     *
     * @param string $pictureImage
     *
     * @return ProductPicture
     */
    public function setPictureImage($pictureImage)
    {
        $this->picture_image = $pictureImage;

        return $this;
    }

    /**
     * Get pictureImage
     *
     * @return string
     */
    public function getPictureImage()
    {
        return $this->picture_image;
    }

    /**
     * Set pictureImage
     *
     * @param string $pictureImageFile
     *
     * @return ProductPicture
     */
    public function setPictureImageFile($pictureImageFile)
    {
        $this->picture_image_file = $pictureImageFile;

        return $this;
    }

    /**
     * Get pictureImageFile
     *
     * @return string
     */
    public function getPictureImageFile()
    {
        return $this->picture_image_file;
    }

    /**
     * Set pictureOrder
     *
     * @param integer $pictureOrder
     *
     * @return ProductPicture
     */
    public function setPictureOrder($pictureOrder)
    {
        $this->picture_order = $pictureOrder;

        return $this;
    }

    /**
     * Get pictureOrder
     *
     * @return integer
     */
    public function getPictureOrder()
    {
        return $this->picture_order;
    }

    /**
     * Set pictureProduct
     *
     * @param \AppBundle\Entity\Product $pictureProduct
     *
     * @return ProductPicture
     */
    public function setPictureProduct(\AppBundle\Entity\Product $pictureProduct = null)
    {
        $this->picture_product = $pictureProduct;

        return $this;
    }

    /**
     * Get pictureProduct
     *
     * @return \AppBundle\Entity\Product
     */
    public function getPictureProduct()
    {
        return $this->picture_product;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContext $context, $payload)
    {
        if (empty($this->getPictureImage()) && empty($this->getPictureImageFile())) {
            $context->buildViolation('Одно из полей обязательно к заполнению')
                ->atPath('picture_image')
                ->addViolation();
            $context->buildViolation('Одно из полей обязательно к заполнению')
                ->atPath('picture_image_file')
                ->addViolation();
        }
    }
}

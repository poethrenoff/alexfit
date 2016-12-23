<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="pictures")
     * @ORM\JoinColumn(name="picture_product", referencedColumnName="product_id")
     */
    private $picture_product;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $picture_image;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $picture_order;

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

        $this->setPictureImage(
            $this->getUploadAlias() . $this->getFile()->getClientOriginalName()
        );

        $this->setFile(null);
    }
   
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
}

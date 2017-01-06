<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Text
 *
 * @ORM\Table(name="text")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TextRepository")
 */
class Text
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $text_id;
    
    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $text_title;
    
    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $text_name;
    
    /**
     * @var text
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $text_content;
    
    public function __toString()
    {
        return $this->getTextTitle();
    }

    /**
     * Get textId
     *
     * @return integer
     */
    public function getTextId()
    {
        return $this->text_id;
    }

    /**
     * Set textName
     *
     * @param string $textName
     *
     * @return Text
     */
    public function setTextName($textName)
    {
        $this->text_name = $textName;

        return $this;
    }

    /**
     * Get textName
     *
     * @return string
     */
    public function getTextName()
    {
        return $this->text_name;
    }

    /**
     * Set textTitle
     *
     * @param string $textTitle
     *
     * @return Text
     */
    public function setTextTitle($textTitle)
    {
        $this->text_title = $textTitle;

        return $this;
    }

    /**
     * Get textTitle
     *
     * @return string
     */
    public function getTextTitle()
    {
        return $this->text_title;
    }

    /**
     * Set textContent
     *
     * @param string $textContent
     *
     * @return Text
     */
    public function setTextContent($textContent)
    {
        $this->text_content = $textContent;

        return $this;
    }

    /**
     * Get textContent
     *
     * @return string
     */
    public function getTextContent()
    {
        return $this->text_content;
    }
}

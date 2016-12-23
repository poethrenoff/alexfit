<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string")
     */
    private $text_tag;
    
    /**
     * @ORM\Column(type="string")
     */
    private $text_title;
    
    /**
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
     * Set textTag
     *
     * @param string $textTag
     *
     * @return Text
     */
    public function setTextTag($textTag)
    {
        $this->text_tag = $textTag;

        return $this;
    }

    /**
     * Get textTag
     *
     * @return string
     */
    public function getTextTag()
    {
        return $this->text_tag;
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

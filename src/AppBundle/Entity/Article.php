<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 * 
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $article_id;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $article_title;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $article_announce;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $article_text;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean")
     */
    private $article_active = true;
    
    public function __toString()
    {
        return (string) $this->getArticleTitle();
    }

    /**
     * Get articleId
     *
     * @return integer
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * Set articleTitle
     *
     * @param string $articleTitle
     *
     * @return Article
     */
    public function setArticleTitle($articleTitle)
    {
        $this->article_title = $articleTitle;

        return $this;
    }

    /**
     * Get articleTitle
     *
     * @return string
     */
    public function getArticleTitle()
    {
        return $this->article_title;
    }

    /**
     * Set articleAnnounce
     *
     * @param string $articleAnnounce
     *
     * @return Article
     */
    public function setArticleAnnounce($articleAnnounce)
    {
        $this->article_announce = $articleAnnounce;

        return $this;
    }

    /**
     * Get articleAnnounce
     *
     * @return string
     */
    public function getArticleAnnounce()
    {
        return $this->article_announce;
    }

    /**
     * Set articleText
     *
     * @param string $articleText
     *
     * @return Article
     */
    public function setArticleText($articleText)
    {
        $this->article_text = $articleText;

        return $this;
    }

    /**
     * Get articleText
     *
     * @return string
     */
    public function getArticleText()
    {
        return $this->article_text;
    }

    /**
     * Set articleActive
     *
     * @param boolean $articleActive
     *
     * @return Article
     */
    public function setArticleActive($articleActive)
    {
        $this->article_active = $articleActive;

        return $this;
    }

    /**
     * Get articleActive
     *
     * @return boolean
     */
    public function getArticleActive()
    {
        return $this->article_active;
    }
}

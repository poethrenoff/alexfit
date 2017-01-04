<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Preference
 * 
 * @ORM\Table(name="preference")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PreferenceRepository")
 */
class Preference
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $preference_id;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $preference_title;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $preference_name;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $preference_value;
    
    public function __toString()
    {
        return $this->getPreferenceTitle();
    }

    /**
     * Get preferenceId
     *
     * @return integer
     */
    public function getPreferenceId()
    {
        return $this->preference_id;
    }

    /**
     * Set preferenceTitle
     *
     * @param string $preferenceTitle
     *
     * @return Preference
     */
    public function setPreferenceTitle($preferenceTitle)
    {
        $this->preference_title = $preferenceTitle;

        return $this;
    }

    /**
     * Get preferenceTitle
     *
     * @return string
     */
    public function getPreferenceTitle()
    {
        return $this->preference_title;
    }

    /**
     * Set preferenceName
     *
     * @param string $preferenceName
     *
     * @return Preference
     */
    public function setPreferenceName($preferenceName)
    {
        $this->preference_name = $preferenceName;

        return $this;
    }

    /**
     * Get preferenceName
     *
     * @return string
     */
    public function getPreferenceName()
    {
        return $this->preference_name;
    }

    /**
     * Set preferenceValue
     *
     * @param string $preferenceValue
     *
     * @return Preference
     */
    public function setPreferenceValue($preferenceValue)
    {
        $this->preference_value = $preferenceValue;

        return $this;
    }

    /**
     * Get preferenceValue
     *
     * @return string
     */
    public function getPreferenceValue()
    {
        return $this->preference_value;
    }
}

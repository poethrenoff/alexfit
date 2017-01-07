<?php

namespace AppBundle\Lib;

use Doctrine\ORM\EntityManager;

class Preference
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Constructor
     * 
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get preference
     * 
     * @param  string       $name
     * @param  string|null  $default
     *
     * @return string
     */
    public function get($name, $default = null)
    {
        return $this->entityManager->getRepository('AppBundle:Preference')
            ->findOneBy(array('preference_name' => $name))->getPreferenceValue() ?: $default;  
    }
}

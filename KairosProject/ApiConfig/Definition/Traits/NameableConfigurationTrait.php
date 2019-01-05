<?php
declare(strict_types=1);
/**
 * This file is part of the kairos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Symfony\Component\Config\Definition\Traits;

/**
 * Nameable configuration trait
 *
 * This trait implement the base methods of the NameableConfigurationInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait NameableConfigurationTrait
{
    /**
     * Name
     *
     * This property represent the element name, used as configuration key.
     *
     * @var string
     */
    private $name;

    /**
     * Set name of the element
     *
     * Set the name used as key for the configuration element.
     *
     * @param string $name The name of the element
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name of the element
     *
     * Return the name used as key for the configuration element.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}

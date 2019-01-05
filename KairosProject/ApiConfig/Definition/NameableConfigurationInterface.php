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
namespace KairosProject\ApiConfig\Definition;

/**
 * Nameable configuration interface
 *
 * This interface define the base methods available for a configuration that offer a name as key.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface NameableConfigurationInterface
{
    /**
     * Set name of the element
     *
     * Set the name used as key for the configuration element.
     *
     * @param string $name The name of the element
     *
     * @return $this
     */
    public function setName(string $name);

    /**
     * Get name of the element
     *
     * Return the name used as key for the configuration element.
     *
     * @return string
     */
    public function getName() : string;
}

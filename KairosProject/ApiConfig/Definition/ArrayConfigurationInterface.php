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

use KairosProject\ApiConfig\Definition\Exception\MalformedArrayException;

/**
 * Array configuration interface
 *
 * This interface define the base methods available when a configuration element can export an array representation of
 * itself, or import its configuration from an array.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ArrayConfigurationInterface
{
    /**
     * To array
     *
     * Dump the current configuration to an array representation.
     *
     * @return array
     */
    public function toArray() : array;

    /**
     * From array
     *
     * Load the configuration from an existing array. Could throw a MalformedArrayException if the given array cannot
     * be parsed to a valid configuration element.
     *
     * @param array $configuration The array to import
     *
     * @return static
     * @throws MalformedArrayException
     */
    public function fromArray(array $configuration);
}

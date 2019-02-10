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

use KairosProject\ApiConfig\Definition\Exception\DefaultValueException;

/**
 * Default configuration interface
 *
 * This interface define the base methods available when a configuration element present a default value.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DefaultConfigurationInterface
{
    /**
     * Mapping default value
     *
     * This constant define the mapping key where is located the default value conversion definition.
     *
     * @var string
     */
    public const MAPPING_DEFAULT_VALUE = 'defaultValue';

    /**
     * Mapping has default
     *
     * This constant define the mapping key where is located the default state conversion definition.
     *
     * @var string
     */
    public const MAPPING_HAS_DEFAULT = 'hasDefaultValue';

    /**
     * Set element default value
     *
     * This function is used to define the default value of a configuration element.
     *
     * @param mixed $defaultValue The default value to assign to the element
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue);

    /**
     * Remove default value
     *
     * Remove the default value assignment of the current element if this default exist.
     *
     * @return $this
     */
    public function removeDefaultValue();

    /**
     * Has default value
     *
     * Return the default value assignment state of the current element.
     *
     * @return bool
     */
    public function hasDefaultValue() : bool;

    /**
     * Get default value
     *
     * Return the default value of the element if it exist. This function could return a DefaultException if no any
     * default value was assigned before the getter is called.
     *
     * @return mixed
     * @throws DefaultValueException
     */
    public function getDefaultValue();
}

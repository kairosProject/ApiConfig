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

use KairosProject\ApiConfig\Definition\Exception\DefaultValueException;

/**
 * Default configuration trait
 *
 * This trait implement the base methods of the NameableConfigurationInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait DefaultConfigurationTrait
{
    /**
     * Default value
     *
     * Store the default value of the element
     *
     * @var mixed
     */
    private $defaultValue;

    /**
     * Has default value
     *
     * Define the current element default value existance state
     *
     * @var bool
     */
    private $hasDefaultValue = false;

    /**
     * Set element default value
     *
     * This function is used to define the default value of a configuration element.
     *
     * @param mixed $defaultValue The default value to assign to the element
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        $this->hasDefaultValue = true;

        return $this;
    }

    /**
     * Remove default value
     *
     * Remove the default value assignment of the current element if this default exist.
     *
     * @return $this
     */
    public function removeDefaultValue()
    {
        $this->hasDefaultValue = false();
        $this->defaultValue = null;

        return $this;
    }

    /**
     * Has default value
     *
     * Return the default value assignment state of the current element.
     *
     * @return bool
     */
    public function hasDefaultValue() : bool
    {
        return $this->hasDefaultValue;
    }

    /**
     * Get default value
     *
     * Return the default value of the element if it exist. This function could return a DefaultException if no any
     * default value was assigned before the getter is called.
     *
     * @return mixed
     * @throws DefaultValueException
     */
    public function getDefaultValue()
    {
        if ($this->hasDefaultValue) {
            return $this->defaultValue;
        }

        $message = sprintf(
            '%No default value assigned for the current element. Consider use of %s::hasDefaultValue()',
            static::class
        );
        throw new DefaultValueException($message);
    }
}

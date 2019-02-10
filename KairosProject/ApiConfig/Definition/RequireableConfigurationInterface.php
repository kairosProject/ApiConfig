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
 * Requireable configuration interface
 *
 * This interface define the base methods available for the configuration with required element value.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface RequireableConfigurationInterface
{
    /**
     * Mapping require
     *
     * This constant define the mapping key where is located the required state conversion definition.
     *
     * @var string
     */
    public const MAPPING_REQUIRE = 'requiredState';

    /**
     * Is element value required
     *
     * Return the required state of the element. This state could be take in account during the validation stage, after
     * components compilation. The result values must be true if a value is required for the element.
     *
     * @return bool
     */
    public function isRequired() : bool;

    /**
     * Set element value required
     *
     * Force the required state of the value for the current element.
     *
     * @return $this
     */
    public function setRequired();

    /**
     * Set element value un-required
     *
     * Force the required state of the value for the current element to false.
     *
     * @return $this
     */
    public function setUnRequired();
}

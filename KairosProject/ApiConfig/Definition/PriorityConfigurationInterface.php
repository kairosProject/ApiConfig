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
 * Priority configuration interface
 *
 * This interface define the base methods for the prioritized configuration.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface PriorityConfigurationInterface
{
    /**
     * Mapping priority
     *
     * This constant define the mapping key where is located the priority conversion definition.
     *
     * @var string
     */
    public const MAPPING_PRIORITY = 'priority';

    /**
     * Get configuration priority
     *
     * Return the priority assigned to the configuration to be used during the merging steps
     *
     * @return int
     */
    public function getPriority(): int;

    /**
     * Set configuration priority
     *
     * Set up the priority assigned to the configuration to be used during the merging steps
     *
     * @param int $priority The assigned priority value
     *
     * @return $this
     */
    public function setPriority(int $priority);
}

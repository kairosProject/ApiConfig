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
 * @category Api_Configuration_Merge
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace KairosProject\ApiConfig\Merge\Strategy;

/**
 * Merge strategy interface
 *
 * This interface is used to define the basic methods of the merging strategies, allowing them to be used with different
 * concrete implementation.
 *
 * @category Api_Configuration_Factory
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface MergeStrategyInterface
{
    /**
     * Merge
     *
     * This method merge a head configuration with a new configuration to inject. The head configuration represent the
     * latest merging state of the configuration.
     *
     * @param array $headConfig     The head configuration that receive the new configuration
     * @param array $injectedConfig The new configuration to inject
     *
     * @return mixed
     * @TODO:  define return value regarding merging expectations
     */
    public function merge(array $headConfig, array $injectedConfig);
}

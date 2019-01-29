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
namespace KairosProject\ApiConfig\Definition\Traits;

/**
 * Priority configuration trait
 *
 * This trait implement the base methods of the PriorityConfigurationInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait PriorityConfigurationTrait
{
    /**
     * The configuration priority
     *
     * This property store the priority assigned to the configuration to order the merging logic
     *
     * @var int
     */
    private $priority = 0;

    /**
     * Get configuration priority
     *
     * Return the priority assigned to the configuration to be used during the merging steps
     *
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Set configuration priority
     *
     * Set up the priority assigned to the configuration to be used during the merging steps
     *
     * @param int $priority The assigned priority value
     *
     * @return $this
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
        return $this;
    }
}

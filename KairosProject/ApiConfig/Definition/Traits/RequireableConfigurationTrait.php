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
 * Requireable configuration trait
 *
 * This trait implement the base methods of the RequireableConfigurationInterface in order to be used in concrete
 * classes.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait RequireableConfigurationTrait
{
    /**
     * Required state
     *
     * This property store the required value state of the current element.
     *
     * @var bool
     */
    private $requiredState = false;

    /**
     * Is element value required
     *
     * Return the required state of the element. This state could be take in account during the validation stage, after
     * components compilation. The result values must be true if a value is required for the element.
     *
     * @return bool
     */
    public function isRequired() : bool
    {
        return $this->requiredState;
    }

    /**
     * Set element value required
     *
     * Force the required state of the value for the current element.
     *
     * @return $this
     */
    public function setRequired()
    {
        $this->requiredState = true;

        return $this;
    }

    /**
     * Set element value un-required
     *
     * Force the required state of the value for the current element to false.
     *
     * @return $this
     */
    public function setUnRequired()
    {
        $this->requiredState = false;
    }
}

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
namespace KairosProject\ApiConfig\Definition\Visitor\Factory;

use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;

/**
 * Definition factory interface
 *
 * This interface define the based usable methods of the DefinitionFactory implementation
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DefinitionFactoryInterface
{
    /**
     * Get new instance
     *
     * Return a new fresh configuration definition instance with pre-initialisation but without configuration.
     *
     * @param array $representation The definition representation
     *
     * @return ConfigurationDefinitionInterface|DefinitionContainerInterface
     */
    public function getNewInstance(array $representation) : ConfigurationDefinitionInterface;

    /**
     * Support representation
     *
     * Indicate whether the current factory can instantiate a fresh instance based on the given representation.
     *
     * @param array $representation The definition representation
     *
     * @return bool
     */
    public function supportRepresentation(array $representation) : bool;
}

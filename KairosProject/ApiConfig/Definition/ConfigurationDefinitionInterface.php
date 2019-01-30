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
 * Configuration definition interface
 *
 * This interface define the base methods available when using the configuration definitions. It allow to specify the
 * options of a specific element and present the base methods for merging capability.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ConfigurationDefinitionInterface extends
    NameableConfigurationInterface,
    RequireableConfigurationInterface,
    DefaultConfigurationInterface,
    DescribedConfigurationInterface,
    ArrayConfigurationInterface,
    NestedDefinitionInterface
{
}

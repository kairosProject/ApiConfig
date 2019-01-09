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
 * Array mapping configuration interface
 *
 * This interface is used to represent the mapping information keys
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface ArrayMappingConfigurationInterface
{
    /**
     * Mapping info get
     *
     * Define the "get" mapping key
     *
     * @var string
     */
    public const MAPPING_GET = 'get';

    /**
     * Mapping info set
     *
     * Define the "set" mapping key
     *
     * @var string
     */
    public const MAPPING_SET = 'set';

    /**
     * Mapping info types
     *
     * Define the "types" mapping key
     *
     * @var string
     */
    public const MAPPING_TYPES = 'types';
}

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
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace KairosProject\ApiConfig\Tests\Definition;

use KairosProject\ApiConfig\Definition\ConfigurationDefinition;
use KairosProject\ApiConfig\Tests\Definition\Traits\NameableTestTrait;
use KairosProject\Tests\AbstractTestClass;

/**
 * Configuration definition test
 *
 * This class validate the ConfigurationDefinition methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConfigurationDefinitionTest extends AbstractTestClass
{
    use NameableTestTrait;

    /**
     * Get tested class
     *
     * Return the tested class name
     *
     * @return string
     */
    protected function getTestedClass(): string
    {
        return ConfigurationDefinition::class;
    }
}

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
use KairosProject\ApiConfig\Factory\OptionsResolverFactoryInterface;
use KairosProject\ApiConfig\Tests\Definition\Traits\ArrayTestTrait;
use KairosProject\ApiConfig\Tests\Definition\Traits\DefaultTestTrait;
use KairosProject\ApiConfig\Tests\Definition\Traits\DescribedTestTrait;
use KairosProject\ApiConfig\Tests\Definition\Traits\NameableTestTrait;
use KairosProject\ApiConfig\Tests\Definition\Traits\RequireableTestTrait;
use KairosProject\Tests\AbstractTestClass;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

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
    use NameableTestTrait,
        RequireableTestTrait,
        DescribedTestTrait,
        DefaultTestTrait,
        ArrayTestTrait;

    /**
     * Test constructor
     *
     * This method validate the constructor of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertConstructor(
            [
                'name' => 'nodeName',
                'same:expressionLanguage' => $this->createMock(ExpressionLanguage::class),
                'same:optionsResolverFactory' => $this->createMock(OptionsResolverFactoryInterface::class)
            ]
        );
    }

    /**
     * Get mapping
     *
     * Return the expected mapping computed by the tested instance
     *
     * @return array
     */
    protected function getMapping() : array
    {
        return [
            'defaultValue' => [
                'get' => 'config.hasDefaultValue() ? config.getDefaultValue() : null',
                'set' => 'array["hasDefaultValue"] ? config.setDefaultValue(array["defaultValue"]) : ""',
                'types' => []
            ],
            'hasDefaultValue' => [
                'get' => 'config.hasDefaultValue()',
                'set' => 'null',
                'types' => ['bool']
            ],
            'description' => [
                'get' => 'config.getDescription()',
                'set' => 'config.setDescription(array["description"])',
                'types' => ['string', 'null']
            ],
            'requiredState' => [
                'get' => 'config.isRequired()',
                'set' => 'array["requiredState"] ? config.setRequired() : config.setUnRequired()',
                'types' => ['bool']
            ]
        ];
    }

    /**
     * Test mapping structure
     *
     * This method validate the getMappingConfiguration method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testMappingStructure()
    {
        $instance = $this->getInstance();
        $this->assertProtectedMethod('getMappingConfiguration');
        $method = $this->getClassMethod('getMappingConfiguration', true);

        $result = $method->invoke($instance);

        $this->assertEquals($this->getMapping(), $result);
    }

    /**
     * Test default structure
     *
     * This method validate the getDefaultConfigurationMapping method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testDefaultStructure()
    {
        $instance = $this->getInstance();
        $this->assertPrivateMethod('getDefaultConfigurationMapping');
        $method = $this->getClassMethod('getDefaultConfigurationMapping', true);

        $result = $method->invoke($instance);

        $this->assertEquals(
            array_intersect_key(
                $this->getMapping(),
                ['defaultValue' => true, 'hasDefaultValue' => true]
            ),
            $result
        );
    }

    /**
     * Test described structure
     *
     * This method validate the getDescribedConfigurationMapping method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testDescribedStructure()
    {
        $instance = $this->getInstance();
        $this->assertPrivateMethod('getDescribedConfigurationMapping');
        $method = $this->getClassMethod('getDescribedConfigurationMapping', true);

        $result = $method->invoke($instance);

        $this->assertEquals(
            array_intersect_key(
                $this->getMapping(),
                ['description' => true]
            ),
            $result
        );
    }

    /**
     * Test requireable structure
     *
     * This method validate the getRequireableConfigurationMapping method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testRequireableStructure()
    {
        $instance = $this->getInstance();
        $this->assertPrivateMethod('getRequireableConfigurationMapping');
        $method = $this->getClassMethod('getRequireableConfigurationMapping', true);

        $result = $method->invoke($instance);

        $this->assertEquals(
            array_intersect_key(
                $this->getMapping(),
                ['requiredState' => true]
            ),
            $result
        );
    }

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

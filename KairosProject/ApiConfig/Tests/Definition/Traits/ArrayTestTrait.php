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

namespace KairosProject\ApiConfig\Tests\Definition\Traits;

use KairosProject\ApiConfig\Definition\ArrayMappingConfigurationInterface;
use KairosProject\ApiConfig\Definition\ConfigurationDefinition;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;
use KairosProject\ApiConfig\Definition\Exception\ConfigurationConversionException;
use KairosProject\ApiConfig\Definition\Exception\MalformedArrayException;
use KairosProject\ApiConfig\Definition\Exception\MappingConfigurationFormatException;
use KairosProject\ApiConfig\Factory\OptionsResolverFactory;
use KairosProject\ApiConfig\Factory\OptionsResolverFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Array definition test
 *
 * This class validate the ArrayConfigurationTrait methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ArrayTestTrait
{
    /**
     * Test toArray
     *
     * This method validate the toArray method of the ArrayConfigurationTrait class
     *
     * @param DefinitionContainerInterface|null $parent The parent instance to inject
     *
     * @return       void
     * @dataProvider provideParent
     */
    public function testToArray(?DefinitionContainerInterface $parent)
    {
        $instance = new ConfigurationDefinition('testName', new ExpressionLanguage(), new OptionsResolverFactory());

        $properties = [
            'defaultValue' => $this->createMock(\stdClass::class),
            'hasDefaultValue' => true,
            'description' => 'Test description',
            'requiredState' => true,
            'priority' => 1,
            'parent' => $parent
        ];

        foreach ($properties as $propertyName => $propertyValue) {
            $this->getClassProperty($propertyName)->setValue($instance, $propertyValue);
        }

        $this->assertSame($properties, $instance->toArray());
    }

    /**
     * Malformed array provider
     *
     * This method provide a set of malformed array and message pattern to validate the fromArray method of the
     * ArrayConfigurationTrait class in case of malformed array.
     *
     * @return array
     */
    public function provideMalformedArray()
    {
        return [
            [
                [
                    'defaultVal' => 'testDefault',
                    'hasDefaultValue' => true,
                    'description' => 'Test description',
                    'requiredState' => false,
                    'priority' => 1,
                    'parent' => null
                ],
                '/option "defaultVal" does not exist/',
                0
            ],
            [
                [
                    'defaultValue' => 'testDefault',
                    'hasDefaultValue' => 'value',
                    'description' => 'Test description',
                    'requiredState' => false,
                    'priority' => 1,
                    'parent' => $this->createMock(DefinitionContainerInterface::class)
                ],
                '/be of type "bool"/',
                0
            ],
            [
                [
                    'defaultValue' => 'testDefault',
                    'hasDefaultValue' => true,
                    'description' => 'Test description',
                    'requiredState' => false,
                    'priority' => 1,
                    'parent' => $this->createMock(\stdClass::class)
                ],
                '/be of type "null" or "KairosProject\\\\ApiConfig\\\\Definition\\\\DefinitionContainerInterface"/',
                0
            ]
        ];
    }

    /**
     * Test from malformed array
     *
     * This method validate the fromArray method of the ArrayConfigurationTrait class in case of malformed array
     *
     * @param array  $arguments The list of arguments to pass to the fromArray method
     * @param string $message   The expected message pattern of the exception
     * @param int    $code      The expected exception code
     *
     * @return       void
     * @dataProvider provideMalformedArray
     */
    public function testFromMalformedArray(array $arguments, string $message, int $code)
    {
        $this->expectException(MalformedArrayException::class);
        $this->expectExceptionMessageRegExp($message);
        $this->expectExceptionCode($code);
        $instance = new ConfigurationDefinition('testName', new ExpressionLanguage(), new OptionsResolverFactory());
        $instance->fromArray($arguments);
    }

    /**
     * Provide parent
     *
     * Return a set of available parent values
     *
     * @return array
     */
    public function provideParent()
    {
        return [
            [null],
            [$this->createMock(DefinitionContainerInterface::class)]
        ];
    }

    /**
     * Test fromArray
     *
     * This method validate the fromArray method of the ArrayConfigurationTrait class
     *
     * @param DefinitionContainerInterface|null $parent The assigned parent value
     *
     * @return       void
     * @dataProvider provideParent
     */
    public function testFromArray(?DefinitionContainerInterface $parent)
    {
        $instance = new ConfigurationDefinition('testName', new ExpressionLanguage(), new OptionsResolverFactory());

        $arguments = [
            'defaultValue' => 'testDefault',
            'hasDefaultValue' => true,
            'description' => 'Test description',
            'requiredState' => false,
            'priority' => 1,
            'parent' => $parent
        ];

        $this->assertSame($instance, $instance->fromArray($arguments));

        $this->assertEquals($arguments['defaultValue'], $this->getClassProperty('defaultValue')->getValue($instance));
        $this->assertEquals(
            $arguments['hasDefaultValue'],
            $this->getClassProperty('hasDefaultValue')->getValue($instance)
        );
        $this->assertEquals($arguments['description'], $this->getClassProperty('description')->getValue($instance));
        $this->assertEquals($arguments['requiredState'], $this->getClassProperty('requiredState')->getValue($instance));
        $this->assertEquals($arguments['priority'], $this->getClassProperty('priority')->getValue($instance));

        $this->assertEquals($arguments['parent'], $this->getClassProperty('parent')->getValue($instance));
        if (is_object($parent)) {
            $this->assertSame($arguments['parent'], $this->getClassProperty('parent')->getValue($instance));
        }
    }

    /**
     * Exception operation provider
     *
     * Provide a set of operation to fill the evaluateMapping parameters. This provider is used in order to validate
     * the exception throwing logic of the evaluateMapping regardless the executed operation.
     *
     * @return array
     */
    public function exceptionOperationProvider()
    {
        return [
            [ArrayMappingConfigurationInterface::MAPPING_GET],
            [ArrayMappingConfigurationInterface::MAPPING_SET]
        ];
    }

    /**
     * Test evaluateMapping on exception
     *
     * This method validate the evaluateMapping method of the ArrayConfigurationTrait class in case of thrown
     * exception by the expression language.
     *
     * @param string $configKey The tested operation
     *
     * @return       void
     * @dataProvider exceptionOperationProvider
     */
    public function testEvaluateMappingOnException(string $configKey)
    {
        $expressionLanguage = $this->createMock(ExpressionLanguage::class);
        $resolverFactory = $this->createMock(OptionsResolverFactoryInterface::class);
        $instance = $this->getInstance(
            [
                'expressionLanguage' => $expressionLanguage,
                'optionsResolverFactory' => $resolverFactory
            ]
        );
        $mappingMethod = $this->getClassMethod('getMappingConfiguration');
        $mapping = $mappingMethod->invoke($instance);

        $this->expectException(ConfigurationConversionException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(
            sprintf(
                'Expression cannot be evaluated for key %s. ()',
                array_keys($mapping)[0]
            )
        );

        $resolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($resolver, $this->any(), 'resolve')
            ->willReturn([$configKey => '']);
        $this->getInvocationBuilder($resolverFactory, $this->any(), 'getOptionsResolver')
            ->willReturn($resolver);

        $this->getInvocationBuilder($expressionLanguage, $this->once(), 'evaluate')
            ->willThrowException(new \RuntimeException('expected'));

        $method = $this->getClassMethod('evaluateMapping');
        $method->invokeArgs(
            $instance,
            [
                $configKey,
                []
            ]
        );
    }

    /**
     * Test evaluateMapping on SET
     *
     * This method validate the evaluateMapping method of the ArrayConfigurationTrait class
     *
     * @return void
     */
    public function testEvaluateMappingOnSet()
    {
        $expressionLanguage = $this->createMock(ExpressionLanguage::class);
        $resolverFactory = $this->createMock(OptionsResolverFactoryInterface::class);
        $instance = $this->getInstance(
            [
                'expressionLanguage' => $expressionLanguage,
                'optionsResolverFactory' => $resolverFactory
            ]
        );
        $payload = ['config' => $instance, 'array' => [$this->createMock(\stdClass::class)]];
        $configKey = ArrayMappingConfigurationInterface::MAPPING_SET;

        $mappingMethod = $this->getClassMethod('getMappingConfiguration');
        $mapping = $mappingMethod->invoke($instance);
        $returnValues = array_fill(0, count($mapping), null);
        $resultExpectation = array_combine(array_keys($mapping), $returnValues);

        $this->runEvaluateMapping(
            $instance,
            $expressionLanguage,
            $resolverFactory,
            $returnValues,
            $mapping,
            $payload,
            $resultExpectation,
            $configKey
        );
    }

    /**
     * Test evaluateMapping on GET
     *
     * This method validate the evaluateMapping method of the ArrayConfigurationTrait class
     *
     * @return void
     */
    public function testEvaluateMappingOnGet()
    {
        $expressionLanguage = $this->createMock(ExpressionLanguage::class);
        $resolverFactory = $this->createMock(OptionsResolverFactoryInterface::class);
        $instance = $this->getInstance(
            [
                'expressionLanguage' => $expressionLanguage,
                'optionsResolverFactory' => $resolverFactory
            ]
        );
        $payload = ['config' => $instance];
        $configKey = ArrayMappingConfigurationInterface::MAPPING_GET;

        $mappingMethod = $this->getClassMethod('getMappingConfiguration');
        $mapping = $mappingMethod->invoke($instance);
        $returnValues = range(1, count($mapping));
        $resultExpectation = array_combine(array_keys($mapping), $returnValues);

        $this->runEvaluateMapping(
            $instance,
            $expressionLanguage,
            $resolverFactory,
            $returnValues,
            $mapping,
            $payload,
            $resultExpectation,
            $configKey
        );
    }

    /**
     * Test buildConfigurationValidator
     *
     * This method validate the buildConfigurationArrayValidator of the ArrayConfigurationTrait class
     *
     * @return void
     */
    public function testBuildConfigurationValidator()
    {
        $mapping = $this->getMapping();
        $optionsResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($optionsResolver, $this->once(), 'setRequired')
            ->with($this->equalTo(array_keys($this->getMapping())));

        $this->getInvocationBuilder($optionsResolver, $this->exactly(count($mapping) - 1), 'setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('hasDefaultValue'), $this->equalTo(['bool'])],
                [$this->equalTo('description'), $this->equalTo(['string', 'null'])],
                [$this->equalTo('requiredState'), $this->equalTo(['bool'])],
                [$this->equalTo('priority'), $this->equalTo(['int'])],
                [$this->equalTo('parent'), $this->equalTo(['null', DefinitionContainerInterface::class])]
            );

        $miscResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($miscResolver, $this->exactly(count($mapping)), 'resolve')
            ->willReturnOnConsecutiveCalls(
                $mapping['defaultValue'],
                $mapping['hasDefaultValue'],
                $mapping['description'],
                $mapping['requiredState'],
                $mapping['priority'],
                $mapping['parent']
            );

        $resolverFactory = $this->createMock(OptionsResolverFactoryInterface::class);
        $this->getInvocationBuilder($resolverFactory, $this->exactly(2), 'getOptionsResolver')
            ->willReturnOnConsecutiveCalls($optionsResolver, $miscResolver);

        $instance = $this->getInstance(['optionsResolverFactory' => $resolverFactory]);
        $method = $this->getClassMethod('buildConfigurationArrayValidator');

        $this->assertSame($optionsResolver, $method->invoke($instance));
    }

    /**
     * Test getMapping exception
     *
     * This method validate the getMapping of the ArrayConfigurationTrait class in case of malformed configuration
     *
     * @return void
     */
    public function testGetMappingException()
    {
        $this->expectException(MappingConfigurationFormatException::class);
        $this->expectExceptionMessageRegExp('/for key "defaultValue"$/');
        $this->expectExceptionCode(0);

        $optionsResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($optionsResolver, $this->any(), 'setRequired');
        $this->getInvocationBuilder($optionsResolver, $this->any(), 'addAllowedTypes');

        $this->getInvocationBuilder($optionsResolver, $this->once(), 'resolve')
            ->willThrowException(new InvalidOptionsException('Exception message'));

        $optionsFactory = $this->createMock(OptionsResolverFactoryInterface::class);
        $this->getInvocationBuilder($optionsFactory, $this->once(), 'getOptionsResolver')
            ->willReturn($optionsResolver);

        $instance = $this->getInstance(['optionsResolverFactory' => $optionsFactory]);
        $method = $this->getClassMethod('getMapping');

        $method->invoke($instance);
    }
    /**
     * Test getMapping
     *
     * This method validate the getMapping of the ArrayConfigurationTrait class.
     *
     * @return void
     */
    public function testGetMapping()
    {
        $optionsResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($optionsResolver, $this->once(), 'setRequired')
            ->with($this->equalTo(['get', 'set', 'types']));

        $this->getInvocationBuilder($optionsResolver, $this->exactly(3), 'addAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('get'), $this->equalTo(['string'])],
                [$this->equalTo('set'), $this->equalTo(['string'])],
                [$this->equalTo('types'), $this->equalTo(['array'])]
            );

        $mapping = $this->getMapping();
        $this->getInvocationBuilder($optionsResolver, $this->exactly(count($mapping)), 'resolve')
            ->withConsecutive(
                [$this->equalTo($mapping['defaultValue'])],
                [$this->equalTo($mapping['hasDefaultValue'])],
                [$this->equalTo($mapping['description'])],
                [$this->equalTo($mapping['requiredState'])],
                [$this->equalTo($mapping['priority'])],
                [$this->equalTo($mapping['parent'])]
            )->willReturnOnConsecutiveCalls(
                $mapping['defaultValue'],
                $mapping['hasDefaultValue'],
                $mapping['description'],
                $mapping['requiredState'],
                $mapping['priority'],
                $mapping['parent']
            );


        $optionsFactory = $this->createMock(OptionsResolverFactoryInterface::class);
        $this->getInvocationBuilder($optionsFactory, $this->once(), 'getOptionsResolver')
            ->willReturn($optionsResolver);

        $instance = $this->getInstance(['optionsResolverFactory' => $optionsFactory]);
        $method = $this->getClassMethod('getMapping');
        $this->assertPrivateMethod('getMapping');

        $this->assertEquals($mapping, $method->invoke($instance));
    }
    /**
     * Run evaluate mapping
     *
     * Execute the evaluateMapping method test with the given configuration
     *
     * @param ConfigurationDefinition $instance           The tested instance
     * @param MockObject              $expressionLanguage The injected expression language
     * @param MockObject              $resolverFactory    The injected optionsResolver factory
     * @param array                   $returnValues       The expression language consecutive return values
     * @param array                   $mapping            The tested instance mapping
     * @param array                   $payload            The evaluation call payload
     * @param array                   $resultExpectation  The expected result
     * @param string                  $configKey          The evaluation operation key
     *
     * @return void
     */
    private function runEvaluateMapping(
        ConfigurationDefinition $instance,
        MockObject $expressionLanguage,
        MockObject $resolverFactory,
        array $returnValues,
        array $mapping,
        array $payload,
        array $resultExpectation,
        string $configKey
    ) {
        $optionResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($optionResolver, $this->exactly(count($mapping)), 'resolve')
            ->willReturnOnConsecutiveCalls(...array_values($mapping));
        $this->getInvocationBuilder($resolverFactory, $this->any(), 'getOptionsResolver')
            ->willReturn($optionResolver);

        $consecutiveArguments = [];
        foreach ($mapping as $config) {
            $consecutiveArguments[] = [
                $this->equalTo($config[$configKey]),
                $this->identicalTo($payload)
            ];
        }
        $this->getInvocationBuilder(
            $expressionLanguage,
            $this->exactly(
                count($mapping)
            ),
            'evaluate'
        )->withConsecutive(
            ...$consecutiveArguments
        )->willReturnOnConsecutiveCalls(
            ...$returnValues
        );

        $method = $this->getClassMethod('evaluateMapping');
        $result = $method->invokeArgs(
            $instance,
            [
                $configKey,
                $payload
            ]
        );
        $this->assertEquals(
            $resultExpectation,
            $result
        );
    }

    /**
     * Get mapping
     *
     * Return the expected mapping computed by the tested instance
     *
     * @return array
     */
    abstract protected function getMapping() : array;
}

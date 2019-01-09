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

use KairosProject\ApiConfig\Definition\Exception\MappingConfigurationFormatException;
use KairosProject\ApiConfig\Factory\OptionsResolverFactoryInterface;
use KairosProject\Tests\AbstractTestClass;
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
     * Test buildConfigurationValidator
     *
     * This method validate the buildConfigurationArrayValidator of the DescribedConfigurationTrait class
     *
     * @return void
     */
    public function testBuildConfigurationValidator()
    {
        $mapping = $this->getMapping();
        $optionsResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($optionsResolver, $this->once(), 'setRequired')
            ->with($this->equalTo(array_keys($this->getMapping())));

        $this->getInvocationBuilder($optionsResolver, $this->exactly(3), 'setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('hasDefaultValue'), $this->equalTo(['bool'])],
                [$this->equalTo('description'), $this->equalTo(['string', 'null'])],
                [$this->equalTo('requiredState'), $this->equalTo(['bool'])]
            );

        $miscResolver = $this->createMock(OptionsResolver::class);
        $this->getInvocationBuilder($miscResolver, $this->exactly(4), 'resolve')
            ->willReturnOnConsecutiveCalls(
                $mapping['defaultValue'],
                $mapping['hasDefaultValue'],
                $mapping['description'],
                $mapping['requiredState']
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
     * This method validate the getMapping of the DescribedConfigurationTrait class in case of malformed configuration
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
     * This method validate the getMapping of the DescribedConfigurationTrait class.
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
                [$this->equalTo($mapping['requiredState'])]
            )->willReturnOnConsecutiveCalls(
                $mapping['defaultValue'],
                $mapping['hasDefaultValue'],
                $mapping['description'],
                $mapping['requiredState']
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
     * Get mapping
     *
     * Return the expected mapping computed by the tested instance
     *
     * @return array
     */
    abstract protected function getMapping() : array;
}

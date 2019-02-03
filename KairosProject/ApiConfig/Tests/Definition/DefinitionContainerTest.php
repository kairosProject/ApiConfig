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

use KairosProject\ApiConfig\Definition\DefinitionContainer;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;
use KairosProject\ApiConfig\Tests\Definition\Traits\ContainerTestTrait;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Definition container test
 *
 * This class validate the DefinitionContainer methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DefinitionContainerTest extends ConfigurationDefinitionTest
{
    use ContainerTestTrait;

    /**
     * Configure optionsResolver
     *
     * Configure the mock object to be used as optionsResolver
     *
     * @param MockObject $optionsResolver The optionsResolver instance to configure
     * @param array      $mapping         The current mapping
     *
     * @return void
     */
    protected function configureOptionsResolver(MockObject $optionsResolver, array $mapping): void
    {
        $this->getInvocationBuilder($optionsResolver, $this->exactly(count($mapping)), 'resolve')
            ->withConsecutive(
                [$this->equalTo($mapping['defaultValue'])],
                [$this->equalTo($mapping['hasDefaultValue'])],
                [$this->equalTo($mapping['description'])],
                [$this->equalTo($mapping['requiredState'])],
                [$this->equalTo($mapping['priority'])],
                [$this->equalTo($mapping['parent'])],
                [$this->equalTo($mapping['children'])]
            )->willReturnOnConsecutiveCalls(
                $mapping['defaultValue'],
                $mapping['hasDefaultValue'],
                $mapping['description'],
                $mapping['requiredState'],
                $mapping['priority'],
                $mapping['parent'],
                $mapping['children']
            );
    }

    /**
     * Configure validator allowed types
     *
     * Configure the mock object to be used as optionsResolver
     *
     * @param MockObject $optionsResolver The optionsResolver instance to configure
     * @param array      $mapping         The current mapping
     *
     * @return void
     */
    protected function configureValidatorAllowedTypes(MockObject $optionsResolver, array $mapping)
    {
        $this->getInvocationBuilder($optionsResolver, $this->exactly(count($mapping) - 1), 'setAllowedTypes')
            ->withConsecutive(
                [$this->equalTo('hasDefaultValue'), $this->equalTo(['bool'])],
                [$this->equalTo('description'), $this->equalTo(['string', 'null'])],
                [$this->equalTo('requiredState'), $this->equalTo(['bool'])],
                [$this->equalTo('priority'), $this->equalTo(['int'])],
                [$this->equalTo('parent'), $this->equalTo(['null', DefinitionContainerInterface::class])],
                [$this->equalTo('children'), $this->equalTo(['array'])]
            );
    }

    /**
     * Get mapping
     *
     * Return the expected mapping computed by the tested instance
     *
     * @return array
     */
    protected function getMapping(): array
    {
        $mapping = parent::getMapping();

        $mapping['children'] = [
            'get' => 'config.getChildren()',
            'set' => 'config.setChildren(array["children"])',
            'types' => ['array']
        ];

        return $mapping;
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
        return DefinitionContainer::class;
    }
}

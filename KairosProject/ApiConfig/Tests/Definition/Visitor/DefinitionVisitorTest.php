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
namespace KairosProject\ApiConfig\Tests\Definition\Visitor;

use KairosProject\ApiConfig\Definition\ConfigurationDefinition;
use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainer;
use KairosProject\ApiConfig\Definition\Visitor\DefinitionVisitor;
use KairosProject\ApiConfig\Factory\OptionsResolverFactory;
use KairosProject\Tests\AbstractTestClass;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Yaml\Yaml;

/**
 * Definition visitor test
 *
 * This class validate the DefinitionVisitor methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DefinitionVisitorTest extends AbstractTestClass
{
    /**
     * Provide tree representation
     *
     * This method provide a representation of a configuration tree in order to test the definition visitor
     *
     * @return array
     */
    public function provideTreeRepresentation()
    {
        $trees = [];
        $yaml = new Yaml();
        foreach (glob(__DIR__.'/DataFixtures/treeRepresentation*.yaml') as $fixture) {
            $trees[] = [$yaml->parseFile($fixture)];
        }

        return $trees;
    }

    /**
     * Test dumpTreeToArray
     *
     * This method validate the dumpTreeToArray method of the DefinitionVisitor class.
     *
     * @param array $tree The tested tree representation
     *
     * @return       void
     * @dataProvider provideTreeRepresentation
     */
    public function testDumpTreeToArray(array $tree)
    {
        $definition = $this->buildDefinition($tree)[0];
        $instance = $this->getInstance();
        $this->assertEquals($tree, $instance->dumpTreeToArray($definition));
    }

    /**
     * Build definition
     *
     * Build an array of definition accordingly to a configuration array in order to be used by the dumping test
     *
     * @param array                                 $config The definition tree configuration
     * @param null|ConfigurationDefinitionInterface $parent The parent of the currently building definitions
     *
     * @return array
     */
    private function buildDefinition(array $config, ConfigurationDefinitionInterface $parent = null)
    {
        $expressionLanguage = new ExpressionLanguage();
        $factory = new OptionsResolverFactory();

        $definitions = [];
        foreach ($config as $name => $properties) {
            $class = ConfigurationDefinition::class;
            if (isset($properties['children'])) {
                $class = DefinitionContainer::class;
            }
            $def = new $class($name, $expressionLanguage, $factory);

            $def->setParent($parent)
                ->setDescription($properties['description'])
                ->setPriority($properties['priority']);

            if ($properties['hasDefaultValue']) {
                $def->setDefaultValue($properties['defaultValue']);
            }

            if ($properties['requiredState']) {
                $def->setRequired();
            }

            if (isset($properties['children']) && $def instanceof DefinitionContainer) {
                $def->setChildren(
                    $this->buildDefinition($properties['children'], $def)
                );
            }

            array_push($definitions, $def);
        }

        return $definitions;
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
        return DefinitionVisitor::class;
    }
}

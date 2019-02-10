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
namespace KairosProject\ApiConfig\Definition\Visitor;

use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;
use KairosProject\ApiConfig\Definition\NestedDefinitionInterface;
use KairosProject\ApiConfig\Definition\Visitor\Exception\UnsupportedRepresentationException;
use KairosProject\ApiConfig\Definition\Visitor\Factory\DefinitionFactoryInterface;

/**
 * Definition visitor
 *
 * This class is the default implementation of the DefinitionVisitorInterface.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DefinitionVisitor implements DefinitionVisitorInterface
{
    /**
     * Definition factory
     *
     * Store the definition factory in order to be used during the array representation parsing
     *
     * @var DefinitionFactoryInterface
     */
    private $definitionFactory;

    /**
     * DefinitionVisitor constructor.
     *
     * The default DefinitionVisitor constructor store the definition factory in order to be used by the array
     * representation parsing process.
     *
     * @param DefinitionFactoryInterface $definitionFactory The definition factory to load fresh instances
     *
     * @return void
     */
    public function __construct(DefinitionFactoryInterface $definitionFactory)
    {
        $this->definitionFactory = $definitionFactory;
    }

    /**
     * Dump tree to array
     *
     * Dump a definition tree to its array representation. This method accept as least a basic ConfigurationDefinition
     * instance as first level element.
     *
     * @param ConfigurationDefinitionInterface $treeElement The first element of a tree with nested elements inside
     *
     * @return array
     */
    public function dumpTreeToArray(ConfigurationDefinitionInterface $treeElement): array
    {
        $representation = $treeElement->toArray();

        unset($representation[NestedDefinitionInterface::MAPPING_NESTED]);

        if ($treeElement instanceof DefinitionContainerInterface) {
            $representation[DefinitionContainerInterface::MAPPING_CHILDREN] = [];
            foreach ($treeElement->getChildren() as $child) {
                $representation[DefinitionContainerInterface::MAPPING_CHILDREN] = array_merge(
                    $representation[DefinitionContainerInterface::MAPPING_CHILDREN],
                    $this->dumpTreeToArray($child)
                );
            }
        }

        return [
            $treeElement->getName() => $representation
        ];
    }

    /**
     * Parse from array
     *
     * Parse an array representation of a definition tree to a valid nested configuration definition instance tree.
     * This method may return, at least a valid ConfigurationDefinition element.
     *
     * @param array $arrayRepresentation The configuration tree representation in array form
     *
     * @return ConfigurationDefinitionInterface[]
     * @throws UnsupportedRepresentationException
     */
    public function parseFromArray(array $arrayRepresentation): array
    {
        $parsedElements = [];
        foreach ($arrayRepresentation as $name => $representation) {
            if (!$this->definitionFactory->supportRepresentation($representation)) {
                throw new UnsupportedRepresentationException(
                    sprintf(
                        'Unsupported representation given for key %s',
                        $name
                    )
                );
            }

            if (isset($arrayRepresentation[DefinitionContainerInterface::MAPPING_CHILDREN])) {
                $parsedElements[] = $this->processContainer($name, $arrayRepresentation);
                continue;
            }

            $parsedElements[] = $this->processDefinition($name, $arrayRepresentation);
        }

        return $parsedElements;
    }

    /**
     * Process container
     *
     * Build a new definition container implementation accordingly to the given representation
     *
     * @param string $name                The given node name
     * @param array  $arrayRepresentation The node representation
     *
     * @return DefinitionContainerInterface
     */
    private function processContainer(string $name, array $arrayRepresentation) : DefinitionContainerInterface
    {
        $childList = [];
        foreach ($arrayRepresentation[DefinitionContainerInterface::MAPPING_CHILDREN] as $child) {
            $childList[] = $this->parseFromArray($child);
        }
        $arrayRepresentation[DefinitionContainerInterface::MAPPING_CHILDREN] = $childList;

        $definition = $this->definitionFactory->getNewInstance(
            array_merge(['name' => $name], $arrayRepresentation)
        );
        $definition->fromArray($arrayRepresentation);

        return $definition;
    }

    /**
     * Process definition
     *
     * Build a new definition implementation accordingly to the given representation
     *
     * @param string $name                The given node name
     * @param array  $arrayRepresentation The node representation
     *
     * @return ConfigurationDefinitionInterface
     */
    private function processDefinition(string $name, array $arrayRepresentation) : ConfigurationDefinitionInterface
    {
        $definition = $this->definitionFactory->getNewInstance(
            array_merge(['name' => $name], $arrayRepresentation)
        );
        $definition->fromArray($arrayRepresentation);

        return $definition;
    }
}

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

/**
 * Definition visitor interface
 *
 * This interface define the methods of the definition visitor. The visitor itself have the responsibility to process
 * a recursive array transformation od a nested set of definition. It also have to process the recursive from array
 * parsing.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DefinitionVisitorInterface
{
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
    public function dumpTreeToArray(ConfigurationDefinitionInterface $treeElement) : array;

    /**
     * Parse from array
     *
     * Parse an array representation of a definition tree to a valid nested configuration definition instance tree.
     * This method may return, at least a valid ConfigurationDefinition element.
     *
     * @param array $arrayRepresentation The configuration tree representation in array form
     *
     * @return ConfigurationDefinitionInterface[]
     */
    public function parseFromArray(array $arrayRepresentation) : array;
}

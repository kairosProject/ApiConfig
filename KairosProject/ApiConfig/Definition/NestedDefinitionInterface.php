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
 * Nested configuration interface
 *
 * This interface define the base relevant method to nested configuration element
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface NestedDefinitionInterface
{
    /**
     * Mapping nested
     *
     * This constant define the mapping key where is located the nested conversion definition.
     *
     * @var string
     */
    public const MAPPING_NESTED = 'parent';

    /**
     * Set parent
     *
     * Set the configuration parent. Automatically update the parent child store with the current instance. If null
     * is given, then the parent is expected to be updated to remove the configuration from the children list.
     *
     * @param DefinitionContainerInterface|null $parent The parent instance
     *
     * @return $this
     */
    public function setParent(?DefinitionContainerInterface $parent);

    /**
     * Get parent
     *
     * Return the parent of the current configuration if exist, or return null if top level configuration
     *
     * @return DefinitionContainerInterface|null
     */
    public function getParent() : ?DefinitionContainerInterface;
}

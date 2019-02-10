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
 * Configuration container interface
 *
 * This interface define the base relevant method to manage container of configuration
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DefinitionContainerInterface extends ConfigurationDefinitionInterface
{
    /**
     * Mapping children
     *
     * This constant define the mapping key where is located the children conversion definition.
     *
     * @var string
     */
    public const MAPPING_CHILDREN = 'children';

    /**
     * Add child
     *
     * Add a unique configuration as child. Also automatically update the given instance parent to be the current
     * configuration, disallowing a child to have multiples parents.
     *
     * @param ConfigurationDefinitionInterface $child The child instance to inject
     *
     * @return $this
     */
    public function addChild(ConfigurationDefinitionInterface $child);

    /**
     * Detach child
     *
     * Detach a child from the current instance. Automatically update the child to remove the parent information,
     * avaiding orphan state for the configurations.
     *
     * @param ConfigurationDefinitionInterface $child The child to detach
     *
     * @return $this
     */
    public function detachChild(ConfigurationDefinitionInterface $child);

    /**
     * Has child
     *
     * Check if a configuration instance is currently a child of the current one.
     *
     * @param ConfigurationDefinitionInterface $child The child instance to test
     *
     * @return bool
     */
    public function hasChild(ConfigurationDefinitionInterface $child) : bool;

    /**
     * Clear children
     *
     * Act as a detachChild iterator for each instance children.
     *
     * @return $this
     * @see    NestedDefinitionInterface::detachChild()
     */
    public function clearChildren();

    /**
     * Set children
     *
     * Act as a addChild iterator for each given element.
     *
     * @param ConfigurationDefinitionInterface[] $children The list of child to attach
     *
     * @return $this
     * @see    NestedDefinitionInterface::addChild()
     */
    public function setChildren(array $children);

    /**
     * Get children
     *
     * Return the list of stored children for the current configuration
     *
     * @return ConfigurationDefinitionInterface[]
     */
    public function getChildren() : array;
}

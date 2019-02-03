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
namespace KairosProject\ApiConfig\Definition\Traits;

use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;

/**
 * Configuration container trait
 *
 * This trait implement the base methods of the DefinitionContainerInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ConfigurationContainerTrait
{
    /**
     * Children
     *
     * Store the children of the current definition as an associative array, containing the child object id as key
     * and the object itself as value
     *
     * @var ConfigurationDefinitionInterface[]
     */
    private $children = [];

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
    public function addChild(ConfigurationDefinitionInterface $child)
    {
        $objectId = spl_object_id($child);
        if (!isset($this->children[$objectId])) {
            $this->children[$objectId] = $child;
            $this->updateParent($child);
        }

        return $this;
    }

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
    public function detachChild(ConfigurationDefinitionInterface $child)
    {
        $objectId = spl_object_id($child);
        if (isset($this->children[$objectId])) {
            unset($this->children[$objectId]);
            $this->removeParent($child);
        }

        return $this;
    }

    /**
     * Has child
     *
     * Check if a configuration instance is currently a child of the current one.
     *
     * @param ConfigurationDefinitionInterface $child The child instance to test
     *
     * @return bool
     */
    public function hasChild(ConfigurationDefinitionInterface $child): bool
    {
        return isset($this->children[spl_object_id($child)]);
    }

    /**
     * Clear children
     *
     * Act as a detachChild iterator for each instance children.
     *
     * @return $this
     * @see    NestedDefinitionInterface::detachChild()
     */
    public function clearChildren()
    {
        foreach ($this->children as $child) {
            $this->detachChild($child);
        }

        return $this;
    }

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
    public function setChildren(array $children)
    {
        $this->clearChildren();
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Get children
     *
     * Return the list of stored children for the current configuration
     *
     * @return ConfigurationDefinitionInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Remove parent
     *
     * Remove the current instance from the child instance
     *
     * @param ConfigurationDefinitionInterface $child The child instance to update
     *
     * @return void
     */
    private function removeParent(ConfigurationDefinitionInterface $child) : void
    {
        if ($child->getParent() === $this) {
            $child->setParent(null);
        }
    }

    /**
     * Update parent
     *
     * Update the child parent to reflect the relation between the child and the current instance
     *
     * @param ConfigurationDefinitionInterface $child The child instance to update
     *
     * @return void
     */
    private function updateParent(ConfigurationDefinitionInterface $child) : void
    {
        if ($child->getParent() !== $this) {
            $child->setParent($this);
        }
    }
}

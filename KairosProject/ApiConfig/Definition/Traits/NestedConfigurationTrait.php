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

use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;

/**
 * Nested configuration trait
 *
 * This trait implement the base methods of the NestedDefinitionInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait NestedConfigurationTrait
{
    /**
     * Parent
     *
     * Store the parent of the current definition if not on first configuration level
     *
     * @var DefinitionContainerInterface|null
     */
    private $parent;

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
    public function setParent(?DefinitionContainerInterface $parent)
    {
        if ($this->parent !== $parent) {
            $this->detachSelf();
            $this->parent = $parent;
            $this->attachSelf();
        }

        return $this;
    }

    /**
     * Get parent
     *
     * Return the parent of the current configuration if exist, or return null if top level configuration
     *
     * @return DefinitionContainerInterface|null
     */
    public function getParent(): ?DefinitionContainerInterface
    {
        return $this->parent;
    }

    /**
     * Detach self
     *
     * Detach the current instance from its parent if exist
     *
     * @return void
     */
    private function detachSelf() : void
    {
        if ($this->parent) {
            $this->parent->detachChild($this);
        }
    }

    /**
     * Attach self
     *
     * Attach the current instance to its parent if exist
     *
     * @return void
     */
    private function attachSelf() : void
    {
        if ($this->parent && !$this->parent->hasChild($this)) {
            $this->parent->addChild($this);
        }
    }
}

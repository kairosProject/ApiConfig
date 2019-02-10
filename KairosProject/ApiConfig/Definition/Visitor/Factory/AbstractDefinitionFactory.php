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
namespace KairosProject\ApiConfig\Definition\Visitor\Factory;

use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;

/**
 * Abstract definition factory
 *
 * This class is used as placeholder for definition factory and provide helper method for representation structure
 * check.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractDefinitionFactory implements DefinitionFactoryInterface
{
    /**
     * Get new instance
     *
     * Return a new fresh configuration definition instance with pre-initialisation but without configuration.
     *
     * @param array $representation The definition representation
     *
     * @return ConfigurationDefinitionInterface|DefinitionContainerInterface
     */
    abstract public function getNewInstance(array $representation): ConfigurationDefinitionInterface;

    /**
     * Support representation
     *
     * Indicate whether the current factory can instantiate a fresh instance based on the given representation.
     *
     * @param array $representation The definition representation
     *
     * @return bool
     */
    public function supportRepresentation(array $representation): bool
    {
        $keyDefinition = $this->getKeyDefinition();

        foreach ($keyDefinition as $keyName => $allowedTypes) {
            if (!array_key_exists($keyName, $representation)
                || (is_array($allowedTypes) && !in_array(gettype($representation[$keyName]), $allowedTypes))
                || (is_string($allowedTypes) && gettype($representation[$keyName]) !== $allowedTypes)
            ) {
                return false;
            }
        }

        if (!empty(array_diff(array_keys($representation), array_keys($keyDefinition)))) {
            return false;
        }

        return true;
    }

    /**
     * Get key definition
     *
     * Return the definition of the key for the supported representation. The key name have to be the key of the
     * definition, the value is a set of allowed types for the representation key value.
     * The allowed type can be false to avoid type matching check, a specific gettype return value or a set of them.
     *
     * @return  array
     * @example return ['description' => ['string', 'NULL'], 'defaultValue' => false, 'hesDefaultValue' => 'boolean']
     */
    abstract protected function getKeyDefinition() : array;
}

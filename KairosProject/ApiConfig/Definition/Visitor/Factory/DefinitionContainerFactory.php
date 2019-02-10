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
use KairosProject\ApiConfig\Definition\DefinitionContainer;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;

/**
 * Definition container factory
 *
 * This class provide a new fresh instance of DefinitionContainer instance, pre-initialized with the given
 * representation.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class DefinitionContainerFactory extends ConfigurationDefinitionFactory
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
    public function getNewInstance(array $representation): ConfigurationDefinitionInterface
    {
        return new DefinitionContainer(
            $representation[self::KEY_NAME],
            $this->expressionLanguage,
            $this->resolverFactory
        );
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
    protected function getKeyDefinition(): array
    {
        return array_merge(
            parent::getKeyDefinition(),
            [DefinitionContainerInterface::MAPPING_CHILDREN => 'array']
        );
    }
}

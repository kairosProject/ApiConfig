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

use KairosProject\ApiConfig\Definition\ConfigurationDefinition;
use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefaultConfigurationInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;
use KairosProject\ApiConfig\Definition\DescribedConfigurationInterface;
use KairosProject\ApiConfig\Definition\NestedDefinitionInterface;
use KairosProject\ApiConfig\Definition\PriorityConfigurationInterface;
use KairosProject\ApiConfig\Definition\RequireableConfigurationInterface;
use KairosProject\ApiConfig\Factory\OptionsResolverFactoryInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Configuration definition factory
 *
 * This class provide a new fresh instance of ConfigurationDefinition instance, pre-initialized with the given
 * representation.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ConfigurationDefinitionFactory extends AbstractDefinitionFactory
{
    /**
     * Key name
     *
     * Define the required key name for representation name
     *
     * @var string
     */
    protected const KEY_NAME = 'name';

    /**
     * Expression language
     *
     * Store the expression language instance to be injected into the new ConfigurationDefinition instance
     *
     * @var ExpressionLanguage
     */
    protected $expressionLanguage;

    /**
     * Resolver factory
     *
     * Store the OptionsResilverFactory instance to be injected into the new ConfigurationDefinition instance
     *
     * @var OptionsResolverFactoryInterface
     */
    protected $resolverFactory;

    /**
     * ConfigurationDefinitionFactory constructor.
     *
     * Store the expression language and the OptionsResolverFactory to be injected into the new ConfigurationDefinition
     * instance.
     *
     * @param ExpressionLanguage              $expressionLanguage The expression language instance
     * @param OptionsResolverFactoryInterface $resolverFactory    The OptionsResolverFactory instance
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        OptionsResolverFactoryInterface $resolverFactory
    ) {
        $this->expressionLanguage = $expressionLanguage;
        $this->resolverFactory = $resolverFactory;
    }

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
        return new ConfigurationDefinition(
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
        return [
            self::KEY_NAME => 'string',
            NestedDefinitionInterface::MAPPING_NESTED => ['null', 'object'],
            PriorityConfigurationInterface::MAPPING_PRIORITY => 'int',
            RequireableConfigurationInterface::MAPPING_REQUIRE => 'boolean',
            DescribedConfigurationInterface::MAPPING_DESCRIPTION => ['string', 'NULL'],
            DefaultConfigurationInterface::MAPPING_DEFAULT_VALUE => false,
            DefaultConfigurationInterface::MAPPING_HAS_DEFAULT => 'boolean'
        ];
    }
}

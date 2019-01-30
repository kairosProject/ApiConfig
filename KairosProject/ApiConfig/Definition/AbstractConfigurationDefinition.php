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

use KairosProject\ApiConfig\Definition\Traits\ArrayConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\DefaultConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\DescribedConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\NameableConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\NestedConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\PriorityConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\RequireableConfigurationTrait;
use KairosProject\ApiConfig\Factory\OptionsResolverFactoryInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use KairosProject\ApiConfig\Definition\ArrayMappingConfigurationInterface as MappingKey;

/**
 * Abstract configuration definition
 *
 * This class encapsulate the default behavior of the configuration definition by using the configuration traits
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractConfigurationDefinition implements ConfigurationDefinitionInterface
{
    use DefaultConfigurationTrait,
        DescribedConfigurationTrait,
        NameableConfigurationTrait,
        RequireableConfigurationTrait,
        ArrayConfigurationTrait,
        PriorityConfigurationTrait,
        NestedConfigurationTrait;

    /**
     * AbstractConfigurationDefinition constructor.
     *
     * The default AbstractConfigurationDefinition constructor. Will store an ExpressionLanguage instance for array
     * conversion and an OptionsResolverFactory to validate the mappings.
     * In addition, the key name have to be identified.
     *
     * @param string                          $name               The key name
     * @param ExpressionLanguage              $expressionLanguage The expression language instance
     * @param OptionsResolverFactoryInterface $optionsResolver    The OptionsResolver factory instance
     *
     * @return void
     */
    public function __construct(
        string $name,
        ExpressionLanguage $expressionLanguage,
        OptionsResolverFactoryInterface $optionsResolver
    ) {
        $this->setName($name);
        $this->expressionLanguage = $expressionLanguage;
        $this->optionsResolverFactory = $optionsResolver;
    }

    /**
     * Get mapping configuration
     *
     * This method return the mapping definition for the configuration element. Each resulting array key will contain
     * an expression to be parsed by the ExpressionLanguage component.
     * The expression will have access to the config variable, representing the current element. An array variable is
     * also accessible in the set side, granting access to the array to parse.
     *
     * @return  array
     * @example <pre>
     *      return [
     *          'name' => [
     *              ArrayMappingConfigurationInterface::MAPPING_GET => 'config.getName()',
     *              ArrayMappingConfigurationInterface::MAPPING_SET => 'config.setName(value)',
     *              ArrayMappingConfigurationInterface::MAPPING_TYPES => ['string']
     *          ],
     *          'defaultValue' => [
     *              ArrayMappingConfigurationInterface::MAPPING_GET =>
     *                  'config.hasDefaultValue() ? config.getDefaultValue() : null',
     *              ArrayMappingConfigurationInterface::MAPPING_SET =>
     *                  'array[hasDefaultValue] ? config.setDefaultValue(value) : null',
     *              ArrayMappingConfigurationInterface::MAPPING_TYPES =>
     *                  ['array', 'null']
     *          ],
     *          'hasDefaultValue' => [
     *              ArrayMappingConfigurationInterface::MAPPING_GET => 'config.hasDefaultValue()',
     *              ArrayMappingConfigurationInterface::MAPPING_SET => '',
     *              ArrayMappingConfigurationInterface::MAPPING_TYPES => ['bool']
     *          ],
     *          ...
     *      ];
     * </pre>
     */
    protected function getMappingConfiguration(): array
    {
        return array_merge(
            $this->getDefaultConfigurationMapping(),
            $this->getDescribedConfigurationMapping(),
            $this->getRequireableConfigurationMapping(),
            $this->getPriorityConfiguration()
        );
    }

    /**
     * Get priority configuration
     *
     * Return the array to configure the relevant mapping, regarding the priority support.
     *
     * @return array
     */
    private function getPriorityConfiguration() : array
    {
        $priority = [
            MappingKey::MAPPING_GET => 'config.getPriority()',
            MappingKey::MAPPING_SET => 'config.setPriority(array["priority"])',
            MappingKey::MAPPING_TYPES => ['int']
        ];

        return ['priority' => $priority];
    }

    /**
     * Get requireable configuration mapping
     *
     * Return an array to configure the relevant mapping, regarding the value required state support.
     *
     * @return array
     */
    private function getRequireableConfigurationMapping() : array
    {
        $requiredState = [
            MappingKey::MAPPING_GET => 'config.isRequired()',
            MappingKey::MAPPING_SET => 'array["requiredState"] ? config.setRequired() : config.setUnRequired()',
            MappingKey::MAPPING_TYPES => ['bool']
        ];

        return ['requiredState' => $requiredState];
    }

    /**
     * Get described configuration mapping
     *
     * Return an array to configure the relevant mapping, regarding the description support.
     *
     * @return array
     */
    private function getDescribedConfigurationMapping() : array
    {
        $description = [
            MappingKey::MAPPING_GET => 'config.getDescription()',
            MappingKey::MAPPING_SET => 'config.setDescription(array["description"])',
            MappingKey::MAPPING_TYPES => ['string', 'null']
        ];

        return ['description' => $description];
    }

    /**
     * Get default configuration mapping
     *
     * Return an array to configure the relevant mapping, regarding the default value support.
     *
     * @return array
     */
    private function getDefaultConfigurationMapping() : array
    {
        $defaultValueSetter = 'array["hasDefaultValue"] ? config.setDefaultValue(array["defaultValue"]) : ""';

        $defaultValue = [
            MappingKey::MAPPING_GET => 'config.hasDefaultValue() ? config.getDefaultValue() : null',
            MappingKey::MAPPING_SET => $defaultValueSetter,
            MappingKey::MAPPING_TYPES => []
        ];

        $hasDefaultValue = [
            MappingKey::MAPPING_GET => 'config.hasDefaultValue()',
            MappingKey::MAPPING_SET => 'null',
            MappingKey::MAPPING_TYPES => ['bool']
        ];

        return compact('defaultValue', 'hasDefaultValue');
    }
}

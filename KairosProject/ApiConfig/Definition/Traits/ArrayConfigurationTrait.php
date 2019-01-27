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

use KairosProject\ApiConfig\Definition\ArrayMappingConfigurationInterface;
use KairosProject\ApiConfig\Definition\Exception\ConfigurationConversionException;
use KairosProject\ApiConfig\Definition\Exception\MalformedArrayException;
use KairosProject\ApiConfig\Definition\Exception\MappingConfigurationFormatException;
use KairosProject\ApiConfig\Factory\OptionsResolverFactoryInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Array configuration trait
 *
 * This trait implement the base methods of the ArrayConfigurationInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ArrayConfigurationTrait
{
    /**
     * Expression language
     *
     * This property store the expression language component, in order to evaluate the configuration mapping
     *
     * @var ExpressionLanguage
     */
    private $expressionLanguage = null;

    /**
     * OptionsResolver factory
     *
     * This property store an instance of OptionsResolverFactoryInterface to build at runtime a fresh OptionsResolver
     * instance.
     *
     * @var OptionsResolverFactoryInterface
     */
    private $optionsResolverFactory = null;

    /**
     * To array
     *
     * Dump the current configuration to an array representation. Will throw a MappingConfigurationFormatException if
     * the mapping configuration is malformed. A ConfigurationConversionException could be thrown in case of expression
     * evaluation error.
     *
     * @return array
     * @see    ArrayConfigurationTrait::getMappingConfiguration()
     * @throws MappingConfigurationFormatException
     * @throws ConfigurationConversionException
     */
    public function toArray(): array
    {
        return $this->evaluateMapping(
            ArrayMappingConfigurationInterface::MAPPING_GET,
            ['config' => $this]
        );
    }

    /**
     * From array
     *
     * Load the configuration from an existing array. Could throw a MalformedArrayException if the given array cannot
     * be parsed to a valid configuration element.
     *
     * @param array $configuration The array to import
     *
     * @return static
     * @throws MalformedArrayException
     * @throws MappingConfigurationFormatException
     * @throws ConfigurationConversionException
     */
    public function fromArray(array $configuration)
    {
        $validator = $this->buildConfigurationArrayValidator();
        try {
            $arrayConfig = $validator->resolve($configuration);
        } catch (InvalidArgumentException $surroundedException) {
            throw new MalformedArrayException(
                $surroundedException->getMessage(),
                0,
                $surroundedException
            );
        }

        $this->evaluateMapping(
            ArrayMappingConfigurationInterface::MAPPING_SET,
            ['config' => $this, 'array' => $arrayConfig]
        );

        return $this;
    }

    /**
     * Evaluate mapping
     *
     * This method execute the concrete conversion. It will evaluate each expression language and return an array
     * representation of the result.
     *
     * @param string $operation The operation type (ArrayMappingConfigurationInterface::MAPPING_INFO_SET or
     *                          ArrayMappingConfigurationInterface::MAPPING_INFO_GET)
     * @param array  $payload   The variable payload of the expression
     *
     * @return array
     * @throws MappingConfigurationFormatException
     * @throws ConfigurationConversionException
     */
    private function evaluateMapping(string $operation, array $payload)
    {
        $mapping = $this->getMapping();
        $tmpResult = [];

        foreach ($mapping as $key => $definition) {
            try {
                $tmpResult[$key] = $this->expressionLanguage->evaluate($definition[$operation], $payload);
            } catch (\Exception $surroundedException) {
                throw new ConfigurationConversionException(
                    sprintf(
                        'Expression cannot be evaluated for key %s. (%s)',
                        $key,
                        $definition[$operation]
                    ),
                    0,
                    $surroundedException
                );
            }
        }

        return $tmpResult;
    }

    /**
     * Build configuration array validator
     *
     * Build and return an OptionsResolver to be used as mapping validator, based on the mapping configuration types
     * key.
     *
     * @return OptionsResolver
     * @throws MappingConfigurationFormatException
     */
    private function buildConfigurationArrayValidator() : OptionsResolver
    {
        $optionsResolver = $this->optionsResolverFactory->getOptionsResolver();

        $mapping = $this->getMapping();
        $optionsResolver->setRequired(array_keys($mapping));

        foreach ($mapping as $key => $definition) {
            if (empty($definition[ArrayMappingConfigurationInterface::MAPPING_TYPES])) {
                continue;
            }

            $optionsResolver->setAllowedTypes($key, $definition[ArrayMappingConfigurationInterface::MAPPING_TYPES]);
        }

        return $optionsResolver;
    }

    /**
     * Get mapping
     *
     * Return the configuration mapping,  ensuring first the mapping format validity.
     *
     * @return array
     * @throws MappingConfigurationFormatException
     */
    private function getMapping()
    {
        $optionsResolver = $this->optionsResolverFactory->getOptionsResolver();
        $optionsResolver->setRequired(
            [
                ArrayMappingConfigurationInterface::MAPPING_GET,
                ArrayMappingConfigurationInterface::MAPPING_SET,
                ArrayMappingConfigurationInterface::MAPPING_TYPES
            ]
        );
        $optionsResolver->addAllowedTypes(ArrayMappingConfigurationInterface::MAPPING_GET, ['string']);
        $optionsResolver->addAllowedTypes(ArrayMappingConfigurationInterface::MAPPING_SET, ['string']);
        $optionsResolver->addAllowedTypes(ArrayMappingConfigurationInterface::MAPPING_TYPES, ['array']);

        $mapping = [];
        foreach ($this->getMappingConfiguration() as $key => $definition) {
            try {
                $mapping[$key] = $optionsResolver->resolve($definition);
            } catch (InvalidArgumentException $surroundedException) {
                throw new MappingConfigurationFormatException(
                    sprintf(
                        '%s %s %s for key "%s"',
                        'Malformed mapping.',
                        'Must be "key" => ["get" => "...string...", "set" => "...string...", "types" => [...]].',
                        'Refer to ArrayConfigurationTrait::getMappingConfiguration.',
                        $key
                    ),
                    0,
                    $surroundedException
                );
            }
        }

        return $mapping;
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
     *              ArrayMappingConfigurationInterface::MAPPING_SET => 'null',
     *              ArrayMappingConfigurationInterface::MAPPING_TYPES => ['bool']
     *          ],
     *          ...
     *      ];
     * </pre>
     */
    abstract protected function getMappingConfiguration() : array;
}

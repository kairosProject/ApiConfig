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

use KairosProject\ApiConfig\Definition\ArrayMappingConfigurationInterface as ConfigInterface;

/**
 * Abstract definition container
 *
 * This class encapsulate the default behavior of the definition container interface in order to be used in concrete
 * classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractDefinitionContainer
    extends AbstractConfigurationDefinition
    implements DefinitionContainerInterface
{
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
        $mapping =  parent::getMappingConfiguration();

        $mapping['children'] = [
            ConfigInterface::MAPPING_GET => 'config.getChildren()',
            ConfigInterface::MAPPING_SET => 'config.setChildren(array["children"])',
            ConfigInterface::MAPPING_TYPES => ['array']
        ];

        return $mapping;
    }

}

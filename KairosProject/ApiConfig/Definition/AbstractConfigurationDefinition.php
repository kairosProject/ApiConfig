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

use KairosProject\ApiConfig\Definition\Traits\DefaultConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\DescribedConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\NameableConfigurationTrait;
use KairosProject\ApiConfig\Definition\Traits\RequireableConfigurationTrait;

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
abstract class AbstractConfigurationDefinition
{
    use DefaultConfigurationTrait,
        DescribedConfigurationTrait,
        NameableConfigurationTrait,
        RequireableConfigurationTrait;
}

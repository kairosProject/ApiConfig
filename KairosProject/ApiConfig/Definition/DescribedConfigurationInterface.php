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
 * Described configuration interface
 *
 * This interface define the base methods available for a configuration with a description.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
interface DescribedConfigurationInterface
{
    /**
     * Set description
     *
     * Set the element description as string value.
     *
     * @param string $description The element description
     *
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Get description
     *
     * Return the description of the element or null if not defined.
     *
     * @return string|null
     */
    public function getDescription() : ?string;
}

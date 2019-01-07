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

/**
 * Described configuration trait
 *
 * This trait implement the base methods of the DescribedConfigurationInterface in order to be used in concrete classes
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait DescribedConfigurationTrait
{
    /**
     * Description
     *
     * This property stor the element description.
     *
     * @var string
     */
    private $description;

    /**
     * Set description
     *
     * Set the element description as string value.
     *
     * @param string $description The element description
     *
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * Return the description of the element or null if not defined.
     *
     * @return string|null
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }
}

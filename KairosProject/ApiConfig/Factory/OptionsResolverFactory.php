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
 * @category Api_Configuration_Factory
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace KairosProject\ApiConfig\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * OptionResolver factory
 *
 * This is used as a default implementation of the OptionsResolverFactoryInterface.
 *
 * @category Api_Configuration_Factory
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class OptionsResolverFactory implements OptionsResolverFactoryInterface
{
    /**
     * Get OptionsResolver
     *
     * Return a fresh instance of OptionsResolver
     *
     * @return OptionsResolver
     */
    public function getOptionsResolver(): OptionsResolver
    {
        return new OptionsResolver();
    }
}

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
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace KairosProject\ApiConfig\Tests\Definition\Traits;

/**
 * Described definition test
 *
 * This class validate the DescribedConfigurationTrait methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait DescribedTestTrait
{
    /**
     * Test description
     *
     * This method validate the initial value of description property in a fresh DescribedConfigurationTrait instance
     *
     * @return void
     */
    public function testInitialDescription()
    {
        $instance = $this->getInstance();

        $this->assertNull($this->getClassProperty('description')->getValue($instance));
    }

    /**
     * Test setDescription
     *
     * This method validate the setDescription method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testSetDescription()
    {
        $this->assertIsSimpleSetter('description', 'setDescription', 'testDescription');
    }

    /**
     * Test getDescription
     *
     * This method validate the getDescription method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testGetDescription()
    {
        $this->assertIsSimpleGetter('description', 'getDescription', 'testDescription');
    }
}

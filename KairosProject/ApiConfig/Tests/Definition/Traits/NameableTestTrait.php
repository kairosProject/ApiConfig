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

use KairosProject\Tests\AbstractTestClass;

/**
 * Configuration definition test
 *
 * This class validate the ConfigurationDefinition methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait NameableTestTrait
{
    /**
     * Test setName
     *
     * This method validate the setName method of the ConfigurationDefinition class.
     *
     * @return void
     */
    public function testSetName()
    {
        $this->assertIsSimpleSetter('name', 'setName', 'nameValue');
    }

    /**
     * Test setName need string
     *
     * This method validate the setName method of the ConfigurationDefinition class, regarding type hint
     *
     * @return  void
     * @depends testSetName
     */
    public function testSetNameNeedString()
    {
        $this->assertEquals('string', $this->getClassMethod('setName', false)->getParameters()[0]->getType());
    }

    /**
     * Test getName
     *
     * This method validate the getName method of the ConfigurationDefinition class.
     *
     * @return void
     */
    public function testGetName()
    {
        $this->assertIsSimpleGetter('name', 'getName', 'nameValue');
    }
}

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
 * Requireable definition test
 *
 * This class validate the RequireableDefinition methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait RequireableTestTrait
{
    /**
     * Test required state is false
     *
     * This method validate the base value of the requiredState property in a ConfigurationDefinition instance
     *
     * @return void
     */
    public function testRequiredStateIsFalse()
    {
        $instance = $this->getInstance();
        $this->assertFalse($this->getClassProperty('requiredState')->getValue($instance));
    }

    /**
     * Test isRequired
     *
     * This method validate the isRequired method of the ConfigurationDefinition class.
     *
     * @return void
     */
    public function testIsRequired()
    {
        $this->assertFalse($this->getInstance()->isRequired());
        $this->assertTrue($this->getInstance(['requiredState' => true])->isRequired());
    }

    /**
     * Test setRequired
     *
     * This method validate the setRequired method of the ConfigurationDefinition class.
     *
     * @return void
     */
    public function testSetRequired()
    {
        $instance = $this->getInstance();
        $this->assertSame($instance, $instance->setRequired());
        $this->assertTrue($this->getClassProperty('requiredState')->getValue($instance));

        $instance->setRequired();
        $this->assertTrue($this->getClassProperty('requiredState')->getValue($instance));
    }

    /**
     * Test setUnRequired
     *
     * This method validate the setUnRequired method of the ConfigurationDefinition class.
     *
     * @return void
     */
    public function testSetUnRequired()
    {
        $instance = $this->getInstance(['requiredState' => true]);
        $this->assertSame($instance, $instance->setUnRequired());
        $this->assertFalse($this->getClassProperty('requiredState')->getValue($instance));

        $instance->setUnRequired();
        $this->assertFalse($this->getClassProperty('requiredState')->getValue($instance));
    }
}

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

use KairosProject\ApiConfig\Definition\Exception\DefaultValueException;
use KairosProject\Tests\AbstractTestClass;

/**
 * Default definition test
 *
 * This class validate the DefaultConfigurationTrait methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait DefaultTestTrait
{
    /**
     * Test initial values
     *
     * This method validate the initial value of properties in a fresh DefaultConfigurationTrait instance
     *
     * @return void
     */
    public function testInitialValues()
    {
        $instance = $this->getInstance();

        $this->assertNull($this->getClassProperty('defaultValue')->getValue($instance));
        $this->assertFalse($this->getClassProperty('hasDefaultValue')->getValue($instance));
    }

    /**
     * Test hasDefaultValue
     *
     * This method validate the hasDefaultValue method of the DescribedConfigurationTrait class.
     *
     * @return void
     */
    public function testHasDefaultValue()
    {
        $this->assertIsSimpleGetter('hasDefaultValue', 'hasDefaultValue', true);
        $this->assertIsSimpleGetter('hasDefaultValue', 'hasDefaultValue', false);
    }

    /**
     * Default value provider
     *
     * This method is used to offer a set of default value to the tests.
     *
     * @return array
     */
    public function defaultValueProvider()
    {
        return [
            [true],
            [false],
            [null],
            ['string'],
            [new \stdClass()],
            [12],
            [24.12],
            [[true, false, null, 'string', new \stdClass(), 12, 24.12]]
        ];
    }

    /**
     * Test hasDefaultValue
     *
     * This method validate the hasDefaultValue method of the DescribedConfigurationTrait class.
     *
     * @param mixed $value The value to be used as default one
     *
     * @return       void
     * @dataProvider defaultValueProvider
     */
    public function testSetDefaultValue($value)
    {
        $instance = $this->getInstance();

        $this->assertPublicMethod('setDefaultValue');
        $this->assertFalse($this->getClassProperty('hasDefaultValue')->getValue($instance));
        $this->assertSame($instance, $instance->setDefaultValue($value));
        $this->assertEquals($value, $this->getClassProperty('defaultValue')->getValue($instance));
        $this->assertTrue($this->getClassProperty('hasDefaultValue')->getValue($instance));
    }

    /**
     * Test removeDefaultValue
     *
     * This method validate the removeDefaultValue method of the DescribedConfigurationTrait class.
     *
     * @param mixed $value The value to be used as default one
     *
     * @return       void
     * @dataProvider defaultValueProvider
     */
    public function testRemoveDefaultValue($value)
    {
        $instance = $this->getInstance(['hasDefaultValue' => true, 'defaultValue' => $value]);

        $this->assertPublicMethod('removeDefaultValue');

        $this->assertSame($instance, $instance->removeDefaultValue($value));
        $this->assertNull($this->getClassProperty('defaultValue')->getValue($instance));
        $this->assertFalse($this->getClassProperty('hasDefaultValue')->getValue($instance));
    }

    /**
     * Test getDefaultValue
     *
     * This method validate the getDefaultValue method of the DescribedConfigurationTrait class.
     *
     * @param mixed $value The value to be used as default one
     *
     * @return       void
     * @dataProvider defaultValueProvider
     */
    public function testGetDefaultValue($value)
    {
        $instance = $this->getInstance(['hasDefaultValue' => true, 'defaultValue' => $value]);

        $this->assertPublicMethod('getDefaultValue');
        $this->assertEquals($value, $instance->getDefaultValue());
    }

    /**
     * Test getDefaultValue exception
     *
     * This method validate the getDefaultValue method of the DescribedConfigurationTrait class in case of undefined
     * default value.
     *
     * @return void
     */
    public function testGetDefaultValueException()
    {
        $this->expectException(DefaultValueException::class);
        $this->expectExceptionMessage(
            sprintf(
                'No default value assigned for the current element. Consider use of %s::hasDefaultValue()',
                $this->getTestedClass()
            )
        );

        $this->getInstance()->getDefaultValue();
    }
}

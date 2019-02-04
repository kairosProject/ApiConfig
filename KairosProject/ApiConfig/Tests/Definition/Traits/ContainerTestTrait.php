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

use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;

/**
 * Container definition test
 *
 * This class validate the DefinitionContainer methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ContainerTestTrait
{
    /**
     * Test addChild
     *
     * This method validate the addChild method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testAddChild()
    {
        $instance = $this->getInstance();
        $child = $this->createMock(ConfigurationDefinitionInterface::class);

        $this->getInvocationBuilder($child, $this->once(), 'getParent')
            ->willReturn(null);

        $this->getInvocationBuilder($child, $this->once(), 'setParent')
            ->with($this->identicalTo($instance));

        $this->assertSame($instance, $instance->addChild($child));
    }

    /**
     * Test detachChild
     *
     * This method validate the detachChild method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testDetachChild()
    {
        $child = $this->createMock(ConfigurationDefinitionInterface::class);
        $instance = $this->getInstance(['children' => [spl_object_id($child) => $child]]);

        $this->getInvocationBuilder($child, $this->once(), 'getParent')
            ->willReturn($instance);
        $this->getInvocationBuilder($child, $this->once(), 'setParent')
            ->with($this->isNull());

        $this->assertSame($instance, $instance->detachChild($child));
        $this->assertEmpty(
            $this->getClassProperty('children')->getValue($instance)
        );
    }

    /**
     * Test hasChild
     *
     * This method validate the hasChild method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testHasChild() : void
    {
        $child = $this->createMock(ConfigurationDefinitionInterface::class);
        $instance = $this->getInstance(['children' => [spl_object_id($child) => $child]]);

        $this->assertTrue($instance->hasChild($child));
        $this->assertFalse($instance->hasChild($this->createMock(ConfigurationDefinitionInterface::class)));
    }

    /**
     * Test clearChildren
     *
     * This method validate the clearChildren method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testClearChildren() : void
    {
        $child = $this->createMock(ConfigurationDefinitionInterface::class);

        $instance = $this->getInstance(['children' => [spl_object_id($child) => $child]]);
        $this->getInvocationBuilder($child, $this->once(), 'getParent')
            ->willReturn($instance);
        $this->getInvocationBuilder($child, $this->once(), 'setParent')
            ->with($this->isNull());

        $this->assertSame($instance, $instance->clearChildren());
    }

    /**
     * Test setChildren
     *
     * This method validate the setChildren method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testSetChildren() : void
    {
        $alreadyChild = $this->createMock(ConfigurationDefinitionInterface::class);
        $newChild = $this->createMock(ConfigurationDefinitionInterface::class);

        $instance = $this->getInstance(['children' => [spl_object_id($alreadyChild) => $alreadyChild]]);

        $this->getInvocationBuilder($alreadyChild, $this->exactly(2), 'getParent')
            ->willReturnOnConsecutiveCalls($instance, null);
        $this->getInvocationBuilder($alreadyChild, $this->exactly(2), 'setParent')
            ->withConsecutive($this->isNull(), $this->identicalTo($instance));

        $this->getInvocationBuilder($newChild, $this->once(), 'getParent')
            ->willReturn(null);
        $this->getInvocationBuilder($newChild, $this->once(), 'setParent')
            ->with($this->identicalTo($instance));

        $this->assertSame($instance, $instance->setChildren([$alreadyChild, $newChild]));

        $this->assertSame(
            [
                spl_object_id($alreadyChild) => $alreadyChild,
                spl_object_id($newChild) => $newChild
            ],
            $this->getClassProperty('children')
                ->getValue($instance)
        );
    }

    /**
     * Test getChildren
     *
     * This method validate the getChildren method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testGetChildren() : void
    {
        $this->assertIsSimpleGetter(
            'same:children',
            'getChildren',
            [$this->createMock(ConfigurationDefinitionInterface::class)]
        );
    }

    /**
     *Test removeParent
     *
     * This method validate the removeParent method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testRemoveParent() : void
    {
        $instance = $this->getInstance();
        $method = $this->getClassMethod('removeParent');

        $newChild = $this->createMock(ConfigurationDefinitionInterface::class);
        $this->getInvocationBuilder($newChild, $this->once(), 'getParent')
            ->willReturn(null);
        $this->getInvocationBuilder($newChild, $this->never(), 'setParent');

        $this->assertNull($method->invoke($instance, $newChild));

        $alreadyChild = $this->createMock(ConfigurationDefinitionInterface::class);
        $this->getInvocationBuilder($alreadyChild, $this->once(), 'getParent')
            ->willReturn($instance);
        $this->getInvocationBuilder($alreadyChild, $this->once(), 'setParent')
            ->with($this->isNull());

        $this->assertNull($method->invoke($instance, $alreadyChild));
    }

    /**
     * Test updateParent
     *
     * This method validate the updateParent method of the ConfigurationContainer class,
     *
     * @return void
     */
    public function testUpdateParent() : void
    {
        $instance = $this->getInstance();
        $method = $this->getClassMethod('updateParent');

        $newChild = $this->createMock(ConfigurationDefinitionInterface::class);
        $this->getInvocationBuilder($newChild, $this->once(), 'getParent')
            ->willReturn(null);
        $this->getInvocationBuilder($newChild, $this->once(), 'setParent')
            ->with($this->identicalTo($instance));

        $this->assertNull($method->invoke($instance, $newChild));

        $alreadyChild = $this->createMock(ConfigurationDefinitionInterface::class);
        $this->getInvocationBuilder($alreadyChild, $this->once(), 'getParent')
            ->willReturn($instance);
        $this->getInvocationBuilder($alreadyChild, $this->never(), 'setParent');

        $this->assertNull($method->invoke($instance, $alreadyChild));
    }
}

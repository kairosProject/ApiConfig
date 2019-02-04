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

use KairosProject\ApiConfig\Definition\AbstractConfigurationDefinition;
use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Nested definition test
 *
 * This class validate the DefinitionContainer methods across NestedConfiguration trait.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait NestedTestTrait
{
    /**
     * Test setParent on orphan
     *
     * This method validate the setParent method of the DefinitionContainer class on an orphan definition
     *
     * @return               void
     * @runInSeparateProcess
     */
    public function testSetParentOnOrphan() : void
    {
        $instance = \Mockery::mock(AbstractConfigurationDefinition::class);
        $instance->shouldAllowMockingProtectedMethods();
        $instance->shouldReceive('detachSelf')->once();
        $instance->shouldReceive('attachSelf')->once();
        $instance->makePartial();

        $parent = $this->createMock(DefinitionContainerInterface::class);

        $this->assertSame($instance, $instance->setParent($parent));

        \Mockery::close();
    }
    /**
     * Provide parents
     *
     * Return a set of available parents to validate the getParent method of the NestedConfiguration support.
     *
     * @return array
     */
    public function provideParents() : array
    {
        return [
            [null],
            [$this->createMock(DefinitionContainerInterface::class)]
        ];
    }

    /**
     * Test getParent
     *
     * This method validate the getParent method of the DefinitionContainer class
     *
     * @param DefinitionContainerInterface|null $parent The parent to inject
     *
     * @return       void
     * @dataProvider provideParents
     */
    public function testGetParent(?DefinitionContainerInterface $parent) : void
    {
        $this->assertIsSimpleGetter('parent', 'getParent', $parent);
    }

    /**
     * Provide setParent data
     *
     * Provide a set of parent elements to validate the setParent method of the NestedConfiguration support.
     * Will return for each tests a set of 4 values. The first and third ones will be respectively the previous and the
     * newest parents. The second and fourth will be the parent initializers executed during the test.
     *
     * @return array
     */
    public function provideSetParentData() : array
    {
        return [
            [
                null,
                function () {
                },
                null,
                function () {
                }
            ],
            [
                null,
                function () {
                },
                $this->createMock(DefinitionContainerInterface::class),
                function (MockObject $parent, ConfigurationDefinitionInterface $instance) {
                    $this->getInvocationBuilder($parent, $this->once(), 'addChild')
                        ->with($this->identicalTo($instance));
                }
            ],
            [
                $this->createMock(DefinitionContainerInterface::class),
                function (MockObject $parent, ConfigurationDefinitionInterface $instance) {
                    $this->getInvocationBuilder($parent, $this->once(), 'detachChild')
                        ->with($this->identicalTo($instance));
                },
                $this->createMock(DefinitionContainerInterface::class),
                function (MockObject $parent, ConfigurationDefinitionInterface $instance) {
                    $this->getInvocationBuilder($parent, $this->once(), 'hasChild')
                        ->with($this->identicalTo($instance))
                        ->willReturn(false);
                    $this->getInvocationBuilder($parent, $this->once(), 'addChild')
                        ->with($this->identicalTo($instance));
                }
            ],
            [
                $this->createMock(DefinitionContainerInterface::class),
                function (MockObject $parent, ConfigurationDefinitionInterface $instance) {
                    $this->getInvocationBuilder($parent, $this->once(), 'detachChild')
                        ->with($this->identicalTo($instance));
                },
                null,
                function () {
                }
            ]
        ];
    }

    /**
     * Test setParent
     *
     * This method validate the setParent method of the DefinitionContainer class
     *
     * @param ConfigurationDefinitionInterface|null $initial             The initial parent
     * @param callable                              $initialConfigurator The initial parent configurator
     * @param ConfigurationDefinitionInterface|null $new                 The new parent
     * @param callable                              $newConfigurator     The new parent configurator
     *
     * @return       void
     * @dataProvider provideSetParentData
     */
    public function testSetParent(
        ?ConfigurationDefinitionInterface $initial,
        callable $initialConfigurator,
        ?ConfigurationDefinitionInterface $new,
        callable $newConfigurator
    ) : void {
        $instance = $this->getInstance(['parent' => $initial]);
        $initialConfigurator($initial, $instance);

        $newConfigurator($new, $instance);
        $this->assertSame($instance, $instance->setParent($new));

        $this->assertEquals($new, $this->getClassProperty('parent')->getValue($instance));
        if (is_object($new)) {
            $this->assertSame($new, $this->getClassProperty('parent')->getValue($instance));
        }
    }

    /**
     * Test detachSelf
     *
     * This method validate the detachSelf method of the DefinitionContainer class.
     *
     * @return void
     */
    public function testDetachSelf() : void
    {
        $parent = $this->createMock(DefinitionContainerInterface::class);
        $instance = $this->getInstance(['parent' => $parent]);

        $this->getInvocationBuilder($parent, $this->once(), 'detachChild')
            ->with($this->identicalTo($instance));

        $method = $this->getClassMethod('detachSelf');
        $this->assertNull($method->invoke($instance));
    }

    /**
     * Test attachSelf
     *
     * This method validate the attachSelf method of the DefinitionContainer class.
     *
     * @return void
     */
    public function testAttachSelf() : void
    {
        $parent = $this->createMock(DefinitionContainerInterface::class);
        $instance = $this->getInstance(['parent' => $parent]);

        $this->getInvocationBuilder($parent, $this->once(), 'hasChild')
            ->with($this->identicalTo($instance))
            ->willReturn(false);
        $this->getInvocationBuilder($parent, $this->once(), 'addChild')
            ->with($this->identicalTo($instance));

        $method = $this->getClassMethod('attachSelf');
        $this->assertNull($method->invoke($instance));
    }

    /**
     * Test attachSelf on done
     *
     * This method validate the attachSelf method of the DefinitionContainer class when already a child of the
     * registered parent
     *
     * @return void
     */
    public function testAttachSelfOnDone() : void
    {
        $parent = $this->createMock(DefinitionContainerInterface::class);
        $instance = $this->getInstance(['parent' => $parent]);

        $this->getInvocationBuilder($parent, $this->once(), 'hasChild')
            ->with($this->identicalTo($instance))
            ->willReturn(true);
        $this->getInvocationBuilder($parent, $this->never(), 'addChild');

        $method = $this->getClassMethod('attachSelf');
        $this->assertNull($method->invoke($instance));
    }
}

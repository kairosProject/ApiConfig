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
 * Priority definition test
 *
 * This class validate the PriorityDefinition methods.
 *
 * @category Api_Configuration_Test
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait PriorityTestTrait
{
    /**
     * Provide priority
     *
     * Return a set of priority to test the PriorityDefinition behaviour
     *
     * @return array
     */
    public function providePriority()
    {
        return [
            [-10],
            [0],
            [10]
        ];
    }

    /**
     * Test setPriority
     *
     * This method validate the setPriority method of the PriorityDefinition class
     *
     * @param int $priority the priority to inject
     *
     * @return       void
     * @dataProvider providePriority
     */
    public function testSetPriority(int $priority)
    {
        $this->assertIsSimpleSetter('priority', 'setPriority', $priority);
    }

    /**
     * Test getPriority
     *
     * This method validate the getPriority method of the PriorityDefinition class
     *
     * @param int $priority the priority to inject
     *
     * @return       void
     * @dataProvider providePriority
     */
    public function testGetPriority(int $priority)
    {
        $this->assertIsSimpleGetter('priority', 'getPriority', $priority);
    }
}

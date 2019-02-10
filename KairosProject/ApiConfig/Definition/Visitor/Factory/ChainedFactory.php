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
namespace KairosProject\ApiConfig\Definition\Visitor\Factory;

use KairosProject\ApiConfig\Definition\ConfigurationDefinitionInterface;
use KairosProject\ApiConfig\Definition\DefinitionContainerInterface;
use KairosProject\ApiConfig\Definition\Visitor\Exception\UnsupportedRepresentationException;
use Traversable;

/**
 * Chained factory
 *
 * This class is used to store a set of factory and to iterate them in order to build a configuration definition
 * instance.
 *
 * @category Api_Configuration_Definition
 * @package  Kairos_Project
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ChainedFactory implements DefinitionFactoryInterface, \IteratorAggregate
{
    /**
     * Factory chain
     *
     * Store the chain of definition factory
     *
     * @var \SplDoublyLinkedList
     */
    private $factoryChain;

    /**
     * ChainedFactory constructor.
     *
     * Store an optional list of definition factory to iterate them during instance construction
     *
     * @param DefinitionFactoryInterface[] $factoryChain The list of factories
     *
     * @return void
     */
    public function __construct(array $factoryChain = [])
    {
        $this->factoryChain = new \SplDoublyLinkedList();

        foreach ($factoryChain as $factory) {
            $this->addFactory($factory);
        }
    }

    /**
     * Add factory
     *
     * Push a new factory at the end of the internal storage
     *
     * @param DefinitionFactoryInterface $factory The factory to push
     *
     * @return $this
     */
    public function addFactory(DefinitionFactoryInterface $factory) : DefinitionFactoryInterface
    {
        $this->factoryChain->push($factory);
        return $this;
    }

    /**
     * Retrieve an external iterator
     *
     * @link   https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since  5.0.0
     */
    public function getIterator()
    {
        return $this->factoryChain;
    }

    /**
     * Get new instance
     *
     * Return a new fresh configuration definition instance with pre-initialisation but without configuration.
     *
     * @param array $representation The definition representation
     *
     * @return ConfigurationDefinitionInterface|DefinitionContainerInterface
     */
    public function getNewInstance(array $representation): ConfigurationDefinitionInterface
    {
        /**
         * Factory
         *
         * The iteration result of the current instance
         *
         * @var DefinitionFactoryInterface $factory
         */
        foreach ($this as $factory) {
            if ($factory->supportRepresentation($representation)) {
                return $factory->getNewInstance($representation);
            }
        }

        throw new UnsupportedRepresentationException('No factory supporting the given representation');
    }

    /**
     * Support representation
     *
     * Indicate whether the current factory can instantiate a fresh instance based on the given representation.
     *
     * @param array $representation The definition representation
     *
     * @return bool
     */
    public function supportRepresentation(array $representation): bool
    {
        /**
         * Factory
         *
         * The iteration result of the current instance
         *
         * @var DefinitionFactoryInterface $factory
         */
        foreach ($this as $factory) {
            if ($factory->supportRepresentation($representation)) {
                return true;
            }
        }

        return false;
    }
}

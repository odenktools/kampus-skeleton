<?php

/*
 * This file is part of Laravel Throttle.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use App\Factories\FactoryInterface;
use App\Transformers\TransformerFactory;

/**
 * This is the throttle class.
 *
 * @method bool attempt(array|\Illuminate\Http\Request $data, int $limit, int $time)
 * @method \App\Throttlers\ThrottlerInterface hit(array|\Illuminate\Http\Request $data, int $limit, int $time)
 * @method \App\Throttlers\ThrottlerInterface clear(array|\Illuminate\Http\Request $data, int $limit, int $time)
 * @method int count(array|\Illuminate\Http\Request $data, int $limit, int $time)
 * @method bool check(array|\Illuminate\Http\Request $data, int $limit, int $time)
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Throttle
{
    /**
     * The cached throttler instances.
     *
     * @var \App\Throttlers\ThrottlerInterface[]
     */
    protected $throttlers = [];

    /**
     * The factory instance.
     *
     * @var \App\Factories\FactoryInterface
     */
    protected $factory;

    /**
     * The factory instance.
     *
     * @var \App\Transformers\TransformerFactory
     */
    protected $transformer;

    /**
     * Create a new instance.
     *
     * @param \App\Factories\FactoryInterface      $factory
     * @param \App\Transformers\TransformerFactory $transformer
     *
     * @return void
     */
    public function __construct(FactoryInterface $factory, TransformerFactory $transformer)
    {
        $this->factory = $factory;
        $this->transformer = $transformer;
    }

    /**
     * Get a new throttler.
     *
     * @param array|\Illuminate\Http\Request $data
     * @param int                            $limit
     * @param int                            $time
     *
     * @return \App\Throttlers\ThrottlerInterface
     */
    public function get($data, $limit = 10, $time = 60)
    {
        $transformed = $this->transformer->make($data)->transform($data, $limit, $time);

        if (!array_key_exists($key = $transformed->getKey(), $this->throttlers)) {
            $this->throttlers[$key] = $this->factory->make($transformed);
        }

        return $this->throttlers[$key];
    }

    /**
     * Get the cache instance.
     *
     * @return \App\Factories\FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Get the transformer instance.
     *
     * @codeCoverageIgnore
     *
     * @return \App\Transformers\TransformerFactory
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Dynamically pass methods to a new throttler instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, 'get'], $parameters)->$method();
    }
}

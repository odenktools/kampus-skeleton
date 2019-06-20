<?php

/*
 * This file is part of Laravel Throttle.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Transformers;

use App\Throttlers\Data;

/**
 * This is the request transformer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RequestTransformer implements TransformerInterface
{
    /**
     * Transform the data into a new data instance.
     *
     * @param \Illuminate\Http\Request $data
     * @param int                      $limit
     * @param int                      $time
     *
     * @return \App\Throttlers\Data
     */
    public function transform($data, $limit = 10, $time = 60)
    {
        return new Data((string) $data->getClientIp(), (string) $data->path(), (int) $limit, (int) $time);
    }
}

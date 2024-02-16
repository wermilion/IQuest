<?php

namespace App\Domain\Cities\Data;

use Illuminate\Support\Fluent;

/**
 * @property string $name - Имя
 * @property int $request_id - Идентификатор
 */
class SendVkDataRequest extends Fluent
{
    public function __construct($attributes = [])
    {
        $attributes['request_id'] = $attributes['request_id'] . '5';

        parent::__construct($attributes);
    }
}

<?php

declare(strict_types=1);

namespace App\Events\Base;

use App\Events\BaseEvent;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class BaseCreatedEvent.
 *
 * @template TModel of \App\Models\BaseModel
 * @extends BaseEvent<TModel>
 */
abstract class BaseCreatedEvent extends BaseEvent
{
    use Dispatchable;
}

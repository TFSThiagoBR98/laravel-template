<?php

declare(strict_types=1);

namespace App\Events\Base;

use App\Events\BaseEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class BaseDeletingEvent.
 *
 * @template TModel of \App\Models\BaseModel
 * @extends BaseEvent<TModel>
 */
abstract class BaseDeletingEvent extends BaseEvent
{
    use Dispatchable;
    use SerializesModels;
}

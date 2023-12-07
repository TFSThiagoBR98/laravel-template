<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Config;

/**
 * Class BasePivotEvent.
 *
 * @template TModelRelated of \App\Models\BaseModel
 * @template TModelForeign of \App\Models\BaseModel
 */
abstract class BasePivotEvent
{
    /**
     * Create a new event instance.
     *
     * @param  TModelRelated|BaseModel  $related
     * @param  TModelForeign|BaseModel  $foreign
     */
    public function __construct(protected BaseModel $related, protected BaseModel $foreign)
    {
    }

    /**
     * Get the related model.
     *
     * @return TModelRelated|BaseModel
     */
    public function getRelated(): BaseModel
    {
        return $this->related;
    }

    /**
     * Get the foreign model.
     *
     * @return TModelForeign|BaseModel
     */
    public function getForeign(): BaseModel
    {
        return $this->foreign;
    }
}

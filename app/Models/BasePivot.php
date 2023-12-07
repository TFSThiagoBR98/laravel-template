<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Base model for this project
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
abstract class BasePivot extends Pivot
{
    use SoftDeletes;

    public const ATTRIBUTE_CREATED_AT = Pivot::CREATED_AT;
    public const ATTRIBUTE_UPDATED_AT = Pivot::UPDATED_AT;
    public const ATTRIBUTE_DELETED_AT = 'deleted_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}

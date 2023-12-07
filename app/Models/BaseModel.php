<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Auditable as HasAuditable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Base model for this project
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
abstract class BaseModel extends Model implements Auditable
{
    use HasFactory;
    use HasAuditable;
    use SoftDeletes;
    use Searchable;
    use HasSchemalessAttributes;

    public const ATTRIBUTE_CREATED_AT = Model::CREATED_AT;
    public const ATTRIBUTE_UPDATED_AT = Model::UPDATED_AT;
    public const ATTRIBUTE_DELETED_AT = 'deleted_at';
    public const ATTRIBUTE_EXTRA_ATTRIBUTES = 'extra_attributes';

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return $this->toArray();
    }

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return $this->incrementing;
    }
}

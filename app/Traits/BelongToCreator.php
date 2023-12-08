<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track User Creator of the Model
 *
 * @property string $creator_id
 * @property User $creator
 *
 * @inheritDoc /App/Models/BaseModelMedia
 * @inherits /App/Models/BaseModelMedia
 */
trait BelongToCreator
{
    final public const ATTRIBUTE_FK_CREATOR = 'creator_id';

    /**
     * Get creator of model
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ATTRIBUTE_FK_CREATOR);
    }
}

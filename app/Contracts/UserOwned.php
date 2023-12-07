<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a User Owned Model
 *
 * @property string $user_id
 * @property User $company
 */
interface UserOwned
{
    /**
     * Get user of model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo;
}

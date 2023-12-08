<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongToUser
{
    /**
     * Get user of model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, User::FOREIGN_KEY);
    }
}

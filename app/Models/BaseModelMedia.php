<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * BaseModelMedia
 * BaseModel with Media assets
 */
abstract class BaseModelMedia extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
}

<?php

namespace App\Http\ApiV1\AdminApi\Filament\Components;

use Closure;
use Filament\Forms\Components\FileUpload;

class BaseFileUpload extends FileUpload
{
    protected int|Closure|null $maxSize = 1024;

    protected bool|Closure $shouldOrientImagesFromExif = false;
}

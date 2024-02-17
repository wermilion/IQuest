<?php

namespace App\Filament\File;

use Livewire\FileUploadConfiguration;

class FileUploadHandler extends \Livewire\Controllers\FileUploadHandler
{
    public function handle()
    {
        $disk = FileUploadConfiguration::disk();

        $filePaths = $this->validateAndStore(request('files'), $disk);

        return ['paths' => $filePaths];
    }
}

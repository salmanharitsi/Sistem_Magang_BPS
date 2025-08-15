<?php

return [
    'temporary_file_upload' => [
        'disk' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK', 'local'),
        'directory' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DIRECTORY', 'livewire-tmp'),
        'rules' => ['required', 'file', 'max:10240'], // 10MB
        'preview_mimes' => [
            // Tambahkan PDF dan tipe lainnya
            'pdf',
            'png', 'jpg', 'jpeg', 'gif',
            'bmp', 'svg', 'webp',
            'mp4', 'mov', 'avi',
            'mp3', 'm4a', 'wav'
        ],
        'middleware' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_MIDDLEWARE', 'throttle:60,1'),
    ],
    'manifest_path' => null,
];
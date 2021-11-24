<?php

return [
    'disks' => [
        'public_uploads' => [
            'driver' => 'local',
            'root' => public_path() . '/uploads',
        ]
    ]
];

<?php

declare(strict_types=1);

return [
    'pheature_flags' => [
        'driver' => 'chain',
        'driver_options' => ['dbal', 'inmemory'],
        'toggles' => [
            [
                'id' => 'some_feature_section',
                'enabled' => true,
            ],
            [
                'id' => 'work_in_progress',
                'enabled' => true,
            ]
        ]
    ],
];

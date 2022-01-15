<?php

declare(strict_types=1);

return [
    'pheature_flags' => [
        'driver' => 'chain',
        'driver_options' => ['inmemory', 'dbal'],
        'toggles' => [
            [
                'id' => 'some_feature_section',
                'enabled' => true,
            ],
            [
                'id' => 'in_progress_feature_section',
                'enabled' => true,
            ]
        ]
    ],
];

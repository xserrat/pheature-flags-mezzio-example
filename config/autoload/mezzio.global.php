<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

return [
    // Toggle the configuration cache. Set this to boolean false, or remove the
    // directive, to disable configuration caching. Toggling development mode
    // will also disable it by default; clear the configuration cache using
    // `composer clear-config-cache`.
    ConfigAggregator::ENABLE_CACHE => true,

    // Enable debugging; typically used to provide debugging information within templates.
    'debug'  => false,
    'mezzio' => [
        // Provide templates for the error handling middleware to use when
        // generating responses.
        'error_handler' => [
            'template_404'   => 'error::404',
            'template_error' => 'error::error',
        ],
    ],
    'doctrine' => [
        'url' => $_ENV['DSN_MYSQL'],
    ],
    'doctrine_migrations' => [
        'table_storage' => [
            'table_name' => 'doctrine_migration_versions',
            'version_column_name' => 'version',
            'version_column_length' => 1024,
            'executed_at_column_name' => 'executed_at',
            'execution_time_column_name' => 'execution_time',
        ],

        'migrations_paths' => [
            'MyProject\Migrations' => 'data/migrations',
        ],

        'all_or_nothing' => true,
        'check_database_platform' => true,
        'organize_migrations' => 'year_and_month',
    ],
    'templates' => [
//        'extension' => 'file extension used by templates; defaults to html.twig',
        'paths' => [
            // namespace / path pairs
            //
            // Numeric namespaces imply the default/main namespace. Paths may be
            // strings or arrays of string paths to associate with the namespace.
        ],
    ],
    'twig' => [
        'autoescape' => 'html', // Auto-escaping strategy [html|js|css|url|false]
        'cache_dir' => 'data/cache/templates',
//        'assets_url' => 'base URL for assets',
//        'assets_version' => 'base version for assets',
        'extensions' => [
            // extension service names or instances
        ],
        'globals' => [
            // Global variables passed to twig templates
            //'ga_tracking' => 'UA-XXXXX-X'
        ],
        'optimizations' => -1, // -1: Enable all (default), 0: disable optimizations
        'runtime_loaders' => [
            // runtime loader names or instances
        ],
        'auto_reload' => true, // Recompile the template whenever the source code changes
    ],
];

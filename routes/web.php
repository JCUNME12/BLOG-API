<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $routes = [
        [
            'method' => 'GET',
            'uri' => '/api/v1/health',
            'description' => 'Verifica se o serviço está respondendo.',
            'visibility' => 'Pública',
        ],
        [
            'method' => 'GET',
            'uri' => '/api/v1/health-check-db',
            'description' => 'Verifica a conexão com o banco de dados.',
            'visibility' => 'Pública',
        ],
        [
            'method' => 'GET',
            'uri' => '/api/v1/public/posts',
            'description' => 'Lista posts com paginação, busca e filtros.',
            'visibility' => 'Pública',
        ],
        [
            'method' => 'GET',
            'uri' => '/api/v1/public/posts/{slug}',
            'description' => 'Exibe um post pelo slug.',
            'visibility' => 'Pública',
        ],
        [
            'method' => 'GET',
            'uri' => '/api/v1/public/categories',
            'description' => 'Lista categorias com contagem de posts.',
            'visibility' => 'Pública',
        ],
        [
            'method' => 'GET',
            'uri' => '/api/v1/public/categories/{slug}',
            'description' => 'Exibe uma categoria pelo slug.',
            'visibility' => 'Pública',
        ],
        [
            'method' => 'API RESOURCE',
            'uri' => '/api/v1/admin/posts',
            'description' => 'CRUD administrativo de posts. Grupo preparado para JWT.',
            'visibility' => 'Protegida em breve',
        ],
        [
            'method' => 'API RESOURCE',
            'uri' => '/api/v1/admin/categories',
            'description' => 'CRUD administrativo de categorias. Grupo preparado para JWT.',
            'visibility' => 'Protegida em breve',
        ],
    ];

    return view('api-dashboard', [
        'serviceName' => config('app.name', 'Blog API'),
        'routes' => $routes,
    ]);
});

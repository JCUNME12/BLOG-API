<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    /**
     * Health check endpoint.
     *
     * @group Health
     */
    Route::get('/health', function () {
        return response()->json([
            'service' => config('app.name', 'blog-api'),
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
        ]);
    })->name('api.v1.health');

    /**
     * Database health check endpoint.
     *
     * @group Health
     */
    Route::get('/health-check-db', function () {
        try {
            DB::select('select 1');

            return response()->json([
                'service' => config('app.name', 'blog-api'),
                'database' => 'connected',
                'timestamp' => now()->toISOString(),
            ]);
        } catch (Throwable $throwable) {
            report($throwable);

            return response()->json([
                'service' => config('app.name', 'blog-api'),
                'database' => 'disconnected',
                'message' => 'Não foi possível conectar ao banco de dados.',
                'timestamp' => now()->toISOString(),
            ], 500);
        }
    })->name('api.v1.health.db');

    Route::prefix('public')->name('api.v1.public.')->group(function (): void {
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
    });

    /**
     * Protected routes placeholder.
     *
     * These routes are intentionally grouped to make future JWT integration straightforward:
     * Route::middleware(['auth:api'])->group(...)
     */
    Route::prefix('admin')
        ->name('api.v1.admin.')
        // ->middleware('auth:api')
        ->group(function (): void {
            Route::apiResource('posts', PostController::class)->parameters([
                'posts' => 'post',
            ]);

            Route::apiResource('categories', CategoryController::class)->parameters([
                'categories' => 'category',
            ]);
        });
});

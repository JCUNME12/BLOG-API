<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostController extends Controller
{
    /**
     * List posts.
     *
     * @group Posts
     *
     * @queryParam search string Filter posts by title. Example: Laravel
     * @queryParam category_id integer Filter posts by category ID. Example: 1
     * @queryParam category_slug string Filter posts by category slug. Example: tecnologia
     * @queryParam is_featured boolean Filter featured posts. Example: true
     * @queryParam status string Filter by status: draft or published. Example: published
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 15
     */
    public function index(Request $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $posts = Post::query()
                ->with('category')
                ->when($request->filled('search'), function ($query) use ($request): void {
                    $query->where('title', 'like', '%' . $request->string('search') . '%');
                })
                ->when($request->filled('category_id'), function ($query) use ($request): void {
                    $query->where('category_id', $request->integer('category_id'));
                })
                ->when($request->filled('category_slug'), function ($query) use ($request): void {
                    $query->whereHas('category', function ($categoryQuery) use ($request): void {
                        $categoryQuery->where('slug', $request->string('category_slug'));
                    });
                })
                ->when($request->has('is_featured'), function ($query) use ($request): void {
                    $query->where('is_featured', $request->boolean('is_featured'));
                })
                ->when($request->filled('status'), function ($query) use ($request): void {
                    $query->where('status', $request->string('status'));
                })
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->paginate((int) $request->integer('per_page', 15));

            return PostResource::collection($posts);
        } catch (Throwable $throwable) {
            Log::error('Failed to list posts.', ['exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível listar os posts.',
            ], 500);
        }
    }

    /**
     * Create post.
     *
     * @group Posts
     *
     * @bodyParam title string required Post title. Example: Laravel 12 em Microsserviços
     * @bodyParam slug string Optional custom slug. Example: laravel-12-em-microsservicos
     * @bodyParam content string required Full post content. Example: Conteúdo completo da notícia.
     * @bodyParam excerpt string Short post excerpt. Example: Resumo da notícia.
     * @bodyParam category_id integer required Category ID. Example: 1
     * @bodyParam featured_image string URL of featured image. Example: https://cdn.example.com/image.jpg
     * @bodyParam is_featured boolean Whether the post is featured. Example: true
     * @bodyParam status string required draft or published. Example: published
     * @bodyParam published_at datetime Publication date. Example: 2026-05-28 10:00:00
     */
    public function store(PostRequest $request): PostResource|JsonResponse
    {
        try {
            $data = $request->validated();
            $post = Post::query()->create($data);
            $post->load('category');

            return (new PostResource($post))
                ->additional(['message' => 'Post criado com sucesso.'])
                ->response()
                ->setStatusCode(201);
        } catch (Throwable $throwable) {
            Log::error('Failed to create post.', ['exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível criar o post.',
            ], 500);
        }
    }

    /**
     * Show post.
     *
     * @group Posts
     */
    public function show(Post $post): PostResource
    {
        $post->load('category');

        return new PostResource($post);
    }

    /**
     * Update post.
     *
     * @group Posts
     *
     * @bodyParam title string required Post title. Example: Laravel 12 em Microsserviços
     * @bodyParam slug string Optional custom slug. Example: laravel-12-em-microsservicos
     * @bodyParam content string required Full post content. Example: Conteúdo completo da notícia.
     * @bodyParam excerpt string Short post excerpt. Example: Resumo da notícia.
     * @bodyParam category_id integer required Category ID. Example: 1
     * @bodyParam featured_image string URL of featured image. Example: https://cdn.example.com/image.jpg
     * @bodyParam is_featured boolean Whether the post is featured. Example: true
     * @bodyParam status string required draft or published. Example: published
     * @bodyParam published_at datetime Publication date. Example: 2026-05-28 10:00:00
     */
    public function update(PostRequest $request, Post $post): PostResource|JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->filled('title') && ! $request->filled('slug')) {
                $data['slug'] = Post::generateUniqueSlug($data['title'], $post->id);
            }

            $post->update($data);
            $post->refresh()->load('category');

            return (new PostResource($post))
                ->additional(['message' => 'Post atualizado com sucesso.']);
        } catch (Throwable $throwable) {
            Log::error('Failed to update post.', ['post_id' => $post->id, 'exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível atualizar o post.',
            ], 500);
        }
    }

    /**
     * Delete post.
     *
     * @group Posts
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            $post->delete();

            return response()->json([
                'message' => 'Post removido com sucesso.',
            ]);
        } catch (Throwable $throwable) {
            Log::error('Failed to delete post.', ['post_id' => $post->id, 'exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível remover o post.',
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryController extends Controller
{
    /**
     * List categories.
     *
     * @group Categories
     *
     * @queryParam search string Filter categories by name. Example: tecnologia
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 15
     */
    public function index(Request $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $categories = Category::query()
                ->withCount('posts')
                ->when($request->filled('search'), function ($query) use ($request): void {
                    $query->where('name', 'like', '%' . $request->string('search') . '%');
                })
                ->orderBy('name')
                ->paginate((int) $request->integer('per_page', 15));

            return CategoryResource::collection($categories);
        } catch (Throwable $throwable) {
            Log::error('Failed to list categories.', ['exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível listar as categorias.',
            ], 500);
        }
    }

    /**
     * Create category.
     *
     * @group Categories
     *
     * @bodyParam name string required Category name. Example: Tecnologia
     * @bodyParam slug string Optional custom slug. Example: tecnologia
     * @bodyParam description string Category description. Example: Notícias sobre tecnologia e inovação.
     */
    public function store(CategoryRequest $request): CategoryResource|JsonResponse
    {
        try {
            $data = $request->validated();
            $category = Category::query()->create($data);

            return (new CategoryResource($category))
                ->additional(['message' => 'Categoria criada com sucesso.'])
                ->response()
                ->setStatusCode(201);
        } catch (Throwable $throwable) {
            Log::error('Failed to create category.', ['exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível criar a categoria.',
            ], 500);
        }
    }

    /**
     * Show category.
     *
     * @group Categories
     */
    public function show(Category $category): CategoryResource
    {
        $category->loadCount('posts');

        return new CategoryResource($category);
    }

    /**
     * Update category.
     *
     * @group Categories
     *
     * @bodyParam name string required Category name. Example: Tecnologia
     * @bodyParam slug string Optional custom slug. Example: tecnologia
     * @bodyParam description string Category description. Example: Notícias sobre tecnologia e inovação.
     */
    public function update(CategoryRequest $request, Category $category): CategoryResource|JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->filled('name') && ! $request->filled('slug')) {
                $data['slug'] = Category::generateUniqueSlug($data['name'], $category->id);
            }

            $category->update($data);

            return (new CategoryResource($category->refresh()->loadCount('posts')))
                ->additional(['message' => 'Categoria atualizada com sucesso.']);
        } catch (Throwable $throwable) {
            Log::error('Failed to update category.', ['category_id' => $category->id, 'exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível atualizar a categoria.',
            ], 500);
        }
    }

    /**
     * Delete category.
     *
     * @group Categories
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            if ($category->posts()->exists()) {
                return response()->json([
                    'message' => 'Não é possível remover uma categoria vinculada a posts.',
                ], 409);
            }

            $category->delete();

            return response()->json([
                'message' => 'Categoria removida com sucesso.',
            ]);
        } catch (Throwable $throwable) {
            Log::error('Failed to delete category.', ['category_id' => $category->id, 'exception' => $throwable]);

            return response()->json([
                'message' => 'Não foi possível remover a categoria.',
            ], 500);
        }
    }
}

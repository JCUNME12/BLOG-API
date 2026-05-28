<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $postId = $this->route('post')?->id;
        $requiredOnCreate = $this->isMethod('post') ? 'required' : 'sometimes';

        return [
            'title' => [$requiredOnCreate, 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash:ascii',
                Rule::unique('posts', 'slug')->ignore($postId),
            ],
            'content' => [$requiredOnCreate, 'string'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'category_id' => [$requiredOnCreate, 'integer', 'exists:categories,id'],
            'featured_image' => ['nullable', 'url', 'max:2048'],
            'is_featured' => ['sometimes', 'boolean'],
            'status' => [$requiredOnCreate, Rule::in([Post::STATUS_DRAFT, Post::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $post = $this->route('post');
            $status = $this->input('status', $post?->status);
            $publishedAt = $this->input('published_at', $post?->published_at);

            if ($status === Post::STATUS_PUBLISHED && blank($publishedAt)) {
                $validator->errors()->add(
                    'published_at',
                    'A data de publicação é obrigatória quando o status do post é published.'
                );
            }
        });
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'título',
            'slug' => 'slug',
            'content' => 'conteúdo',
            'excerpt' => 'resumo',
            'category_id' => 'categoria',
            'featured_image' => 'imagem destacada',
            'is_featured' => 'post em destaque',
            'status' => 'status',
            'published_at' => 'data de publicação',
        ];
    }
}

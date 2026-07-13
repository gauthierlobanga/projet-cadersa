<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Sanitize HTML content to prevent XSS attacks
        if ($this->has('content')) {
            $this->merge([
                'content' => strip_tags((string) $this->input('content'), $this->allowedHtmlTags()),
            ]);
        }
        if ($this->has('excerpt')) {
            $this->merge([
                'excerpt' => strip_tags((string) $this->input('excerpt')),
            ]);
        }
    }

    /**
     * Balises HTML autorisées dans le contenu.
     */
    private function allowedHtmlTags(): string
    {
        return '<p><br><strong><em><u><h2><h3><h4><ul><ol><li><a><blockquote><pre><code><img><table><thead><tbody><tr><th><td><hr>';
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|string|in:draft,published,scheduled,archived',
            'is_pinned' => 'boolean',
            'categories' => 'array',
            'categories.*' => 'exists:posts_categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
            'scheduled_for' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:published_at',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:5120',
            'gallery' => 'array',
            'gallery.*' => 'image|max:5120',
        ];
    }
}

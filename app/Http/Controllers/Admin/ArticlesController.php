<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['category:id,name'])->latest()->simplePaginate(10);

        return Inertia::render('Articles/Index', [
            'articles' => ArticleResource::collection($articles),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Categories/Create', [
            'edit' => false,
            'category' => (object) []
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Category::class)]
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category saved successfully.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Create', [
            'edit' => true,
            'category' => new CategoryResource($category),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', Rule::unique(Category::class)->ignore($category->id)]
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Article $article)
    {
        // TODO: Implement the delete image part
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}

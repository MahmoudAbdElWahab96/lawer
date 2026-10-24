<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        return view('blog.index', [
            'articles' => Article::published()->paginate(9),
        ]);
    }

    public function show(Request $request)
    {
        $article = Article::query()
            ->where('slug', (string) $request->route('article'))
            ->firstOrFail();

        abort_unless($article->is_published && $article->published_at?->isPast(), 404);

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('blog.show', [
            'article' => $article,
            'related' => $related,
            'seoTitle' => $article->t('title'),
            'seoDescription' => $article->t('excerpt'),
        ]);
    }
}

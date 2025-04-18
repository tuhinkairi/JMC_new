<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ArticleCategory;
use Carbon\Carbon;
use App\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Date
        $this->today = Carbon::today();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        die;
        // Article Categories
        $article_categories = ArticleCategory::where('home_flag', '1')
                                            ->where('status', '1')
                                            ->orderBy('title', 'asc')
                                            ->get();

        // Articles
        $articles = Article::where('status', '1')
                            ->where('review_status', '2')
                            ->where('start_date', '<=', $this->today)
                            ->orderBy('start_date', 'desc')
                            ->orderBy('id', 'desc')
                            ->paginate(5);

        // Grid Articles
        $grid_articles = Article::join('article_categories', 'article_categories.id', 'articles.category_id')
                            ->select('articles.*')
                            ->where('article_categories.home_flag', '1')
                            ->where('article_categories.status', '1')
                            ->where('articles.status', '1')
                            ->where('articles.review_status', '2')
                            ->where('articles.start_date', '<=', $this->today)
                            ->orderBy('articles.start_date', 'desc')
                            ->orderBy('articles.id', 'desc')
                            ->take(12)
                            ->get();


        return view('index', compact('article_categories', 'articles', 'grid_articles'));
    }
}

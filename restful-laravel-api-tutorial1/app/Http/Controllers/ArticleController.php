<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Requests\ArticleReq;

class ArticleController extends Controller {

    public function index() {
        return Article::all();
    }

    public function show(Article $article) {
        return $article;
    }

    public function store(ArticleReq $request) {
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function update(ArticleReq $request, Article $article) {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Article $article) {
        $article->delete();

        return response()->json(null, 204);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Testmd;
use Input;
use App\Http\Requests\ArticleValidationRequest;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Testmd::paginate(4);
        return view('articles.index', compact('articles'));
    }

    public function detail($id)
    {
        $article = Testmd::find($id);
        return view('articles.detail', compact('article'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(ArticleValidationRequest $request)
    {
        $name = Input::get('name');
        $content = Input::get('content');
        Testmd::create([
          'name' => $name,
          'content' => $content
          ]);
        return redirect()->route('article.index');
    }

    public function edit($id)
    {
        $article = Testmd::find($id);
        return view('articles.edit', compact('article'));
    }

    public function update($id, ArticleValidationRequest $request)
    { 
        $article = Testmd::find($id);
        $article->update([
          'name' => $request->get('name'),
          'content' => $request->get('content')
          ]);
        return redirect()->route('article.index');
    }

    public function destroy($id)
    {
        $article = Testmd::find($id);
        $article->delete();
        return redirect()->route('article.index');
    }
}

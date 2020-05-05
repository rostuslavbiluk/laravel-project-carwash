<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticlesController extends Controller
{

    /**
     * @var array
     */
    protected $list = [
        [
            'code' => 'help',
            'name' => 'Как это работает?',
            'preview' => '<p>Перевод с английского, немецкого, французского, испанского, польского, турецкого и других языков на русский и обратно</p>',
            'content' => '<p>Перевод с английского, немецкого, французского, испанского, польского, турецкого и других языков на русский и обратно</p>'
        ], [
            'code' => 'support',
            'name' => 'Техническая поддержка',
            'preview' => '<p>Создать тикет в техническую поддержку</p>',
            'content' => '<p>Создать тикет в техническую поддержку</p><p><div class="pt-btn"><a class="btn btn-success btn-sm" href="/dashboard/support">Создать тикет</a></div></p>'
        ],
    ];

    public function index()
    {
        $articles['title'] = 'Информация';
        $articles['list'] = $this->list;
        return view('template.articles.index', compact('articles'));
    }

    public function show(Request $request)
    {
        $codePage = $request->route('code');
        if (!$codePage) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        $article = array_filter($this->list, function ($item, $k) use ($codePage) {
            return $item['code'] === $codePage;
        }, ARRAY_FILTER_USE_BOTH);
        if (empty($article)) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        if (!empty($article)) {
            $article = array_shift($article);
        }
        return view('template.articles.show', compact('article'));
    }
}

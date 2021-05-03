<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        Log::info(print_r($id, true));
        $articles = Article::select('*')->where('user_id', $id)->get();
        Log::info(print_r($articles, true));
        
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->id) : new Article;
        $article->id = $request->input('id');
        $article->title = $request->input('title'); 
        $article->body = $request->input('body');
        $article->user_id = $request->input('user_id');

        if($article -> save()) {
            return new ArticleResource($article);
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get a single article
        $article = Article::findOrFail($id);
        //Return a single article as a resource
        return new ArticleResource($article);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Get a single article
        $article = Article::findOrFail($id);

        if($article->delete()){
            return new ArticleResource($article);
        }
    }
}

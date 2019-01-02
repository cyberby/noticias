<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Laravie\Parser\Xml\Reader;
use Laravie\Parser\Xml\Document;

class NewsController extends Controller
{
    /**
     * Action que retorna as notícias paginadas
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //atualiza as notícias
        $xml = file_get_contents("http://pox.globo.com/rss/g1/economia");
        $xml=simplexml_load_string($xml);
        $News = new News();
        $News->updateNews($xml->channel->item);

        //retorna as notícias salvas paginadas
        $news = News::orderBy('id', 'ask')->paginate(10);
        return response()->json($news);

    }

    /**
     * Action que retorna a notícia pelo id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if(!empty($id)){
            $News = new News();
            $new = $News->getNew($id);
            return response()->json($new);
        }
    }
}

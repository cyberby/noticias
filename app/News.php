<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{

    protected $table = 'news';

    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    protected $fillable = [
        'title', 'link', 'pubDate', 'guid', 'description', 'category'
    ];

    /**
     * Função para adicionar um array de notícias vindas do xml
     * @param $news
     */
    public function updateNews($news){
        $all_updated = true;
        if(!empty($news)){
            foreach ($news as $new) {
                $new_updated = $this->addNew($new);
                if(empty($new_updated->id)){
                    $all_updated = false;
                }
            }
        }
        return $all_updated;
    }

    /**
     * Função para adicionar uma única notícia
     * @param $new
     * @return News|Model|null|object|void|static
     */
    public function addNew($new){
        //verifica se os atributos obrigatórios estão presentes no objeto passado
        $news_entity = new News();
        if(empty($new->title) || empty($new->link) || empty($new->pubDate)){
            return;
        }

        //consulta se a notícia já existe no banco de dados
        $new_saved = News::where("news.link", $new->link)->first();

        //se a notícia já existir, retorna ela
        if(!empty($new_saved->id)){
            return $new_saved;
        }

        //salva a notícia que ainda não consta da tabela news
        $news_entity->title = $new->title;
        $news_entity->link = $new->link;
        $pubDate = $this->convertPubDateToDateTime($new->pubDate);
        if(empty($pubDate)){
            return;
        }
        $news_entity->pubDate = $pubDate->format("Y-m-d H:i:s");

        if(!empty($new->guid)){$news_entity->guid =  $new->guid;}
        if(!empty($new->description)){$news_entity->description =  $new->description;}
        if(!empty($new->category)){$news_entity->category =  $new->category;}

        if($news_entity->save()){
            return $news_entity;
        }
        return;
    }

    /**
     * Função para converter o atributo pubDate do Xml para Datetime
     * @param $pubDate
     * @return \DateTime|false|void
     */
    public function convertPubDateToDateTime($pubDate){
        $pubDate = str_replace(" -0000", "", $pubDate);
        $datetime_array1 = explode(", ", $pubDate);
        if(empty($datetime_array1[1])){
           return;
        }

        $date = date_create_from_format('d M Y H:i:s', $datetime_array1[1]);
        return $date;
    }

    /**
     * Função para retornar a notícia pelo id
     * @param $id
     * @return Model|null|object|static
     */
    public function getNew($id){
        return News::where("news.id", $id)->first();
    }

}

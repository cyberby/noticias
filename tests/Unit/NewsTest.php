<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\News;
use Illuminate\Support\Facades\DB;
class NewsTest extends TestCase
{
    /** @var $News News */
    private $News;

    public function setUp()
    {
        $this->News = new News();
        parent::setUp();
    }

    /**
     * Teste de atualização de novas notícias
     */
    public function testUpdateNews(){
        $xml = file_get_contents("http://pox.globo.com/rss/g1/economia");
        $xml=simplexml_load_string($xml);
        $this->assertNotEmpty($xml->channel->item, "Erro ao pegar o xml de noticias");
        $all_updated = $this->News->updateNews($xml->channel->item);
        $this->assertNotEmpty($all_updated);
    }

    /**
     * Teste da função addNew, que insere uma nova notícia do banco ou retorna a já existente
     */
    public function testAddNew(){
        $xml = file_get_contents("http://pox.globo.com/rss/g1/economia");
        $xml=simplexml_load_string($xml);
        $this->assertNotEmpty($xml->channel->item, "Erro ao pegar o xml de noticias");
        $res = $this->News->addNew($xml->channel->item[0]);
        $this->assertNotEmpty($res->id, "Erro salvar a notícia");

    }

    /**
     * Teste da função convertPubDateToDateTime
     */
    public function testConvertPubDateToDateTime()
    {
        $pubDate = "Fri, 28 Dec 2018 23:12:26 -0000";
        $date = $this->News->convertPubDateToDateTime($pubDate);
        $this->assertNotEmpty($date, "Erro ao converter pubDate para datetime");
        $this->assertEquals("2018-12-28", $date->format("Y-m-d"), "Erro ao converter pubDate para datetime");
    }

    /**
     * Teste da função getNew que retorna a notícia pelo id
     */
    public function testGetNew(){
        $news = DB::table("news")->first();
        $this->assertNotEmpty($news->id, "Erro em getNew");
    }
}

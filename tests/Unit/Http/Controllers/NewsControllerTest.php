<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsControllerTest extends TestCase
{
    /**
     * Teste da action index do controller News
     * @return void
     */
    public function testIndex()
    {
        $response = $this->json("GET", "/api/news");
        $response->assertStatus(200);
        $this->assertNotEmpty($response->content(), "Erro ao pegar as noticias em formato json");
        $news = json_decode($response->content());
        $this->assertNotEmpty($news->current_page, "Erro ao pegar as noticias em formato json");
        $this->assertNotEmpty($news->data[0]->id, "Erro ao pegar as noticias em formato json");
    }

    /**
     * Teste da action show do controller News
     */
    public function testShow()
    {
        $response = $this->json("GET", "/api/news");
        $response->assertStatus(200);
        $news = json_decode($response->content());

        $response_show = $this->json("GET", "/api/news/".$news->data[0]->id);
        $news_show = json_decode($response_show->content());
        $this->assertNotEmpty($response_show->content(), "Erro ao pegar a noticia em formato json");
        $this->assertNotEmpty($news_show->id, "Erro ao pegar a noticia em api/news/{id}");
        $this->assertNotEmpty($news_show->title, "Erro ao pegar a noticia em api/news/{id}");
        $this->assertNotEmpty($news_show->pubDate, "Erro ao pegar a noticia em api/news/{id}");
    }
}

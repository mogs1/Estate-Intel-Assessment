<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExternalBookTest extends TestCase
{
    public function test_returns_books_from_external_api(): void
    {
        Http::fake([
            '*' => Http::response([[
                'name'          => 'A Game of Thrones',
                'isbn'          => '978-0553103540',
                'authors'       => ['George R. R. Martin'],
                'numberOfPages' => 694,
                'publisher'     => 'Bantam Books',
                'country'       => 'United States',
                'released'      => '1996-08-01T00:00:00',
            ]], 200),
        ]);

        $response = $this->getJson('/api/external-books?name=A+Game+of+Thrones');

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'success'])
            ->assertJsonFragment(['name' => 'A Game of Thrones'])
            ->assertJsonFragment(['number_of_pages' => 694]);
    }

    public function test_returns_not_found_when_no_results(): void
    {
        Http::fake(['*' => Http::response([], 200)]);

        $response = $this->getJson('/api/external-books?name=UnknownBook');

        $response->assertStatus(404)
            ->assertJsonFragment(['status' => 'not found']);
    }
}
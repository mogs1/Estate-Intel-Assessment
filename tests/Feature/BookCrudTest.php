<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCrudTest extends TestCase
{
    use RefreshDatabase;

    private array $sample = [
        'name'            => 'My First Book',
        'isbn'            => '123-3213243567',
        'authors'         => ['John Doe'],
        'country'         => 'United States',
        'number_of_pages' => 350,
        'publisher'       => 'Acme Books',
        'release_date'    => '2019-08-01',
    ];

    public function test_can_create_a_book(): void
    {
        $response = $this->postJson('/api/v1/books', $this->sample);

        $response->assertStatus(201)
            ->assertJsonFragment(['status' => 'success'])
            ->assertJsonFragment(['name' => 'My First Book']);
    }

    public function test_can_list_books(): void
    {
        Book::create($this->sample);

        $response = $this->getJson('/api/v1/books');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'My First Book']);
    }

    public function test_can_show_a_book(): void
    {
        $book = Book::create($this->sample);

        $this->getJson("/api/v1/books/{$book->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'My First Book']);
    }

    public function test_can_update_a_book(): void
    {
        $book = Book::create($this->sample);

        $this->patchJson("/api/v1/books/{$book->id}", ['name' => 'Updated Book'])
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Book']);
    }

    public function test_can_delete_a_book(): void
    {
        $book = Book::create($this->sample);

        $this->deleteJson("/api/v1/books/{$book->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['status' => 'success']);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_can_search_books_by_name(): void
    {
        Book::create($this->sample);

        $this->getJson('/api/v1/books?name=First')
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'My First Book']);
    }
}
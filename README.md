# Books API

A REST API built with Laravel that proxies the Ice And Fire API and provides local CRUD for books.

## Requirements

- PHP 8.1+
- Composer

## Setup

```bash or powershell
git clone <your-repo-url>
cd books-api
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

## Running Tests

```bash or powershell
php artisan test
```

## Endpoints

| Method | URL | Description |
| GET | /api/external-books?name= | Search Ice & Fire API |
| GET | /api/v1/books | List all local books |
| POST | /api/v1/books | Create a book |
| GET | /api/v1/books/{id} | Show one book |
| PATCH | /api/v1/books/{id} | Update a book |
| DELETE | /api/v1/books/{id} | Delete a book |

Then run:

```bash or powershell
touch database/database.sqlite
php artisan migrate
```

### 5. Start the server

```bash or powershell
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`

## Running Tests

```bash or powershell
php artisan test
```

You should see 10 tests passing.

## API Endpoints

### External Books (Ice And Fire API)

| Method | Endpoint | Description |
| GET | `/api/external-books?name=A Game of Thrones` | Search books by name |

**Example response:**

```json
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "name": "A Game of Thrones",
            "isbn": "978-0553103540",
            "authors": ["George R. R. Martin"],
            "number_of_pages": 694,
            "publisher": "Bantam Books",
            "country": "United States",
            "release_date": "1996-08-01"
        }
    ]
}
```

### Local Books CRUD

| Method | Endpoint | Description |
| POST | `/api/v1/books` | Create a book |
| GET | `/api/v1/books` | List all books |
| GET | `/api/v1/books/{id}` | Show a single book |
| PATCH | `/api/v1/books/{id}` | Update a book |
| DELETE | `/api/v1/books/{id}` | Delete a book |

The list endpoint supports search filters:

- `?name=` — search by name
- `?country=` — filter by country
- `?publisher=` — filter by publisher
- `?release_date=` — filter by year e.g. `?release_date=1996`

**Create a book — example request body:**

```json
{
    "name": "My First Book",
    "isbn": "123-3213243567",
    "authors": ["John Doe"],
    "country": "United States",
    "number_of_pages": 350,
    "publisher": "Acme Books",
    "release_date": "2019-08-01"
}
```

## Project Structure

- `app/Http/Controllers/ExternalBookController.php` — handles Ice And Fire API proxy
- `app/Http/Controllers/BookController.php` — handles local CRUD operations
- `app/Models/Book.php` — Book model
- `database/migrations/` — database schema
- `routes/api.php` — all API routes
- `tests/Feature/` — feature tests for all endpoints

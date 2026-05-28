# Blog API — Microserviço Laravel 12

Este pacote contém a implementação completa de uma API profissional para um microserviço de **Blog/Notícias** em Laravel 12. A estrutura segue a separação esperada entre **Models**, **Migrations**, **Controllers**, **Form Requests**, **API Resources** e **Routes**, com rotas públicas, grupo administrativo preparado para JWT, health checks e dashboard web simples.

## Estrutura gerada

| Caminho | Finalidade |
|---|---|
| `app/Models/Post.php` | Model de posts, relacionamento com categoria, casts e slug automático único. |
| `app/Models/Category.php` | Model de categorias, relacionamento com posts e slug automático único. |
| `database/migrations/2026_05_28_000001_create_categories_table.php` | Migration da tabela `categories`. |
| `database/migrations/2026_05_28_000002_create_posts_table.php` | Migration da tabela `posts`. |
| `app/Http/Requests/PostRequest.php` | Validação para criação e atualização de posts. |
| `app/Http/Requests/CategoryRequest.php` | Validação para criação e atualização de categorias. |
| `app/Http/Resources/PostResource.php` | Serialização padronizada dos posts. |
| `app/Http/Resources/CategoryResource.php` | Serialização padronizada das categorias. |
| `app/Http/Controllers/Api/PostController.php` | CRUD completo de posts, filtros, paginação e tratamento de erros. |
| `app/Http/Controllers/Api/CategoryController.php` | CRUD completo de categorias e tratamento de integridade. |
| `routes/api.php` | Rotas versionadas em `/api/v1`, públicas e administrativas. |
| `routes/web.php` | Dashboard simples com as rotas disponíveis. |
| `resources/views/api-dashboard.blade.php` | View Blade do dashboard web. |

## Comandos para aplicar no projeto existente

Partindo do projeto já criado com `composer create-project laravel/laravel blog-api`, copie os arquivos deste pacote para a raiz do projeto e execute:

```bash
cd blog-api
composer install
cp .env.example .env
php artisan key:generate
```

Configure o banco de dados no arquivo `.env`. Em ambiente local, uma opção simples é usar SQLite:

```bash
touch database/database.sqlite
```

No `.env`, ajuste:

```dotenv
DB_CONNECTION=sqlite
# Remova ou comente DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME e DB_PASSWORD se necessário.
```

Em seguida, rode as migrations:

```bash
php artisan migrate
php artisan serve
```

> Em projetos Laravel 11/12, dependendo de como o projeto foi criado, o arquivo `routes/api.php` pode não estar registrado automaticamente. Se as rotas `/api/*` não aparecerem em `php artisan route:list`, execute `php artisan install:api` ou registre o arquivo `routes/api.php` no `bootstrap/app.php` usando o parâmetro `api` em `withRouting`.

## Rotas principais

| Método | Endpoint | Descrição |
|---|---|---|
| `GET` | `/api/v1/health` | Health check do serviço. |
| `GET` | `/api/v1/health-check-db` | Health check da conexão com banco de dados. |
| `GET` | `/api/v1/public/posts` | Lista posts com filtros e paginação. |
| `GET` | `/api/v1/public/posts/{slug}` | Exibe post público pelo slug. |
| `GET` | `/api/v1/public/categories` | Lista categorias. |
| `GET` | `/api/v1/public/categories/{slug}` | Exibe categoria pública pelo slug. |
| `GET` | `/api/v1/admin/posts` | Lista posts no grupo administrativo. |
| `POST` | `/api/v1/admin/posts` | Cria post. |
| `GET` | `/api/v1/admin/posts/{post}` | Exibe post por ID. |
| `PUT/PATCH` | `/api/v1/admin/posts/{post}` | Atualiza post. |
| `DELETE` | `/api/v1/admin/posts/{post}` | Remove post. |
| `apiResource` | `/api/v1/admin/categories` | CRUD completo de categorias. |

## Filtros de posts

A listagem de posts aceita os seguintes query parameters:

| Parâmetro | Exemplo | Descrição |
|---|---|---|
| `search` | `/api/v1/public/posts?search=Laravel` | Busca por título. |
| `category_id` | `/api/v1/public/posts?category_id=1` | Filtra por ID da categoria. |
| `category_slug` | `/api/v1/public/posts?category_slug=tecnologia` | Filtra por slug da categoria. |
| `is_featured` | `/api/v1/public/posts?is_featured=true` | Filtra posts em destaque. |
| `status` | `/api/v1/public/posts?status=published` | Filtra por `draft` ou `published`. |
| `per_page` | `/api/v1/public/posts?per_page=15` | Define a quantidade por página. |

## Exemplo de JSON para criar uma categoria

```json
{
  "name": "Tecnologia",
  "description": "Notícias sobre tecnologia, inovação, software e produtos digitais."
}
```

Endpoint:

```http
POST /api/v1/admin/categories
Content-Type: application/json
Accept: application/json
```

## Exemplo de JSON para criar um post

```json
{
  "title": "Laravel 12 em Arquiteturas de Microsserviços",
  "content": "Conteúdo completo da notícia, com contexto, análise e detalhes técnicos relevantes para o público do blog.",
  "excerpt": "Uma visão prática sobre o uso de Laravel 12 em microsserviços modernos.",
  "category_id": 1,
  "featured_image": "https://cdn.example.com/images/laravel-12-microservices.jpg",
  "is_featured": true,
  "status": "published",
  "published_at": "2026-05-28 10:00:00"
}
```

Endpoint:

```http
POST /api/v1/admin/posts
Content-Type: application/json
Accept: application/json
```

## Observações profissionais

A coluna `category_id` foi configurada com `restrictOnDelete` para evitar remoção acidental de categorias já vinculadas a posts. O controller de categorias também retorna HTTP `409 Conflict` quando uma remoção inválida é solicitada.

Os slugs são gerados automaticamente quando não são enviados pelo cliente. Caso já exista um slug igual, o sistema acrescenta sufixos incrementais, como `laravel-12`, `laravel-12-1` e `laravel-12-2`.

O grupo administrativo está preparado para futura autenticação JWT. Para ativá-la depois, basta instalar/configurar o guard desejado e descomentar/adaptar o middleware no grupo `/api/v1/admin` em `routes/api.php`.

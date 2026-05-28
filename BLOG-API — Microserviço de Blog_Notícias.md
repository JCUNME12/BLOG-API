# BLOG-API — Microserviço de Blog/Notícias

> **Status:** projeto funcional e testado localmente com Laravel 12, API versionada em `/api/v1`, conexão com banco validada, CRUD de categorias validado e CRUD/listagem/filtros de posts validados.

## Integrantes

| Nome | Função no projeto |
|---|---|
| **[Nome do integrante 1]** | Desenvolvimento da API e documentação. |
| **[Nome do integrante 2]** | Testes, validação das rotas e integração. |
| **[Nome do integrante 3]** | Modelagem, banco de dados e revisão. |

> Substitua os campos acima pelos nomes reais dos integrantes antes de enviar o repositório.

## Descrição do serviço

O **BLOG-API** é um microserviço responsável pelo gerenciamento e disponibilização de conteúdos de **blog, notícias e comunicados** dentro de uma arquitetura baseada em múltiplos serviços. Ele oferece uma API REST para criação, consulta, atualização e exclusão de **posts** e **categorias**, além de fornecer endpoints públicos para listagem paginada, busca por título, filtros por categoria, filtros por posts em destaque e consulta por slug.

O serviço foi desenvolvido com **Laravel 12** e segue uma organização orientada a boas práticas, utilizando **Models**, **Migrations**, **Controllers**, **Form Requests**, **API Resources**, rotas versionadas e health checks. A API foi preparada para futuramente receber autenticação JWT no grupo administrativo, mantendo separadas as rotas públicas de leitura e as rotas administrativas de escrita.

## Responsabilidades do microsserviço

| Responsabilidade | Descrição |
|---|---|
| Gerenciar categorias | Permite criar, listar, visualizar, atualizar e excluir categorias de notícias. |
| Gerenciar posts | Permite criar, listar, visualizar, atualizar e excluir posts do blog/notícias. |
| Gerar slugs automáticos | Cria slugs únicos a partir do título do post ou nome da categoria. |
| Controlar publicação | Permite definir posts como `draft` ou `published`, além de informar `published_at`. |
| Destacar conteúdos | Permite marcar posts como destaque por meio do campo `is_featured`. |
| Fornecer listagem pública | Disponibiliza posts e categorias para consumo por frontend, gateway ou outros serviços. |
| Aplicar filtros | Permite busca por título, filtro por categoria, filtro por destaque e paginação. |
| Validar dados recebidos | Usa Form Requests para garantir entrada consistente e retornos de erro padronizados. |
| Padronizar respostas | Usa API Resources para retornar JSON organizado e previsível. |
| Verificar saúde do serviço | Oferece rotas de health check do serviço e da conexão com banco. |

## Tecnologias utilizadas

| Tecnologia | Finalidade |
|---|---|
| **PHP 8.2+** | Linguagem utilizada para executar a aplicação Laravel. |
| **Laravel 12** | Framework principal da API. |
| **Composer** | Gerenciador de dependências PHP. |
| **MySQL/MariaDB** | Banco de dados utilizado no ambiente local com XAMPP. |
| **XAMPP** | Ambiente local contendo Apache, PHP e MySQL/MariaDB. |
| **PowerShell** | Terminal usado nos testes locais em Windows. |
| **Git e GitHub** | Versionamento e hospedagem do repositório. |

## Requisitos necessários para rodar o projeto

Este projeto foi testado localmente sem Docker, utilizando XAMPP no Windows. Para executar o projeto, é necessário ter PHP, Composer, MySQL/MariaDB e Git instalados e acessíveis pelo terminal.

| Requisito | Versão recomendada |
|---|---|
| PHP | 8.2 ou superior |
| Composer | 2.x ou superior |
| Laravel | 12.x |
| Banco de dados | MySQL 8.x ou MariaDB compatível |
| Servidor local | XAMPP ou equivalente |
| Git | Versão atual estável |

## Opção escolhida: sem Docker

Nesta entrega, o projeto está configurado para execução **sem Docker**, usando ambiente local com XAMPP. Portanto, os arquivos `Dockerfile` e `docker-compose.yml` não são obrigatórios para esta versão. Caso o grupo decida migrar para Docker futuramente, será necessário adicionar esses arquivos e atualizar este README com portas, containers, volumes e variáveis de ambiente.

## Passo a passo de instalação

Clone o repositório e acesse a pasta do projeto:

```bash
git clone https://github.com/SEU-USUARIO/BLOG-API.git
cd BLOG-API
```

Instale as dependências PHP:

```bash
composer install
```

Crie o arquivo de ambiente com base no exemplo:

```bash
cp .env.example .env
```

No Windows PowerShell, caso o comando `cp` não esteja disponível, use:

```powershell
copy .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Crie o banco de dados no MySQL/MariaDB com o nome:

```sql
CREATE DATABASE blog_api;
```

Depois execute as migrations:

```bash
php artisan migrate
```

## Configuração do `.env`

A configuração abaixo representa o ambiente local usando MySQL/MariaDB pelo XAMPP. O usuário padrão costuma ser `root` e, em instalações locais comuns do XAMPP, a senha geralmente fica vazia.

```dotenv
APP_NAME="Blog API"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_api
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

Após alterar o `.env`, limpe as configurações carregadas em cache:

```bash
php artisan config:clear
php artisan route:clear
```

## Registro das rotas de API no Laravel 12

Em projetos Laravel 12 recém-criados, é importante confirmar que o arquivo `routes/api.php` está registrado no `bootstrap/app.php`. O bloco `withRouting` deve conter a entrada `api`:

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

Sem essa configuração, as rotas `/api/v1/...` podem retornar `404 Not Found`, mesmo que o arquivo `routes/api.php` exista no projeto.

## Como executar o projeto

Com o banco de dados criado, dependências instaladas e `.env` configurado, execute:

```bash
php artisan serve
```

A aplicação ficará disponível em:

```text
http://127.0.0.1:8000
```

O dashboard simples com as rotas documentadas pode ser acessado em:

```text
http://127.0.0.1:8000/
```

## Como testar o projeto

Primeiro, teste se o serviço está online:

```bash
curl http://127.0.0.1:8000/api/v1/health
```

Depois, teste a conexão com o banco:

```bash
curl http://127.0.0.1:8000/api/v1/health-check-db
```

No PowerShell, recomenda-se usar `Invoke-RestMethod` para testar requisições JSON com mais segurança.

```powershell
Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/v1/health" -Method Get
```

## Rotas da API

As rotas seguem o prefixo `/api/v1`. As rotas públicas são usadas para leitura e podem ser consumidas por frontend, gateway ou outros microsserviços. As rotas administrativas permitem escrita e estão preparadas para receber autenticação JWT futuramente.

| Método | Endpoint | Acesso | Descrição |
|---|---|---|---|
| `GET` | `/api/v1/health` | Público | Verifica se o serviço está online. |
| `GET` | `/api/v1/health-check-db` | Público | Verifica se a conexão com o banco de dados está funcionando. |
| `GET` | `/api/v1/public/posts` | Público | Lista posts com paginação e filtros. |
| `GET` | `/api/v1/public/posts/{slug}` | Público | Busca um post publicado pelo slug. |
| `GET` | `/api/v1/public/categories` | Público | Lista categorias com contagem de posts. |
| `GET` | `/api/v1/public/categories/{slug}` | Público | Busca uma categoria pelo slug. |
| `GET` | `/api/v1/admin/posts` | Administrativo | Lista posts no contexto administrativo. |
| `POST` | `/api/v1/admin/posts` | Administrativo | Cria um novo post. |
| `GET` | `/api/v1/admin/posts/{id}` | Administrativo | Busca um post por ID. |
| `PUT/PATCH` | `/api/v1/admin/posts/{id}` | Administrativo | Atualiza um post existente. |
| `DELETE` | `/api/v1/admin/posts/{id}` | Administrativo | Remove um post. |
| `GET` | `/api/v1/admin/categories` | Administrativo | Lista categorias. |
| `POST` | `/api/v1/admin/categories` | Administrativo | Cria uma nova categoria. |
| `GET` | `/api/v1/admin/categories/{id}` | Administrativo | Busca uma categoria por ID. |
| `PUT/PATCH` | `/api/v1/admin/categories/{id}` | Administrativo | Atualiza uma categoria existente. |
| `DELETE` | `/api/v1/admin/categories/{id}` | Administrativo | Remove uma categoria, desde que não tenha posts vinculados. |

## Filtros disponíveis na listagem de posts

| Parâmetro | Tipo | Exemplo | Descrição |
|---|---|---|---|
| `search` | string | `/api/v1/public/posts?search=Laravel` | Busca posts pelo título. |
| `category_id` | integer | `/api/v1/public/posts?category_id=1` | Filtra posts por ID da categoria. |
| `category_slug` | string | `/api/v1/public/posts?category_slug=tecnologia` | Filtra posts pelo slug da categoria. |
| `is_featured` | boolean | `/api/v1/public/posts?is_featured=true` | Filtra posts destacados. |
| `status` | string | `/api/v1/public/posts?status=published` | Filtra por `draft` ou `published`. |
| `per_page` | integer | `/api/v1/public/posts?per_page=15` | Define a quantidade de itens por página. |

## Exemplos de requisição e resposta em JSON

### Criar categoria

**Requisição:**

```http
POST /api/v1/admin/categories
Content-Type: application/json
Accept: application/json
```

```json
{
  "name": "Tecnologia",
  "description": "Noticias sobre tecnologia, inovacao e software."
}
```

**Resposta esperada:**

```json
{
  "data": {
    "id": 1,
    "name": "Tecnologia",
    "slug": "tecnologia",
    "description": "Noticias sobre tecnologia, inovacao e software.",
    "posts_count": 0,
    "created_at": "2026-05-28T16:17:19.000000Z",
    "updated_at": "2026-05-28T16:17:19.000000Z"
  }
}
```

### Criar post

**Requisição:**

```http
POST /api/v1/admin/posts
Content-Type: application/json
Accept: application/json
```

```json
{
  "title": "Laravel 12 em Microsservicos",
  "content": "Conteudo completo da noticia sobre Laravel 12 em uma arquitetura de microsservicos.",
  "excerpt": "Resumo da noticia sobre Laravel 12.",
  "category_id": 1,
  "featured_image": "https://cdn.example.com/images/laravel.jpg",
  "is_featured": true,
  "status": "published",
  "published_at": "2026-05-28 10:00:00"
}
```

**Resposta esperada:**

```json
{
  "data": {
    "id": 1,
    "title": "Laravel 12 em Microsservicos",
    "slug": "laravel-12-em-microsservicos",
    "content": "Conteudo completo da noticia sobre Laravel 12 em uma arquitetura de microsservicos.",
    "excerpt": "Resumo da noticia sobre Laravel 12.",
    "featured_image": "https://cdn.example.com/images/laravel.jpg",
    "is_featured": true,
    "status": "published",
    "published_at": "2026-05-28T10:00:00.000000Z",
    "category": {
      "id": 1,
      "name": "Tecnologia",
      "slug": "tecnologia",
      "description": "Noticias sobre tecnologia, inovacao e software."
    },
    "created_at": "2026-05-28T16:18:43.000000Z",
    "updated_at": "2026-05-28T16:18:43.000000Z"
  }
}
```

### Listar posts com paginação

**Requisição:**

```http
GET /api/v1/public/posts
Accept: application/json
```

**Resposta esperada:**

```json
{
  "data": [
    {
      "id": 1,
      "title": "Laravel 12 em Microsservicos",
      "slug": "laravel-12-em-microsservicos",
      "excerpt": "Resumo da noticia sobre Laravel 12.",
      "is_featured": true,
      "status": "published",
      "published_at": "2026-05-28T10:00:00.000000Z",
      "category": {
        "id": 1,
        "name": "Tecnologia",
        "slug": "tecnologia"
      }
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/v1/public/posts?page=1",
    "last": "http://127.0.0.1:8000/api/v1/public/posts?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 1
  }
}
```

### Atualizar post

**Requisição:**

```http
PATCH /api/v1/admin/posts/1
Content-Type: application/json
Accept: application/json
```

```json
{
  "title": "Laravel 12 em APIs de Noticias",
  "is_featured": false
}
```

**Resposta esperada:**

```json
{
  "data": {
    "id": 1,
    "title": "Laravel 12 em APIs de Noticias",
    "slug": "laravel-12-em-apis-de-noticias",
    "is_featured": false,
    "status": "published"
  }
}
```

### Excluir post

**Requisição:**

```http
DELETE /api/v1/admin/posts/1
Accept: application/json
```

**Resposta esperada:**

```json
{
  "message": "Post deleted successfully."
}
```

## Quais dados o serviço recebe

O serviço recebe dados relacionados a categorias e posts. Para categorias, recebe `name`, `slug` opcional e `description`. Para posts, recebe `title`, `slug` opcional, `content`, `excerpt`, `category_id`, `featured_image`, `is_featured`, `status` e `published_at`.

| Entidade | Dados recebidos |
|---|---|
| Categoria | `name`, `slug`, `description` |
| Post | `title`, `slug`, `content`, `excerpt`, `category_id`, `featured_image`, `is_featured`, `status`, `published_at` |

## Quais dados o serviço retorna

O serviço retorna respostas JSON padronizadas por meio de API Resources. As respostas de post incluem os dados principais do conteúdo e, quando aplicável, os dados da categoria relacionada. As listagens paginadas retornam também os objetos `links` e `meta`, permitindo navegação entre páginas.

| Resposta | Dados retornados |
|---|---|
| Categoria | `id`, `name`, `slug`, `description`, `posts_count`, `created_at`, `updated_at` |
| Post | `id`, `title`, `slug`, `content`, `excerpt`, `featured_image`, `is_featured`, `status`, `published_at`, `category`, `created_at`, `updated_at` |
| Paginação | `data`, `links`, `meta` |

## Integrações com outros microsserviços

O **BLOG-API** foi pensado para participar de uma arquitetura maior de microsserviços. Nesta versão, a integração real implementada é com o banco de dados do próprio serviço. As demais integrações estão documentadas como pontos previstos para evolução do sistema.

| Serviço externo | Tipo de integração | Situação | Descrição |
|---|---|---|---|
| Auth Service | Consumo futuro | Preparado | O grupo administrativo poderá validar JWT emitido pelo serviço de autenticação. |
| Gateway/API Gateway | Consumidor da API | Previsto | Um gateway pode encaminhar chamadas públicas e administrativas para o BLOG-API. |
| Frontend/Web App | Consumidor da API | Previsto | A interface web/mobile pode consumir posts, categorias, destaques e buscas. |
| Notification Service | Consumidor/evento futuro | Previsto | Pode ser notificado quando um post for publicado para avisar usuários. |
| Media/Storage Service | Consumo futuro | Previsto | Pode armazenar e fornecer URLs de imagens usadas em `featured_image`. |
| Search Service | Consumidor futuro | Previsto | Pode indexar posts publicados para busca global do sistema. |

## Quais serviços o BLOG-API consome

Atualmente, o BLOG-API consome diretamente apenas seu banco de dados relacional. Em uma evolução da arquitetura, ele poderá consumir o serviço de autenticação para validar permissões administrativas e um serviço de mídia para gerenciar upload e armazenamento de imagens.

| Serviço consumido | Finalidade |
|---|---|
| Banco MySQL/MariaDB | Persistir posts, categorias e metadados. |
| Auth Service | Validar tokens JWT em rotas administrativas, em evolução futura. |
| Media/Storage Service | Obter ou validar URLs de imagens destacadas, em evolução futura. |

## Quais serviços utilizam a API

A API pode ser utilizada por interfaces frontend, aplicativos móveis, gateway central, microsserviço de notificações, serviço de busca e painéis administrativos.

| Consumidor | Uso principal |
|---|---|
| Frontend Web | Exibir notícias, posts, categorias e destaques. |
| Aplicativo Mobile | Consumir conteúdo público do blog/notícias. |
| API Gateway | Centralizar o acesso ao microserviço. |
| Painel Administrativo | Criar, editar e remover posts e categorias. |
| Notification Service | Enviar notificações quando novos posts forem publicados. |
| Search Service | Indexar conteúdos publicados para busca global. |

## Fluxo principal do serviço

O fluxo principal começa quando um administrador cria uma categoria e, em seguida, cadastra um post vinculado a essa categoria. O serviço valida os dados recebidos, gera automaticamente o slug, grava as informações no banco de dados e disponibiliza o conteúdo pelas rotas públicas quando o status está como `published`.

| Etapa | Descrição |
|---|---|
| 1 | Administrador cria uma categoria, como `Tecnologia`. |
| 2 | Administrador cria um post vinculado à categoria. |
| 3 | O BLOG-API valida os dados usando Form Requests. |
| 4 | O serviço gera slugs únicos para categoria e post. |
| 5 | O post é salvo como `draft` ou `published`. |
| 6 | Se publicado, o post fica disponível nas rotas públicas. |
| 7 | Frontend, gateway ou outros serviços consomem a listagem de posts. |
| 8 | Serviços externos, como notificações ou busca, podem utilizar os dados publicados. |

### Exemplo de fluxo dentro do sistema geral

```text
Administrador cadastra categoria
        ↓
Administrador publica notícia
        ↓
BLOG-API valida, gera slug e salva no banco
        ↓
Frontend/Gateway consulta /api/v1/public/posts
        ↓
Usuário visualiza notícia publicada
        ↓
Serviços de busca/notificação podem consumir o conteúdo publicado
```

## Possíveis erros e retornos esperados

A API retorna códigos HTTP adequados para falhas de validação, registros inexistentes, conflitos de integridade e indisponibilidade do banco.

| Situação | Código HTTP | Exemplo de retorno |
|---|---:|---|
| Dados inválidos | `422` | Campos obrigatórios ausentes ou formato inválido. |
| Post inexistente | `404` | Registro não encontrado. |
| Categoria inexistente | `404` | Registro não encontrado. |
| Categoria com posts vinculados | `409` | Exclusão bloqueada por conflito de integridade. |
| Serviço indisponível | `500` | Erro inesperado do servidor. |
| Banco indisponível | `503` | Health check do banco falha. |

### Exemplo de erro de validação

```json
{
  "message": "The title field is required.",
  "errors": {
    "title": [
      "The title field is required."
    ]
  }
}
```

### Exemplo de categoria inexistente

```json
{
  "message": "No query results for model [App\\Models\\Category] 999"
}
```

### Exemplo de conflito ao excluir categoria com posts

```json
{
  "message": "Category cannot be deleted because it has posts associated."
}
```

## Comandos úteis para testes no PowerShell

### Criar categoria

```powershell
$body = @{
  name = "Tecnologia"
  description = "Noticias sobre tecnologia, inovacao e software."
} | ConvertTo-Json -Compress

Invoke-RestMethod `
  -Uri "http://127.0.0.1:8000/api/v1/admin/categories" `
  -Method Post `
  -Headers @{ Accept = "application/json" } `
  -ContentType "application/json" `
  -Body $body
```

### Criar post

```powershell
$body = @{
  title = "Laravel 12 em Microsservicos"
  content = "Conteudo completo da noticia sobre Laravel 12 em uma arquitetura de microsservicos."
  excerpt = "Resumo da noticia sobre Laravel 12."
  category_id = 1
  featured_image = "https://cdn.example.com/images/laravel.jpg"
  is_featured = $true
  status = "published"
  published_at = "2026-05-28 10:00:00"
} | ConvertTo-Json -Compress

Invoke-RestMethod `
  -Uri "http://127.0.0.1:8000/api/v1/admin/posts" `
  -Method Post `
  -Headers @{ Accept = "application/json" } `
  -ContentType "application/json" `
  -Body $body
```

### Listar posts formatando JSON

```powershell
$response = Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/v1/public/posts" -Method Get
$response | ConvertTo-Json -Depth 10
```

## Documentação dos arquivos principais

| Arquivo | Responsabilidade |
|---|---|
| `app/Models/Post.php` | Model de posts com relacionamento, casts e slug automático. |
| `app/Models/Category.php` | Model de categorias com relacionamento e slug automático. |
| `app/Http/Controllers/Api/PostController.php` | CRUD, filtros, paginação e respostas de posts. |
| `app/Http/Controllers/Api/CategoryController.php` | CRUD e validações de integridade das categorias. |
| `app/Http/Requests/PostRequest.php` | Validação dos dados de posts. |
| `app/Http/Requests/CategoryRequest.php` | Validação dos dados de categorias. |
| `app/Http/Resources/PostResource.php` | Padronização do JSON de posts. |
| `app/Http/Resources/CategoryResource.php` | Padronização do JSON de categorias. |
| `database/migrations/*create_categories_table.php` | Estrutura da tabela `categories`. |
| `database/migrations/*create_posts_table.php` | Estrutura da tabela `posts`. |
| `routes/api.php` | Rotas versionadas da API. |
| `routes/web.php` | Dashboard simples com rotas disponíveis. |

## Checklist de entrega

| Item obrigatório | Situação |
|---|---|
| Link do repositório | Pendente após criação no GitHub. |
| README completo | Atendido por este arquivo. |
| `.env.example` | Deve ser versionado no repositório. |
| Dockerfile e docker-compose.yml | Não aplicável nesta entrega, pois a opção escolhida é sem Docker. |
| Documentação das rotas | Atendida. |
| Exemplos JSON | Atendidos. |
| Explicação das integrações | Atendida. |
| Fluxo principal do serviço | Atendido. |
| Como executar localmente | Atendido. |
| Como testar localmente | Atendido. |

## Referências

[1]: https://laravel.com/docs/12.x "Laravel 12 Documentation"
[2]: https://getcomposer.org/doc/ "Composer Documentation"
[3]: https://www.php.net/manual/pt_BR/ "PHP Manual"

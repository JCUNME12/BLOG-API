# 📰 BLOG-API — Microserviço de Blog/Notícias

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL%2FMariaDB-Banco%20de%20Dados-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-Funcional-brightgreen?style=flat-square)

Este é o microserviço responsável pelo gerenciamento de **posts**, **categorias**, **notícias publicadas**, **conteúdos em destaque** e **listagens públicas filtradas** dentro de um ecossistema baseado em APIs. O serviço permite cadastrar, consultar, atualizar e remover conteúdos de blog/notícias, além de disponibilizar endpoints públicos para consumo por frontend, gateway ou outros microsserviços.

---

## 👥 Integrantes do Grupo

- **João Carlos Campos**
- **Lucas Higinio**

---

## 📝 Descrição do Serviço

O **BLOG-API** atua como o serviço central de publicação de conteúdos informativos em uma arquitetura de microsserviços. Ele resolve o problema de organização e distribuição de notícias, permitindo que administradores cadastrem categorias e posts, enquanto usuários e outros serviços consomem apenas os conteúdos públicos publicados.

A API foi desenvolvida em **Laravel 12**, utilizando uma estrutura organizada com **Models**, **Migrations**, **Controllers**, **Form Requests**, **API Resources** e rotas versionadas em `/api/v1`. O projeto está preparado para evoluir com autenticação JWT nas rotas administrativas, mantendo separadas as operações públicas de leitura e as operações administrativas de escrita.

---

## ⚙️ Responsabilidades do Microsserviço

- **Gerenciamento de Categorias:** cadastrar, listar, consultar, atualizar e excluir categorias de notícias.
- **Gerenciamento de Posts:** cadastrar, listar, consultar, atualizar e excluir posts do blog/notícias.
- **Geração de Slugs:** criar slugs automaticamente a partir do nome da categoria ou título do post.
- **Controle de Publicação:** permitir que posts sejam definidos como `draft` ou `published`.
- **Posts em Destaque:** permitir marcação de conteúdos especiais por meio do campo `is_featured`.
- **Listagem Pública:** disponibilizar posts e categorias para consumo externo.
- **Filtros e Paginação:** permitir busca por título, categoria, destaque, status e paginação.
- **Validação de Dados:** validar entradas por meio de Form Requests.
- **Padronização de Respostas:** retornar dados em JSON utilizando API Resources.
- **Health Checks:** fornecer rotas para verificar a saúde da API e da conexão com o banco.

---

## 🛠️ Tecnologias Utilizadas

| Tecnologia | Uso no Projeto |
|---|---|
| **PHP 8.2+** | Linguagem principal utilizada pela aplicação. |
| **Laravel 12** | Framework utilizado para construção da API REST. |
| **Composer** | Gerenciador de dependências PHP. |
| **MySQL/MariaDB** | Banco de dados relacional utilizado pelo microserviço. |
| **XAMPP** | Ambiente local usado para executar Apache, PHP e MySQL/MariaDB no Windows. |
| **PowerShell** | Terminal utilizado para execução dos comandos e testes locais. |
| **Git** | Controle de versão do código-fonte. |
| **GitHub/Git remoto** | Hospedagem do repositório e entrega do projeto. |

---

## ⚙️ Requisitos Necessários

Para rodar este microserviço localmente, é necessário ter instalado:

- **PHP 8.2 ou superior**.
- **Composer 2.x ou superior**.
- **MySQL ou MariaDB**, podendo ser pelo XAMPP.
- **Git** para clonar e versionar o projeto.
- **PowerShell**, Prompt de Comando, Git Bash ou terminal equivalente.

| Requisito | Versão Recomendada |
|---|---|
| PHP | 8.2+ |
| Laravel | 12.x |
| Composer | 2.x+ |
| Banco de dados | MySQL 8.x ou MariaDB compatível |
| Servidor local | XAMPP ou equivalente |

---

## 📦 Ambiente de Execução

Este projeto foi configurado para execução **sem Docker**, utilizando ambiente local com **XAMPP** no Windows. Portanto, os arquivos `Dockerfile` e `docker-compose.yml` não são obrigatórios nesta entrega.

> A opção escolhida para esta entrega foi a execução local sem Docker. Caso o projeto seja migrado futuramente para containers, será necessário criar o `Dockerfile`, o `docker-compose.yml` e atualizar esta documentação com portas, serviços, volumes e variáveis de ambiente.

---

## 🚀 Passo a Passo de Instalação e Execução

### 1. Clonar o Repositório

```bash
git clone https://github.com/JCUNME12/BLOG-API.git
cd BLOG-API
```

Caso esteja usando o repositório institucional, utilize:

```bash
git clone https://git.juancjc.com.br/Joao_Carlos_Campos/blog-api.git
cd blog-api
```

### 2. Instalar as Dependências

```bash
composer install
```

### 3. Criar o Arquivo `.env`

No Windows PowerShell, execute:

```powershell
copy .env.example .env
```

Em Linux, macOS ou Git Bash, execute:

```bash
cp .env.example .env
```

### 4. Gerar a Chave da Aplicação

```bash
php artisan key:generate
```

### 5. Criar o Banco de Dados

No MySQL/MariaDB, crie um banco chamado `blog_api`:

```sql
CREATE DATABASE blog_api;
```

### 6. Executar as Migrations

```bash
php artisan migrate
```

### 7. Iniciar o Servidor Local

```bash
php artisan serve
```

A aplicação ficará disponível em:

```text
http://127.0.0.1:8000
```

---

## 🔐 Configuração do `.env`

O arquivo `.env.example` deve ficar versionado no repositório. Já o arquivo `.env` real deve permanecer apenas na máquina local, pois contém configurações específicas do ambiente.

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

Após alterar configurações de ambiente, limpe o cache do Laravel:

```bash
php artisan config:clear
php artisan route:clear
```

---

## 🧭 Observação Importante sobre Laravel 12

Em projetos Laravel 12, o arquivo `routes/api.php` precisa estar registrado no `bootstrap/app.php`. O bloco `withRouting` deve conter a entrada `api`:

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
```

Sem essa configuração, as rotas `/api/v1/...` podem retornar `404 Not Found`, mesmo que estejam corretamente declaradas no arquivo `routes/api.php`.

---

## 🧪 Como Testar o Projeto

Para testar as rotas da API, podem ser usadas ferramentas como **Postman**, **Insomnia** ou o próprio terminal com **Invoke-RestMethod** no PowerShell.

### Teste de Saúde da API

```powershell
Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/v1/health" -Method Get
```

### Teste de Conexão com o Banco

```powershell
Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/v1/health-check-db" -Method Get
```

### Cabeçalhos Recomendados para POST, PUT e PATCH

```http
Accept: application/json
Content-Type: application/json
```

---

## 🔒 Rotas da API

Todas as rotas principais usam o prefixo `/api/v1`. As rotas públicas são voltadas para leitura, enquanto as rotas administrativas realizam operações de criação, atualização e exclusão.

| Método | Endpoint | Tipo | Descrição |
|---|---|---|---|
| `GET` | `/api/v1/health` | Público | Verifica se a API está online. |
| `GET` | `/api/v1/health-check-db` | Público | Verifica a conexão com o banco de dados. |
| `GET` | `/api/v1/public/posts` | Público | Lista posts publicados com filtros e paginação. |
| `GET` | `/api/v1/public/posts/{slug}` | Público | Busca um post publicado pelo slug. |
| `GET` | `/api/v1/public/categories` | Público | Lista categorias disponíveis. |
| `GET` | `/api/v1/public/categories/{slug}` | Público | Busca uma categoria pelo slug. |
| `GET` | `/api/v1/admin/posts` | Administrativo | Lista posts no contexto administrativo. |
| `POST` | `/api/v1/admin/posts` | Administrativo | Cria um novo post. |
| `GET` | `/api/v1/admin/posts/{id}` | Administrativo | Busca um post por ID. |
| `PUT/PATCH` | `/api/v1/admin/posts/{id}` | Administrativo | Atualiza um post existente. |
| `DELETE` | `/api/v1/admin/posts/{id}` | Administrativo | Remove um post. |
| `GET` | `/api/v1/admin/categories` | Administrativo | Lista categorias no contexto administrativo. |
| `POST` | `/api/v1/admin/categories` | Administrativo | Cria uma nova categoria. |
| `GET` | `/api/v1/admin/categories/{id}` | Administrativo | Busca uma categoria por ID. |
| `PUT/PATCH` | `/api/v1/admin/categories/{id}` | Administrativo | Atualiza uma categoria existente. |
| `DELETE` | `/api/v1/admin/categories/{id}` | Administrativo | Remove uma categoria sem posts vinculados. |

---

## 🔎 Filtros Disponíveis na Listagem de Posts

| Parâmetro | Tipo | Exemplo | Finalidade |
|---|---|---|---|
| `search` | string | `/api/v1/public/posts?search=Laravel` | Busca posts pelo título. |
| `category_id` | integer | `/api/v1/public/posts?category_id=1` | Filtra posts por ID da categoria. |
| `category_slug` | string | `/api/v1/public/posts?category_slug=tecnologia` | Filtra posts pelo slug da categoria. |
| `is_featured` | boolean | `/api/v1/public/posts?is_featured=true` | Filtra posts em destaque. |
| `status` | string | `/api/v1/public/posts?status=published` | Filtra por `draft` ou `published`. |
| `per_page` | integer | `/api/v1/public/posts?per_page=15` | Define a quantidade de itens por página. |

---

## 📤 Exemplos de Requisição e Resposta em JSON

### Criar Categoria

**Endpoint:** `POST /api/v1/admin/categories`

**Corpo da requisição:**

```json
{
  "name": "Tecnologia",
  "description": "Noticias sobre tecnologia, inovacao e software."
}
```

**Retorno esperado:**

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

### Criar Post

**Endpoint:** `POST /api/v1/admin/posts`

**Corpo da requisição:**

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

**Retorno esperado:**

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
    }
  }
}
```

### Listar Posts Publicados

**Endpoint:** `GET /api/v1/public/posts`

**Retorno esperado:**

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

### Excluir Post

**Endpoint:** `DELETE /api/v1/admin/posts/1`

**Retorno esperado:**

```json
{
  "message": "Post deleted successfully."
}
```

---

## 📥 Dados Recebidos e Retornados

O serviço recebe dados relacionados às entidades **Categoria** e **Post**. As respostas são retornadas em JSON e seguem uma estrutura padronizada por meio de API Resources.

| Entidade | Dados Recebidos |
|---|---|
| Categoria | `name`, `slug` opcional, `description` |
| Post | `title`, `slug` opcional, `content`, `excerpt`, `category_id`, `featured_image`, `is_featured`, `status`, `published_at` |

| Resposta | Dados Retornados |
|---|---|
| Categoria | `id`, `name`, `slug`, `description`, `posts_count`, `created_at`, `updated_at` |
| Post | `id`, `title`, `slug`, `content`, `excerpt`, `featured_image`, `is_featured`, `status`, `published_at`, `category`, `created_at`, `updated_at` |
| Paginação | `data`, `links`, `meta` |

---

## 🔗 Integrações com Outros Microsserviços

Este serviço trabalha de forma desacoplada, mas foi projetado para integrar um ecossistema maior. Nesta versão, a integração real implementada é com seu próprio banco de dados. As demais integrações estão documentadas como evolução futura.

| Serviço | Tipo de Integração | Situação | Descrição |
|---|---|---|---|
| **Banco MySQL/MariaDB** | Consumo direto | Implementado | Armazena posts, categorias e metadados. |
| **Auth Service** | Consumo futuro | Preparado | Poderá validar tokens JWT para proteger rotas administrativas. |
| **API Gateway** | Consumidor da API | Previsto | Poderá centralizar chamadas para o BLOG-API. |
| **Frontend Web/Mobile** | Consumidor da API | Previsto | Poderá exibir posts, categorias, destaques e buscas. |
| **Notification Service** | Consumidor futuro | Previsto | Poderá notificar usuários quando novos posts forem publicados. |
| **Search Service** | Consumidor futuro | Previsto | Poderá indexar posts publicados para busca global. |
| **Media/Storage Service** | Consumo futuro | Previsto | Poderá armazenar imagens usadas no campo `featured_image`. |

---

## 🔄 Fluxo Principal do Serviço

O fluxo principal começa quando um administrador cria uma categoria e cadastra um post vinculado a ela. O BLOG-API valida os dados recebidos, gera o slug automaticamente, salva o conteúdo no banco e disponibiliza o post nas rotas públicas quando o status está como `published`.

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

| Etapa | Descrição |
|---|---|
| 1 | O administrador cria uma categoria, como `Tecnologia`. |
| 2 | O administrador cria um post vinculado à categoria. |
| 3 | O serviço valida os dados usando Form Requests. |
| 4 | O sistema gera automaticamente os slugs. |
| 5 | O post é salvo como `draft` ou `published`. |
| 6 | Se estiver publicado, o post aparece nas rotas públicas. |
| 7 | Frontend, gateway ou outros serviços consomem a listagem. |

---

## ⚠️ Possíveis Erros e Retornos Esperados

Caso algo saia do fluxo ideal, a API retorna códigos HTTP e mensagens adequadas para facilitar o tratamento pelo cliente.

| Situação | Código HTTP | Exemplo de Retorno |
|---|---:|---|
| Dados inválidos | `422` | Campos obrigatórios ausentes ou em formato inválido. |
| Post inexistente | `404` | Registro de post não encontrado. |
| Categoria inexistente | `404` | Registro de categoria não encontrado. |
| Categoria com posts vinculados | `409` | Exclusão bloqueada por conflito de integridade. |
| Erro interno | `500` | Erro inesperado no servidor. |
| Banco indisponível | `503` | Falha no health check do banco de dados. |

### Exemplo de Erro de Validação

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

### Exemplo de Categoria com Posts Vinculados

```json
{
  "message": "Category cannot be deleted because it has posts associated."
}
```

---

## 🧾 Arquivos Principais do Projeto

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

---

## ✅ Checklist de Entrega

| Item Obrigatório | Situação |
|---|---|
| Link do repositório | Atendido. |
| README completo | Atendido por este arquivo. |
| `.env.example` | Atendido e deve ser versionado. |
| `.env` real fora do Git | Atendido pelo `.gitignore`. |
| Documentação das rotas | Atendido. |
| Exemplos JSON | Atendido. |
| Explicação das integrações | Atendido. |
| Fluxo principal do serviço | Atendido. |
| Como executar localmente | Atendido. |
| Como testar localmente | Atendido. |
| Dockerfile e docker-compose.yml | Não aplicável nesta entrega sem Docker. |

---

## 📚 Referências

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Composer Documentation](https://getcomposer.org/doc/)
- [PHP Manual](https://www.php.net/manual/pt_BR/)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## 📌 Observação Final

Este microserviço está funcional localmente e foi testado com rotas de health check, CRUD de categorias, CRUD de posts, filtros públicos, paginação, slugs automáticos, status de publicação e posts em destaque.

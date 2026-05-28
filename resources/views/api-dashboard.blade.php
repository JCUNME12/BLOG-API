<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $serviceName }} - Dashboard</title>
    <style>
        :root {
            color-scheme: light dark;
            --bg: #0f172a;
            --card: #111827;
            --text: #e5e7eb;
            --muted: #94a3b8;
            --accent: #38bdf8;
            --border: #1f2937;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top left, #1e3a8a 0, var(--bg) 40%);
            color: var(--text);
        }
        main {
            width: min(1120px, calc(100% - 32px));
            margin: 48px auto;
        }
        .hero {
            padding: 32px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: rgba(17, 24, 39, 0.88);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.35);
        }
        h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 5vw, 3.5rem);
            letter-spacing: -0.04em;
        }
        p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }
        table {
            width: 100%;
            margin-top: 28px;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 18px;
            background: rgba(15, 23, 42, 0.72);
        }
        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }
        th {
            color: #bfdbfe;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: rgba(30, 41, 59, 0.92);
        }
        code {
            color: var(--accent);
            white-space: nowrap;
        }
        .badge {
            display: inline-flex;
            padding: 4px 10px;
            border: 1px solid rgba(56, 189, 248, 0.4);
            border-radius: 999px;
            color: #bae6fd;
            background: rgba(14, 165, 233, 0.12);
            font-size: 0.82rem;
        }
        @media (max-width: 760px) {
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr { border-bottom: 1px solid var(--border); }
            td { border-bottom: none; }
            td::before {
                content: attr(data-label);
                display: block;
                margin-bottom: 6px;
                color: #bfdbfe;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }
        }
    </style>
</head>
<body>
<main>
    <section class="hero">
        <h1>{{ $serviceName }}</h1>
        <p>
            Microserviço de Blog/Notícias em Laravel, com CRUD de posts e categorias,
            filtros, paginação, health checks e estrutura preparada para autenticação JWT.
        </p>

        <table>
            <thead>
            <tr>
                <th>Método</th>
                <th>Rota</th>
                <th>Descrição</th>
                <th>Acesso</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($routes as $route)
                <tr>
                    <td data-label="Método"><span class="badge">{{ $route['method'] }}</span></td>
                    <td data-label="Rota"><code>{{ $route['uri'] }}</code></td>
                    <td data-label="Descrição">{{ $route['description'] }}</td>
                    <td data-label="Acesso">{{ $route['visibility'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</main>
</body>
</html>

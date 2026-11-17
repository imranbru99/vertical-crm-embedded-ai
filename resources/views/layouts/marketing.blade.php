<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $brand ?? 'Vertiq') — Vertical CRM with Embedded AI</title>
    <meta name="description" content="Vertical CRM with embedded AI for pipeline scoring, next-best actions, industry fields, and revenue workflows tailored to specialized businesses.">
    <style>
        :root { --accent: {{ $accent ?? '#4F46E5' }}; --ink:#0f172a; --muted:#64748b; --bg:#f8fafc; }
        * { box-sizing:border-box; } body{margin:0;font-family:ui-sans-serif,system-ui,Segoe UI,sans-serif;color:var(--ink);background:linear-gradient(180deg,#eef2ff 0%,var(--bg) 28%,#fff 100%);}
        a{color:var(--accent);text-decoration:none;} .wrap{max-width:1100px;margin:0 auto;padding:0 1.25rem;}
        header{display:flex;justify-content:space-between;align-items:center;padding:1.1rem 0;}
        .brand{font-weight:800;font-size:1.25rem;color:var(--ink);} .brand span{color:var(--accent);}
        nav a{margin-left:1rem;color:var(--muted);font-size:.95rem;} nav a:hover{color:var(--accent);}
        .hero{padding:3.5rem 0 2.5rem;} .hero h1{font-size:clamp(2rem,4vw,3rem);line-height:1.1;margin:0 0 1rem;}
        .hero p{color:var(--muted);font-size:1.1rem;max-width:42rem;} .cta{display:inline-flex;gap:.75rem;margin-top:1.5rem;flex-wrap:wrap;}
        .btn{background:var(--accent);color:#fff;padding:.75rem 1.15rem;border-radius:.65rem;font-weight:600;}
        .btn.ghost{background:#fff;color:var(--accent);border:1px solid #c7d2fe;}
        .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:1rem;padding:1rem 0 3rem;}
        .card{background:#fff;border:1px solid #e2e8f0;border-radius:1rem;padding:1.1rem;} .card h3{margin:.2rem 0 .4rem;font-size:1.05rem;}
        .card p{margin:0;color:var(--muted);font-size:.92rem;} .pill{display:inline-block;font-size:.75rem;padding:.2rem .5rem;border-radius:999px;background:#eef2ff;color:var(--accent);font-weight:700;}
        footer{padding:2rem 0 3rem;color:var(--muted);font-size:.9rem;border-top:1px solid #e2e8f0;margin-top:1rem;}
    </style>
</head>
<body>
<div class="wrap">
<header>
  <a class="brand" href="/">{{ $brand ?? 'Vertiq' }} <span>CRM</span></a>
  <nav>
    <a href="/features">Features</a>
    <a href="/modules">Modules</a>
    <a href="/pricing">Pricing</a>
    <a href="/security">Security</a>
    <a href="/demo">Demo</a>
    <a href="/admin">Admin</a>
  </nav>
</header>
@yield('content')
<footer>© {{ date('Y') }} Imran Ahmed · <a href="https://imrandev.bd">imrandev.bd</a> · Vertical CRM with Embedded AI</footer>
</div>
</body>
</html>
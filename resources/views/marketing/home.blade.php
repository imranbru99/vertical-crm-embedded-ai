@extends('layouts.marketing')
@section('title', $brand.' — Vertical CRM with Embedded AI')
@section('content')
<section class="hero">
  <p class="pill">Indigo AI · Pipeline scoring · Next-best actions</p>
  <h1>Vertical CRM with Embedded AI for specialized revenue teams</h1>
  <p>Pipeline scoring, next-best actions, industry fields, and revenue workflows — toggle only the modules your niche business needs.</p>
  <div class="cta">
    <a class="btn" href="/demo">Try the demo</a>
    <a class="btn ghost" href="/admin">Open admin</a>
  </div>
</section>
<section class="grid">
@foreach($modules as $key => $module)
  <div class="card">
    <span class="pill">{{ ($module['enabled'] ?? false) ? 'ON' : 'OFF' }}</span>
    <h3>{{ $module['name'] ?? $key }}</h3>
    <p>{{ $module['description'] ?? '' }}</p>
  </div>
@endforeach
</section>
@endsection
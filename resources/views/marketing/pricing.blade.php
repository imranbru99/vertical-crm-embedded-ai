@extends('layouts.marketing')
@section('title', 'Pricing')
@section('content')
<section class="hero">
    <h1>Pricing framed around recovered selling time</h1>
    <p>With {{ $enabledCount }} of {{ $moduleCount }} modules enabled, Vertiq models ~{{ $weeklyHours }} hours/week (~${{ number_format($weeklyValue) }} at $55/hr) back into pipeline work.</p>
</section>
<section class="section">
    <div class="grid">
        <article class="card"><h3>Starter</h3><p>Contacts, deals, pipeline, activities. Ideal for a single vertical boutique.</p></article>
        <article class="card"><h3>Growth</h3><p>Adds scoring AI, next-best actions, and vertical fields for multi-rep teams.</p></article>
        <article class="card"><h3>Enterprise</h3><p>Revenue workflows, catalog enrichment, attendance bridge, and custom SLAs.</p></article>
    </div>
</section>
@endsection

@extends('layouts.marketing')
@section('title', 'Security & Roles')
@section('content')
<section class="hero">
    <h1>Role gates and module accountability</h1>
    <p>Super Admin, Admin, Manager, Staff, Client, and Demo roles control admin access. Module toggles hide navigation and refuse resource access when disabled.</p>
</section>
<section class="section">
    <div class="grid">
        <article class="card"><h3>Admin panel</h3><p>Filament panel at <code>/admin</code> with indigo accent <code>#4F46E5</code> and policy-backed CRM resources.</p></article>
        <article class="card"><h3>Client portal</h3><p>Authenticated portal at <code>/portal</code> for opportunity visibility without full CRM seats.</p></article>
        <article class="card"><h3>Audit-friendly modules</h3><p>Module settings persist ON/OFF state so ops can prove which capabilities were live.</p></article>
    </div>
</section>
@endsection

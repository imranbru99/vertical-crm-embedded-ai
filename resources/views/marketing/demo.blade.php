@extends('layouts.marketing')
@section('title', 'Demo')
@section('content')
<section class="hero">
    <h1>Demo credentials</h1>
    <p>Seed the database, then sign in to the Filament admin to explore pipeline scoring and next-best actions.</p>
    <div class="card" style="max-width:420px;">
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>
        <p style="margin-top:1rem;"><a class="btn" href="/admin">Open /admin</a></p>
    </div>
</section>
@endsection

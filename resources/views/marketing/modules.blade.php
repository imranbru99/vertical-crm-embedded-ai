@extends('layouts.marketing')
@section('title','Modules')
@section('content')
<section class="hero"><h1>Toggleable modules</h1><p>Enable only what your specialized business needs — via .env, config, or Filament.</p></section>
<section class="grid">
@foreach($modules as $key => $module)
  <div class="card">
    <span class="pill">{{ $key }} · {{ ($module['enabled'] ?? false) ? 'ON' : 'OFF' }}</span>
    <h3>{{ $module['name'] ?? $key }}</h3>
    <p>{{ $module['description'] ?? '' }}</p>
  </div>
@endforeach
</section>
@endsection
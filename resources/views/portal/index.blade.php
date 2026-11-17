@extends('layouts.marketing')
@section('title', 'Client Portal')
@section('content')
<section class="hero">
    <h1>Opportunity portal</h1>
    <p>Hello {{ $user?->name ?? 'guest' }} — open deals visible to stakeholders.</p>
</section>
<section class="section">
    <table>
        <thead><tr><th>Deal</th><th>Company</th><th>Stage</th><th>Amount</th><th>AI Score</th></tr></thead>
        <tbody>
        @forelse($deals as $deal)
            <tr>
                <td>{{ $deal->name }}</td>
                <td>{{ $deal->company?->name }}</td>
                <td>{{ $deal->stage?->name }}</td>
                <td>${{ number_format((float) $deal->amount, 0) }}</td>
                <td>{{ $deal->ai_score ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No open deals yet. Run the demo seeder.</td></tr>
        @endforelse
        </tbody>
    </table>
</section>
@endsection

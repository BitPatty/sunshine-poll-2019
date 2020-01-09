@extends('partials.master')

@section('title', 'Super Mario Sunshine Timing Method Vote')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">Super Mario Sunshine</h1>
        <h2 class="subtitle">Timing Method Vote 2020</h2>
    </section>
    <section class="section">
        <p>{!! trans('poll.success') !!}</p>
        <br/>
        @include('partials.vote_summary', ['vote' => $vote])
    </section>
@endsection
@section('scripts')
@endsection

@extends('partials.master')

@section('title', 'Super Mario Sunshine Timing Method Vote')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">{{ trans('poll.title') }}</h1>
        <h2 class="subtitle">{{ trans('poll.subtitle') }}</h2>
    </section>
    <section class="section">
        <div class="notification is-warning has-text-centered">
            <ul>
                {{ trans('poll.closed') }}
            </ul>
        </div>
    </section>
@endsection
@section('scripts')
@endsection

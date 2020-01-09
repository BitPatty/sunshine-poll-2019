@extends('partials.master')

@section('title', 'Super Mario Sunshine Timing Method Vote')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">{{ trans('poll.title') }}</h1>
        <h2 class="subtitle">{{ trans('poll.subtitle') }}</h2>
    </section>
    <section class="section">
        @if($errors->any())
            <div class="notification is-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <p>{!! trans('poll.sections.custom_run.summary') !!}</p>
        @endif
    </section>
    <hr/>
    <section class="section">
        <form action="/submit" method="POST">
            @csrf
            @foreach($values as $key => $value)
                @if($key !== '_token')
                    <input type="hidden" name="{{ $key  }}" value="{{ $value }}"/>
                @endif
            @endforeach
            <input type="hidden" name="page_identifier" value="submit_custom_run"/>
            <div class="field">
                <label for="custom_run_url" class="label">Run URL</label>
                <div class="control">
                    <input id="custom_run_url" name="custom_run_url" class="input" type="text"
                           placeholder="{!! trans('poll.sections.custom_run.placeholder') !!}"
                           maxlength="80" @if(old('custom_run_url')) value="{{ old('custom_run_url') }}"
                           @elseif($custom_run_url) value="{{$custom_run_url}}" @endif>
                    <p>{!! trans('poll.sections.custom_run.description') !!}</p>
                </div>
            </div>
            <button class="button is-primary" type="submit">{!! trans('poll.submit') !!}</button>
        </form>
    </section>
@endsection
@section('scripts')
@endsection

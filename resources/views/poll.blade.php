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
            <div class="notification is-warning">
                This poll is not live yet! Votes will be reset!
            </div>
            <p>{!! trans('poll.voting_system') !!}</p>
            <br>
            <p>{!! trans('poll.voting_requirement') !!}</p>
            <br>
            <p>{!! trans('poll.preview_description') !!}</p>
            <br>
            <div class="container has-text-centered">
                <a href="/img/lb_preview.png" target="_blank">
                    <img class="is-inline-block" src="/img/lb_preview.png" alt="Leaderboard Preview"/>
                </a>
            </div>
        @endif
    </section>
    <hr/>
    <section class="section">
        <form action="/submit" method="POST">
            @csrf
            <div class="field">
                <label for="src_token" class="label">{!! trans('poll.sections.src_token.header') !!}</label>
                <div class="control">
                    <input id="src_token" name="src_token" class="input" type="text"
                           placeholder="{!! trans('poll.sections.src_token.placeholder') !!}" required
                           aria-required="true"
                           minlength="2" maxlength="30" @if(old('src_token')) value="{{ old('src_token') }}" @endif>
                </div>
                <p>{!! trans('poll.sections.src_token.description') !!}</p>
            </div>
            <div class="field">
                <label for="v_hide_timings" class="label">{!! trans('poll.sections.hide_timings.header') !!}</label>
                <div class="select is-fullwidth">
                    <select id="v_hide_timings" name="v_hide_timings" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_hide_timings') || old('v_hide_timings') === 'No Vote') selected @endif>{{ trans('poll.sections.hide_timings.options.no_vote') }}
                        </option>
                        <option value="Yes"
                                @if(old('v_hide_timings') === 'Yes') selected @endif>{{ trans('poll.sections.hide_timings.options.yes') }}</option>
                        <option value="No"
                                @if(old('v_hide_timings') === 'No') selected @endif>{{ trans('poll.sections.hide_timings.options.no') }}</option>
                    </select>
                </div>
                <p>{!! trans('poll.sections.hide_timings.description') !!}</p>
            </div>
            <div class="field">
                <label for="v_timing_method_a"
                       class="label">{!! trans('poll.sections.timing_method_a.header') !!}</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_a" name="v_timing_method_a" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_a') || old('v_timing_method_a') === 'No Vote') selected @endif>{{ trans('poll.sections.timing_method_a.options.no_vote') }}</option>
                        <option value="Yes"
                                @if(old('v_timing_method_a') === 'Yes') selected @endif>{{ trans('poll.sections.timing_method_a.options.yes') }}</option>
                        <option value="No"
                                @if(old('v_timing_method_a') === 'No') selected @endif>{{ trans('poll.sections.timing_method_a.options.no') }}</option>
                    </select>
                </div>
                <p>{!! trans('poll.sections.timing_method_a.description') !!}</p>
                <p>{!! trans('poll.sections.timing_method_a.sample') !!}</p>
            </div>
            <div class="field">
                <label for="v_timing_method_b"
                       class="label">{!! trans('poll.sections.timing_method_b.header') !!}</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_b" name="v_timing_method_b" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_b') || old('v_timing_method_b') === 'No Vote') selected @endif>{{ trans('poll.sections.timing_method_b.options.no_vote') }}</option>
                        <option value="Yes"
                                @if(old('v_timing_method_b') === 'Yes') selected @endif>{{ trans('poll.sections.timing_method_b.options.yes') }}</option>
                        <option value="No"
                                @if(old('v_timing_method_b') === 'No') selected @endif>{{ trans('poll.sections.timing_method_b.options.no') }}</option>
                    </select>
                </div>
                <p>{!! trans('poll.sections.timing_method_b.description') !!}</p>
                <p>{!! trans('poll.sections.timing_method_b.sample') !!}</p>
            </div>
            <div class="field">
                <label for="v_timing_method_c"
                       class="label">{!! trans('poll.sections.timing_method_c.header') !!}</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_c" name="v_timing_method_c" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_c') || old('v_timing_method_c') === 'No Vote') selected @endif>{{ trans('poll.sections.timing_method_c.options.no_vote') }}</option>
                        <option value="Yes"
                                @if(old('v_timing_method_c') === 'Yes') selected @endif>{{ trans('poll.sections.timing_method_c.options.yes') }}</option>
                        <option value="No"
                                @if(old('v_timing_method_c') === 'No') selected @endif>{{ trans('poll.sections.timing_method_c.options.no') }}</option>
                    </select>
                </div>
                <p>{!! trans('poll.sections.timing_method_c.description') !!}</p>
                <p>{!! trans('poll.sections.timing_method_c.sample') !!}</p>
            </div>
            <div class="field">
                <label for="v_timing_method_d"
                       class="label">{!! trans('poll.sections.timing_method_d.header') !!}</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_d" name="v_timing_method_d" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_d') || old('v_timing_method_d') === 'No Vote') selected @endif>{{ trans('poll.sections.timing_method_d.options.no_vote') }}</option>
                        <option value="Yes"
                                @if(old('v_timing_method_d') === 'Yes') selected @endif>{{ trans('poll.sections.timing_method_d.options.yes') }}</option>
                        <option value="No"
                                @if(old('v_timing_method_d') === 'No') selected @endif>{{ trans('poll.sections.timing_method_d.options.no') }}</option>
                    </select>
                </div>
                <p>{!! trans('poll.sections.timing_method_d.description') !!}</p>
            </div>
            <div class="field">
                <label for="comment" class="label">{!! trans('poll.sections.comment.header') !!}</label>
                <div class="control">
                    <textarea id="comment" name="comment" maxlength="1000" class="textarea" placeholder=""></textarea>
                </div>
                <p>{!! trans('poll.sections.comment.description') !!}</p>
            </div>
            <button class="button is-primary" type="submit">{{ trans('poll.submit') }}</button>
        </form>
    </section>
@endsection
@section('scripts')
@endsection

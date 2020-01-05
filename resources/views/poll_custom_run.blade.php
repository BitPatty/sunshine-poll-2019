@extends('partials.master')

@section('title', 'Super Mario Sunshine Timing Method Vote')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">Super Mario Sunshine</h1>
        <h2 class="subtitle">Timing Method Vote 2020</h2>
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
            <p> No runs found for your profile. You can submit a proof of you performing a run below, or submit again to
                skip this step. A previous SRL race or a video can be considered proof. If you feel you can prove you've
                done a run through another medium, feel free to put it here. If you can not prove you’ve run the game,
                you can still vote, but it will not be weighed when the poll is finished. Your vote has not been updated
                yet!</p>
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
                           placeholder="Link to one of your runs.."
                           maxlength="80" @if(old('custom_run_url')) value="{{ old('custom_run_url') }}"
                           @elseif($custom_run_url) value="{{$custom_run_url}}" @endif>
                    <p>Provide a URL to one of your runs/SRL races or skip this step by clicking 'Submit'.</p>
                </div>
            </div>
            <button class="button is-primary" type="submit">Submit</button>
        </form>
    </section>
@endsection
@section('scripts')
@endsection

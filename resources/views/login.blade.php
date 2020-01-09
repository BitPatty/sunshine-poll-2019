@extends('partials.master')

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
        @endif
        <h3>Verification Panel</h3>
        <p>Access to this area is restricted.</p>
        <form action="/auth" method="POST">
            @csrf
            <div class="field">
                <label for="src_token" class="label">Speedrun.com token</label>
                <div class="control">
                    <input id="src_token" name="src_token" class="input" type="text"
                           placeholder="Your speedrun.com token"
                           maxlength="80">
                    <p>The token is required to check your authorization. You can find your
                        token <a href="https://www.speedrun.com/api/auth" target="_blank" rel="noreferrer">here</a>.</p>
                </div>
            </div>
            <button class="button is-primary" type="submit">Submit</button>
        </form>
    </section>
@endsection
@section('scripts')
@endsection

@extends('partials.master')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">Super Mario Sunshine</h1>
        <h2 class="subtitle">Timing Method Vote 2020</h2>
        <span>Currently logged in as {{\Illuminate\Support\Facades\Auth::user()->src_name}}</span>
        (<a href="{{ url('logout') }}" title="Logout">Logout</a>)
    </section>
    @if(\App\Models\Flag::getByKey(\App\Models\Flags::IS_VERIFICATION_CLOSED)->value === true)
        <div class="notification is-warning">
            The verification process has been closed. Votes have been set to read-only and can no longer be verified or
            rejected.
        </div>
    @endif
    <section class="section">
        <div class="buttons has-text-right is-block">
            <a href="/manage" class="button is-primary is-inline-block">Manage Poll</a>
        </div>
        <table class="table is-striped is-fullwidth">
            <style>
                .compact {
                    padding: 3px 10px;
                    border-radius: 3px;
                }
            </style>
            <thead>
            <tr>
                <th>Speedrun.com Name</th>
                <th>Last Updated</th>
                <th>Verification State</th>
                <th>View Vote</th>
            </tr>
            </thead>
            <tbody>
            @foreach($votes as $vote)
                <tr>
                    <td>{{ $vote->user->src_name }}</td>
                    <td>{{ $vote->updated_at }} UTC</td>
                    @if($vote->state === \App\Models\VerificationState::PENDING)
                        <td><span class="notification is-danger is-light compact">{{ $vote->state }}</span></td>
                    @else
                        <td>{{ $vote->state }}</td>
                    @endif
                    <td><a href="/verification/{{$vote->id}}">View Vote</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
@section('scripts')
@endsection

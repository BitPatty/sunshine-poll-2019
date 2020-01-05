@extends('partials.master')

@section('title', 'Super Mario Sunshine Timing Method Vote')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">Super Mario Sunshine</h1>
        <h2 class="subtitle">Timing Method Vote 2020</h2>
        <a href="/verification" title="Back">Back to verification panel</a>
    </section>
    <section class="section">
        @if($privileged)
            <form method="POST" class="buttons has-text-right is-block">
                @csrf
                <button type="submit" name="res" value="verify" class="button is-success is-inline-block">Verify
                </button>
                <button type="submit" name="res" value="reject" class="button is-danger is-inline-block">Reject</button>
            </form>
        @endif
        @include('partials.vote_summary', ['vote' => $vote])
    </section>
    <section class="section">
        <h3 class="title is-3">Verification History</h3>
        @if($privileged)
            <table class="table is-striped is-fullwidth">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Verifier</th>
                    <th>Resolution</th>
                </tr>
                </thead>
                <tbody>
                @foreach($verification_history as $v)
                    <tr>
                        <td>{{ $v->created_at }} UTC</td>
                        <td>{{ $v->user->src_name }}</td>
                        <td>{{ $v->state }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <em>The verification history is only visible to moderators.</em>
        @endif
    </section>
    <section class="section">
        <h3 class="title is-3">Vote History</h3>
        @foreach($vote_history as $v)
            <div class="container">
                <h4 data-for="hist_{{$v->id}}" class="title is-4 collapse">{{ $v->created_at }}</h4>
                <table id="hist_{{$v->id}}" data-collapsable="true" class="table is-striped is-fullwidth collapsed">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Hide Timings:</td>
                        <td>{{ $v->v_hide_timings }}</td>
                    </tr>
                    <tr>
                        <td>Timing Method A:</td>
                        <td>{{ $v->v_timing_method_a }}</td>
                    </tr>
                    <tr>
                        <td>Timing Method B:</td>
                        <td>{{ $v->v_timing_method_b }}</td>
                    </tr>
                    <tr>
                        <td>Timing Method C:</td>
                        <td>{{ $v->v_timing_method_c }}</td>
                    </tr>
                    <tr>
                        <td>Timing Method D:</td>
                        <td>{{ $v->v_timing_method_d }}</td>
                    </tr>
                    <tr>
                        <td>Custom Run URL:</td>
                        <td>{{ $v->custom_run_url }}</td>
                    </tr>
                    <tr>
                        <td>Verification State:</td>
                        <td>{{ $v->state }}</td>
                    </tr>
                    <tr>
                        <td>Comment:</td>
                        <td>{{ $v->comment }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </section>
@endsection
@section('scripts')
    <script>
        function collapse($t) {

        }

        c = document.getElementsByClassName('collapse');

        for (let i = 0; i < c.length; i++) {
            c[i].addEventListener('click', function (e) {
                t = e.target.getAttribute('data-for');
                t = document.getElementById(t);
                t.classList.toggle('collapsed');
            })
        }
    </script>
@endsection

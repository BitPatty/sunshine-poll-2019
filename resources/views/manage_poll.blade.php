@extends('partials.master')

@section('content')
    <section class="section has-text-centered">
        <h1 class="title is-h1">Super Mario Sunshine</h1>
        <h2 class="subtitle">Timing Method Vote 2020</h2>
        <a href="/verification" title="Back">Back to verification panel</a>
    </section>
    <style>
        .poll_state
        .disabled {
            color: gray;
        }

        .poll_state ul li {
            margin: 20px 0px;
            padding-bottom: 20px;
            border-bottom: 1px solid lightgray;
        }

        .poll_state ul li .marker__wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .poll_state ul li .state_description {
            display: table-cell;
            vertical-align: middle;
            padding-left: 20px;
        }

        .marker {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: red;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .poll_state .done .marker {
            background-color: limegreen;
        }

        .poll_state .current .marker {
            background-color: dodgerblue;
        }

        .poll_state .disabled .marker {
            background-color: #636b6f;
        }

    </style>
    <section class="section poll_state">
        <ul>
            @if($state[\App\Models\Flags::IS_POLL_OPENED]->value === true)
                <li class="done">
                    <div class="marker__wrapper">
                        <figure class="marker">1</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Poll Opened</strong></p>
                        <p>
                            <small>The poll was opened and voting enabled.</small>
                        </p>
                        <p>
                            <small>{{ $state[\App\Models\Flags::IS_POLL_OPENED]->updated_at }}
                                by {{ $state[\App\Models\Flags::IS_POLL_OPENED]->modifiedBy->src_name }}
                            </small>
                        </p>
                    </div>
                </li>
            @else
                <li class="current">
                    <div class="marker__wrapper">
                        <figure class="marker">1</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Open the poll</strong></p>
                        <p>
                            <small>Open the poll and enables voting.</small>
                        </p>
                    </div>
                </li>
            @endif
            @if($state[\App\Models\Flags::IS_POLL_CLOSED]->value === true)
                <li class="done">
                    <div class="marker__wrapper">
                        <figure class="marker">2</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Poll Closed</strong></p>
                        <p>
                            <small>The poll was closed and voting disabled.</small>
                        </p>
                        <p>
                            <small>{{ $state[\App\Models\Flags::IS_POLL_CLOSED]->updated_at }}
                                by {{ $state[\App\Models\Flags::IS_POLL_CLOSED]->modifiedBy->src_name }}
                            </small>
                        </p>
                    </div>
                </li>
            @elseif($state[\App\Models\Flags::IS_POLL_OPENED]->value === true)
                <li class="current">
                    <div class="marker__wrapper">
                        <figure class="marker">2</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Close Poll</strong></p>
                        <p>
                            <small>Close the poll and disable voting.</small>
                        </p>
                    </div>
                </li>
            @else
                <li class="disabled">
                    <div class="marker__wrapper">
                        <figure class="marker">2</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Close Poll</strong></p>
                        <p>
                            <small>Close the poll and disable the voting.</small>
                        </p>
                        <p>
                            <small class="has-text-warning"><em>Requires the poll to be opened</em></small>
                        </p>
                    </div>
                </li>
            @endif
            @if($state[\App\Models\Flags::IS_VERIFICATION_CLOSED]->value === true)
                <li class="done">
                    <div class="marker__wrapper">
                        <figure class="marker">3</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Verification Closed</strong></p>
                        <p>
                            <small>Votes can no longer be verified or rejected.</small>
                        </p>
                        <p>
                            <small>{{ $state[\App\Models\Flags::IS_VERIFICATION_CLOSED]->updated_at }}
                                by {{ $state[\App\Models\Flags::IS_VERIFICATION_CLOSED]->modifiedBy->src_name }}</small>
                        </p>
                    </div>
                </li>
            @elseif($state[\App\Models\Flags::IS_POLL_CLOSED]->value === true)
                <li class="current">
                    <div class="marker__wrapper">
                        <figure class="marker">3</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Close Verification</strong></p>
                        <p>
                            <small>Close the verification process and mark all votes as read-only. Verifying/Rejecting
                                votes will no longer be possible.
                            </small>
                        </p>
                    </div>
                </li>
            @else
                <li class="disabled">
                    <div class="marker__wrapper">
                        <figure class="marker">3</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Close Verification</strong></p>
                        <p>
                            <small>Close the verification process and mark all votes as read-only. Verifying/Rejecting
                                votes will no longer be possible.
                            </small>
                        </p>
                        <p>
                            <small class="has-text-warning"><em>Requires the poll to be closed.</em></small>
                        </p>
                    </div>
                </li>
            @endif
            @if($state[\App\Models\Flags::IS_RESULT_PUBLIC]->value === true)
                <li class="done">
                    <div class="marker__wrapper">
                        <figure class="marker">4</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Published Results</strong></p>
                        <p>
                            <small>Results are publicly available at <a href="/results">/results</a>.</small>
                        </p>
                        <p>
                            <small>{{ $state[\App\Models\Flags::IS_RESULT_PUBLIC]->updated_at }}
                                by {{ $state[\App\Models\Flags::IS_RESULT_PUBLIC]->modifiedBy->src_name }}</small>
                        </p>
                    </div>
                </li>
            @elseif($state[\App\Models\Flags::IS_VERIFICATION_CLOSED]->value === true)
                <li class="current">
                    <div class="marker__wrapper">
                        <figure class="marker">4</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Publish Results</strong></p>
                        <p>
                            <small>Makes the results page publicly available.</small>
                        </p>
                    </div>
                </li>
            @else
                <li class="disabled">
                    <div class="marker__wrapper">
                        <figure class="marker">4</figure>
                    </div>
                    <div class="state_description">
                        <p><strong>Publish Results</strong></p>
                        <p>
                            <small>Makes the results page publicly available.</small>
                        </p>
                        <p>
                            <small class="has-text-warning"><em>Requires the verification to be closed.</em></small>
                        </p>
                    </div>
                </li>
            @endif
        </ul>
        @if($state[\App\Models\Flags::IS_RESULT_PUBLIC]->value === false && $privileged)
            <br>
            <div>
                <form method="POST" class="buttons is-block">
                    @csrf
                    @if($state[\App\Models\Flags::IS_POLL_OPENED]->value === false)
                        <button type="submit" name="res" value="open_poll" class="button is-primary is-inline-block">
                            Open Poll
                        </button>
                    @elseif($state[\App\Models\Flags::IS_POLL_CLOSED]->value === false)
                        <button type="submit" name="res" value="close_poll" class="button is-primary is-inline-block">
                            Close
                            Poll
                        </button>
                    @elseif($state[\App\Models\Flags::IS_VERIFICATION_CLOSED]->value === false)
                        @if($hasPendingVerifications === true)
                            <p>
                                <small class="has-text-danger"><em>Cannot close the verification while there are pending
                                        votes.</em></small>
                            </p>
                            <br>
                            <button type="submit" name="res" value="close_verification"
                                    class="button is-primary is-inline-block" disabled>Close
                                Verification
                            </button>
                        @else
                            <button type="submit" name="res" value="close_verification"
                                    class="button is-primary is-inline-block">Close
                                Verification
                            </button>
                        @endif
                    @elseif($state[\App\Models\Flags::IS_RESULT_PUBLIC]->value === false)
                        <button type="submit" name="res" value="publish_results"
                                class="button is-primary is-inline-block">
                            Publish Results
                        </button>
                    @endif
                </form>
                <p>
                    <small class="has-text-danger">Warning: This process cannot be undone.</small>
                </p>
            </div>
        @endif
    </section>

@endsection
@section('scripts')
@endsection

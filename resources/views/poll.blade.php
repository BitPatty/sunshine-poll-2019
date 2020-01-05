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
            <p><b>Voting system</b>: Everyone will be voting on whether or not they agree that a timing method should be
                allowed
                on the leaderboard, as well as specificities contained in that. Any and all timing methods that receive
                over
                50%
                approval will be allowed on the leaderboard. These changes will apply to all categories that currently
                start
                from a new file (Any%, 120 Shines, etc.). Note: File Select will always be allowed on the board,
                regardless
                of
                the poll results.</p>
            <br>
            <p>To be able to vote you need a <a href="https://speedrun.com" target="_blank"
                                                rel="noreferrer">speedrun.com</a>
                account. Votes from people with runs on the Super Mario Sunshine main or category extension leaderboards
                are
                automatically verified, while all other votes will go through a process of manual verification.
            </p>
            <br>
            <p>The different timing methods will be separated by variables on the leaderboard:</p>
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
                <label for="src_token" class="label">Speedrun.com Token</label>
                <div class="control">
                    <input id="src_token" name="src_token" class="input" type="text" placeholder="Your token.." required
                           aria-required="true"
                           minlength="2" maxlength="30" @if(old('src_token')) value="{{ old('src_token') }}" @endif>
                </div>
                <p>The token is required to verify your speedrun.com account. You can find your
                    token <a href="https://www.speedrun.com/api/auth" target="_blank" rel="noreferrer">here</a>.</p>
            </div>
            <div class="field">
                <label for="v_hide_timings" class="label">Hide Timings</label>
                <div class="select is-fullwidth">
                    <select id="v_hide_timings" name="v_hide_timings" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_hide_timings') || old('v_hide_timings') === 'No Vote') selected @endif>No
                            Vote
                        </option>
                        <option value="Yes" @if(old('v_hide_timings') === 'Yes') selected @endif>Yes</option>
                        <option value="No" @if(old('v_hide_timings') === 'No') selected @endif>No</option>
                    </select>
                </div>
                <p>The new timings should be hidden by default on the leaderboards.</p>
            </div>
            <div class="field">
                <label for="v_timing_method_a" class="label">Timing Method A</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_a" name="v_timing_method_a" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_a') || old('v_timing_method_a') === 'No Vote') selected @endif>
                            No Vote
                        </option>
                        <option value="Yes" @if(old('v_timing_method_a') === 'Yes') selected @endif>Yes</option>
                        <option value="No" @if(old('v_timing_method_a') === 'No') selected @endif>No</option>
                    </select>
                </div>
                <p>The file used is a premade file saved after having watched the FLUDD cutscene on airstrip. When
                    loading this file, the plane crash and FLUDD cutscene may be skipped. Runs that use this timing
                    method will start with 2:30.20 on the timer to account for skipped cutscenes.</p>
                <p>Sample: <a href="https://www.youtube.com/watch?v=cLhh4d4wZbw" target="_blank" rel="noreferrer">Youtube</a>
                </p>
            </div>
            <div class="field">
                <label for="v_timing_method_b" class="label">Timing Method B</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_b" name="v_timing_method_b" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_b') || old('v_timing_method_b') === 'No Vote') selected @endif>
                            No Vote
                        </option>
                        <option value="Yes" @if(old('v_timing_method_b') === 'Yes') selected @endif>Yes</option>
                        <option value="No" @if(old('v_timing_method_b') === 'No') selected @endif>No</option>
                    </select>
                </div>
                <p>Two premade files are used. One is saved after having watched the FLUDD cutscene on airstrip. The
                    second is saved after being loaded into delfino plaza. The player would load the first file, skip
                    the plane crash and FLUDD cutscenes, complete airstrip, reset (save prompt must appear before the
                    screen fades to black to be considered valid), then load the 2nd file and continue the run in
                    delfino, skipping the courtroom and officer's speech cutscenes. Runs that use this timing method
                    will start with 5:32.60 on the timer to account for skipped cutscenes.</p>
                <p>Sample: <a href="https://www.youtube.com/watch?v=CoAgno0ktjQ" target="_blank" rel="noreferrer">Youtube</a>
                </p>
            </div>
            <div class="field">
                <label for="v_timing_method_c" class="label">Timing Method C</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_c" name="v_timing_method_c" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_c') || old('v_timing_method_c') === 'No Vote') selected @endif>
                            No Vote
                        </option>
                        <option value="Yes" @if(old('v_timing_method_c') === 'Yes') selected @endif>Yes</option>
                        <option value="No" @if(old('v_timing_method_c') === 'No') selected @endif>No</option>
                    </select>
                </div>
                <p>A save file that has been pre-modified and loaded onto your memory card, having set the plane crash,
                    FLUDD, courtroom, and officer's speech cutscenes to watched, allowing them to be skipped. Runs that
                    use this timing method would start with 5:40.07 on the timer to account for skipped cutscenes.</p>
                <p>Sample: <a href="https://www.youtube.com/watch?v=iXBclBuSyew" target="_blank" rel="noreferrer">Youtube</a>
                </p>
            </div>
            <div class="field">
                <label for="v_timing_method_d" class="label">Timing Method D</label>
                <div class="select is-fullwidth">
                    <select id="v_timing_method_d" name="v_timing_method_d" required aria-required="true">
                        <option value="No Vote"
                                @if(!old('v_timing_method_d') || old('v_timing_method_d') === 'No Vote') selected @endif>
                            No Vote
                        </option>
                        <option value="Yes" @if(old('v_timing_method_d') === 'Yes') selected @endif>Yes</option>
                        <option value="No" @if(old('v_timing_method_d') === 'No') selected @endif>No</option>
                    </select>
                </div>
                <p>A save file that has been pre-modified and loaded onto your memory card, having set all cutscene
                    flags to watched (Exceptions: pinna 1 and pinna unlock cutscenes), allowing them to be skipped. Runs
                    that use this timing method would start with 7:07.50 on the timer to account for skipped
                    cutscenes.</p>
            </div>
            <div class="field">
                <label for="comment" class="label">Additional Comments</label>
                <div class="control">
                    <textarea id="comment" name="comment" maxlength="1000" class="textarea" placeholder=""></textarea>
                </div>
                <p>(Optional) This comment will only be visible to moderators and the poll committee.</p>
            </div>
            <button class="button is-primary" type="submit">Submit</button>
        </form>
    </section>
@endsection
@section('scripts')
@endsection

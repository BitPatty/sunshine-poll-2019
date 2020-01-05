<table class="table is-striped is-fullwidth">
    <thead>
    <tr>
        <th>Name</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>SRC ID:</td>
        <td>{{ $vote->user->src_id }}</td>
    </tr>
    <tr>
        <td>Name:</td>
        <td>{{ $vote->user->src_name }}</td>
    </tr>
    <tr>
        <td>Hide Timings:</td>
        <td>{{ $vote->v_hide_timings }}</td>
    </tr>
    <tr>
        <td>Timing Method A:</td>
        <td>{{ $vote->v_timing_method_a }}</td>
    </tr>
    <tr>
        <td>Timing Method B:</td>
        <td>{{ $vote->v_timing_method_b }}</td>
    </tr>
    <tr>
        <td>Timing Method C:</td>
        <td>{{ $vote->v_timing_method_c }}</td>
    </tr>
    <tr>
        <td>Timing Method D:</td>
        <td>{{ $vote->v_timing_method_d }}</td>
    </tr>
    <tr>
        <td>Custom Run URL:</td>
        <td>{{ $vote->custom_run_url }}</td>
    </tr>
    <tr>
        <td>Verification State:</td>
        <td>{{ $vote->state }}</td>
    </tr>
    <tr>
        <td>Comment:</td>
        <td>{{ $vote->comment }}</td>
    </tr>
    </tbody>
</table>

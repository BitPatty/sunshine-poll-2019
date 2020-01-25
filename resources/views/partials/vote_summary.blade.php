<table class="table is-striped is-fullwidth">
    <thead>
    <tr>
        <th>Name</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>SRC ID</td>
        <td>{{ $vote->user->src_id }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.username') }}</td>
        <td><a href="https://speedrun.com/user/{{ $vote->user->src_name }}" target="_blank"
               rel="noreferrer">{{ $vote->user->src_name }}</a></td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.hide_timings.header') }}</td>
        <td>{{ trans('poll.sections.hide_timings.options.' . str_replace(' ', '_', strtolower($vote->v_hide_timings))) }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.timing_method_a.header') }}</td>
        <td>{{ trans('poll.sections.timing_method_a.options.' . str_replace(' ', '_', strtolower($vote->v_timing_method_a))) }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.timing_method_b.header') }}</td>
        <td>{{ trans('poll.sections.timing_method_b.options.' . str_replace(' ', '_', strtolower($vote->v_timing_method_b))) }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.timing_method_c.header') }}</td>
        <td>{{ trans('poll.sections.timing_method_c.options.' . str_replace(' ', '_', strtolower($vote->v_timing_method_c))) }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.timing_method_d.header') }}</td>
        <td>{{ trans('poll.sections.timing_method_d.options.' . str_replace(' ', '_', strtolower($vote->v_timing_method_d))) }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.custom_run.header') }}</td>
        <td>{{ $vote->custom_run_url }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.verification_state.header') }}</td>
        <td>{{ trans('poll.verification_state.' . str_replace('-', '_', strtolower($vote->state))) }}</td>
    </tr>
    <tr>
        <td>{{ trans('poll.sections.comment.header') }}</td>
        <td>{{ $vote->comment }}</td>
    </tr>
    </tbody>
</table>

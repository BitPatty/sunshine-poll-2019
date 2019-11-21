@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE)
@section('subtitle', \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')
  <div class="p-1 text-center container">
    <h2>Verification Panel</h2>

    <div class="mb-5">
      <p>
        You can choose whether a vote of a user which isn't on the leaderboard should be verified (weighed) or
        not.
      </p>
    </div>

    <table class="table">
      <thead>
      <tr>
        <th>Verification</th>
        <th>Name</th>
        <th>Run URL</th>
        <th>Comment</th>
      </tr>
      </thead>
      <tbody>
      @foreach($votes as $vote)
        <tr>
          <td>
            <form action="/verification" method="POST">
              <input hidden name="auth_key" value="{{$auth_key}}">
              <input hidden name="user_id" value="{{$vote['src_id']}}">
              <input hidden name="set_state" value="{{$vote['is_verified'] == true ? '0' : '1'}}">
              <button
                class="w-100 btn btn-{{$vote['is_verified'] == true ? 'danger' : 'success'}}">{{$vote['is_verified'] == true ? 'Unverify' : 'Verify'}}
              </button>
            </form>
          </td>
          <td><a href="https://speedrun.com/user/{{$vote['src_name']}}" target="_blank"
                 rel="noreferrer">{{$vote['src_name']}}</a></td>
          <td>{{$vote['custom_run_url']}}</td>
          <td class="text-left">{{$vote['comment']}}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@endsection

@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE)
@section('subtitle', \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')
  <div
    class="p-1 text-center container"
  >
    <div>
      <!--
      <div class="mb-5">
        <h3><a href="/pre_poll">Pre-Poll</a></h3>
      </div>
      -->

      <div>
        <h3><a href="/main_poll">Main Poll</a></h3>
      </div>
    </div>
  </div>
@endsection

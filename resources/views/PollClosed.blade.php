@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE)
@section('subtitle', \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')
  <div
    class="p-1 text-center container"
  >
    <h1>The poll is closed!</h1>
@endsection

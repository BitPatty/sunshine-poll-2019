@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE)
@section('subtitle', \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')
  <div
    class="p-1 text-center container"
  >
    <div
      class="alert alert-danger"
      role="alert"
    >
      Poll not found!
    </div>
@endsection

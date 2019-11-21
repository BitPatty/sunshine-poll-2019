@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE)
@section('subtitle', \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')
  <div
    class="p-1 text-center container"
  >
    @isset($errorMessage)
      <div
        class="alert alert-danger"
        role="alert"
      >
        {{$errorMessage}}
      </div>
    @endisset


    <form
      action="{{$path}}"
      method="post"
    >
      <div
        class="form-group"
      >
        <label
          for="auth_key"
          class="h5 mb-3"
        >
          Authorization Token
        </label>
        <input
          type="password"
          name="auth_key"
          class="form-control"
          placeholder="Your token.."
          required
          aria-required="true"
        >
      </div>
      <button
        type="submit"
        class="btn btn-primary mb-5"
      >
        Submit
      </button>
    </form>
  </div>
@endsection

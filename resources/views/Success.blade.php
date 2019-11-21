@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE )
@section('subtitle', \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')
  <div class="p-1 text-center container">
    <div class="alert alert-success text-center" role="alert">
      Your vote has been registered
    </div>

    <div class="container mt-5">
      @foreach($listItems as $item)
        <div class="row mt-2">
          <div class="col-6 col-md-3 text-muted text-left">{{$item['name']}}</div>
          <div
            class="col text-left">{{ strlen(trim($item['value'] ?? '-')) === 0 ? '-' : trim($item['value']) }}</div>
        </div>
      @endforeach
    </div>

    <div class="alert alert-info text-center mt-5" role="alert">
      Changed your mind? Fill in <a href="/">the form</a> again to update your vote.
    </div>
  </div>
@endsection

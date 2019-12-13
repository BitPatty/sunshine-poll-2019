<div
  class="form-group mt-5"
>
  <label
    for="{{$question['id']}}"
    class="h5"
  >
    {{$question['title']}}
  </label>
  <textarea
    class="form-control"
    id="{{$question['id']}}"
    name="{{$question['id']}}"
    aria-describedby="{{$question['id']}}_help"
    rows="3"
  >
    {!! isset($selectedValue) ?
       htmlspecialchars($selectedValue, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES) : ""
    !!}
  </textarea>
  <small
    id="{{$question['id']}}_help"
    class="form-text text-muted"
  >
    {{ $question['description'] }}
  </small>
</div>

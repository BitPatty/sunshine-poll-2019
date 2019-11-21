<div
  class="form-group"
>
  <label
    for="{{$question['id']}}"
    class="h5"
  >
    {{$question['title']}}
  </label>
  <select
    class="form-control mt-1"
    id="{{$question['id']}}"
    name="{{$question['id']}}"
    aria-describedby="{{$question['id']}}_help"
    {!! $question['required'] ? 'required aria-required="true"' : "" !!}
  >

    @foreach($question['options'] as $option)
      <option
        value="{{$option['value']}}"
        {!!
          ((isset($selectedValue)
          && $option['value'] === $selectedValue)
          || $question['default'] === $option['value'])
          ? 'selected'
          : ""
        !!}
      >
        {{$option['label']}}
      </option>
    @endforeach

  </select>

  <small
    id="{{$question['id']}}_help"
    class="form-text text-muted mt-2"
  >
    {!! $question['description'] !!}
  </small>
</div>

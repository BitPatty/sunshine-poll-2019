@extends('partials.master')

@section('title', \App\Configuration\Common::PAGE_TITLE)
@section('subtitle',  \App\Configuration\Common::PAGE_SUBTITLE)

@section('content')

  @if(!isset($missingRun) && !isset($errorMessages))
  <div
    class="mb-5"
  >
      {!! \App\Configuration\Questions::getPoll($poll_id)['description'] !!}
  </div>
  @endif

  <hr>

  <form
    class="mt-5"
    action={{ '/' . $poll_id }}
      method="post"
  >
    @isset($errorMessages)
      @foreach($errorMessages as $message)
        <div
          class="alert alert-danger"
          role="alert"
        >
          {{$message}}
        </div>
      @endforeach
    @endisset

    @isset($infoMessages)
      @foreach($infoMessages as $message)
        <div
          class="alert alert-info"
          role="alert"
        >
          {{$message}}
        </div>
      @endforeach
    @endisset

    @isset($missingRun)
      @if($missingRun === true)
        <div class="form-group">
          <label
            for="custom_run_url"
            class="h5"
          >
            Your run
          </label>
          <input
            type="hidden"
            name="submitting_custom_run"
            value="1"
          />
          <input
            type="text"
            class="form-control"
            id="custom_run_url"
            aria-describedby="custom_run_url_help"
            name="custom_run_url"
            maxlength="90"
            max="90"
            value="{!!
              (isset($selectedValues) && isset($selectedValues['custom_run_url']))
              ? htmlspecialchars($selectedValues['custom_run_url'], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES)
              : "(no video)"
              !!}"
          />
          <small id=" custom_run_url_help" class="form-text text-muted">Provide a URL to one of your runs/SRL
            races or skip this step by clicking 'Submit'.
          </small>
        </div>
        <button type="submit" class="btn btn-primary mb-5">Submit</button>
      @endif
    @endisset


    <div class="form-group">
      <label for="src_token" class="h5">Speedrun.com Token</label>
      <input
        type="text"
        class="form-control"
        id="src_token"
        aria-describedby="src_token_help"
        name="src_token"
        placeholder="Your token.."
        min="5"
        minlength="5"
        max="30"
        maxlength="30"
        required
        aria-required="true"
        value="{!!
         isset($selectedValues) && isset($selectedValues['src_token'])
         ? htmlspecialchars($selectedValues['src_token'], ENT_COMPAT | ENT_HTML401 | ENT_QUOTES)
         : ""
         !!}"
      />

      <small id="src_token_help" class="form-text text-muted">The token is required to verify your speedrun.com
        account. You can find your token <a href="https://www.speedrun.com/api/auth" target="_blank"
                                            rel="noreferrer">here</a>.
      </small>
    </div>


    @foreach(\App\Configuration\Questions::getPoll($poll_id)['question_list'] as $question)

      @if($question['type'] === 'select')

        <hr
          class="mt-5 mb-5"
        />

        @include('partials.q_select', [
        'question' => $question,
        'selectedValue' =>  isset($selectedValues) ? $selectedValues[$question['id']] : \null
        ])

      @elseif($question['type'] === 'text')

        <hr
          class="mt-5 mb-5"
        />

        @include('partials.q_input', [
        'question' => $question,
        'selectedValue' =>  isset($selectedValues) ? $selectedValues[$question['id']] : \null
        ])

      @elseif($question['type'] === 'textbox')

        <hr
          class="mt-5 mb-5"
        />

        @include('partials.q_textbox', [
        'question' => $question,
        'selectedValue' =>  isset($selectedValues) ? $selectedValues[$question['id']] : \null
        ])

      @endif

    @endforeach

    <button
      type="submit"
      class="btn btn-primary mt-3"
    >
      Submit
    </button>
  </form>
@endsection

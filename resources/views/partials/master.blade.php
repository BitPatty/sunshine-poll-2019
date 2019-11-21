<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta
    charset="utf-8"
  />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no"
  />
  <meta
    http-equiv="X-UA-Compatible"
    content="IE=edge,chrome=1"
  />
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
    crossorigin="anonymous"
  >
  <script
    src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"
  ></script>
  <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"
  ></script>
  <title>@yield('title')</title>
  <style>
    body {
      text-align: center;
      padding-top: 80px;
    }

    .content__wrapper {
      text-align: left;
      width: 100%;
      max-width: 1000px;
      display: inline-block;;
    }
  </style>
</head>
<body
  class="bg-light p-2"
>
<header>
  <div
    class="position-relative overflow-hidden text-center bg-light"
  >
    <div
      class="col-md-5 mx-auto my-5"
    >
      <h1>
        @yield('title')
      </h1>
      <p
        class="lead font-weight-normal"
      >
        @yield('subtitle')
      </p>
    </div>
  </div>
</header>
<div
  class="content__wrapper"
>
  @yield('content')
</div>
@yield('scripts')
</body>

</html>

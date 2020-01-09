<!DOCTYPE HTML>
<html lang="{{ \Illuminate\Support\Facades\App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sunshine Timing Method Vote 2019."/>
    <meta name="revisit-after" content="30 days"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
    <link href="https://cdn.materialdesignicons.com/4.7.95/css/materialdesignicons.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
    <title>@yield('title')</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            padding: 15px;
        }

        .field {
            padding: 20px 5px;
        }

        .field .label {
            font-size: 1.1rem;
        }

        .field p {
            margin-top: 10px;
            color: #737373;
            padding: 0px 5px;
            font-size: .9rem;
        }

        .title.collapse {
            background: #5d5dbd;
            color: white;
            padding: 5px;
            cursor: pointer;
            border-radius: 3px;
            margin-bottom: 0;
        }

        .title.collapse:hover {
            background: #21238b;
        }

        .table.collapsed {
            visibility: collapse;
        }

        .table {
            margin-bottom: 20px;
        }

        td:first-child {
            width: 1px;
            white-space: nowrap;
        }
    </style>
</head>
<body class="is-widescreen">
<main class="container">
    @yield('content')
</main>
</body>
@yield('scripts')
</html>

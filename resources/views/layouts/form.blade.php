<!doctype html>
<html lang="{{ preference('lang', 'en') }}" data-bs-theme="{{ preference('theme', 'light') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (isset($title) ? "$title | " : '') . config('app.name') }}</title>
    <link href="/packages/bootstrap-5.3.1-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/packages/bootstrap-icons-1.11.0/bootstrap-icons.css" rel="stylesheet">
    <link href="/packages/sparksuite-simplemde-markdown-editor-6abda7a/dist/simplemde.min.css" rel="stylesheet">
    <script src="/packages/sparksuite-simplemde-markdown-editor-6abda7a/dist/simplemde.min.js"></script>
    <link href="/css/stylesheet.css" rel="stylesheet">
</head>

<body>
    <div class="p-2 sticky-top bg-{{ preference('theme') == 'dark' ? 'dark' : 'white' }}">
        <div class="d-flex align-items-center mx-auto" style="max-width: 32em">
            <a href="{{ request('back') ?? url()->previous() }}" class="btn border-0 btn-outline-{{ preference('theme') == 'dark' ? 'light' : 'dark' }}" title="Go back"><i
                    class="bi-chevron-left"></i></a>
            <h5 class="m-0 ms-2">{{ $title ?? '' }}</h5>
        </div>
    </div>
    <div class="container-fluid mx-auto" style="max-width: 32em">
        <div class="mt-3">
            @include('components.messages')
            @yield('content')
        </div>
        <div class="py-5"></div>
    </div>
    <script src="/packages/bootstrap-5.3.1-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

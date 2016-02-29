<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Test language</title>
  <link rel="stylesheet" href="">
</head>
<body>
  <h1>{{ trans('hello.welcome') }}</h1>
  @if ($lang == 'vi')
    <a href="{{ route('welcome.show', 'en') }}" title="">En</a>
  @else
    <a href="{{ route('welcome.show', 'vi') }}" title="">Vn</a>
  @endif
</body>
</html>
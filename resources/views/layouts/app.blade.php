<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    	<link rel="stylesheet" type="text/css" href={{asset('css/app.css')}}>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name' , 'LT')}}</title>
    </head>
    <body>
    	@include('inc.navbar')
    	<div class="container">
             @include('inc.messages')
       @yield('content')
   </div>
    </body>
</html>

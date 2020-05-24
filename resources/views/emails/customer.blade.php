<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sound Insights</title>
</head>
<body>
    <h1>{{ $details['subject'] }}</h1>
    <h4>{{ $details['name'] }}</h4>
    <p>{{$details['body']}}</p>
    <p>From: {{$details['email']}}</p>
</body>
</html> -->

@component('mail::message')
# {{$details['subject']}}

{{$details['body']}}

@component('mail::button', ['url' => config('app.url')])
Goto site
@endcomponent

From: {{$details['name']}}<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent

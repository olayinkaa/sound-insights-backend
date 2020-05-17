Hello {{$user->name}}
Thank you for creating an account with us. Please, verify your email using the link:
{{route('verify',$user->verification_token)}}
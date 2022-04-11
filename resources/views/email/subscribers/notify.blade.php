@component('mail::message')
# Hello, {{ $user->name }}

The website you have subscribed to, was submitted a new post with the following details:

👉 Title:  <strong>{{ $post->title }}</strong> <br>
👉 Description:{{ Str::limit($post->description, 150) }}

<br>

Please visit the website for more

@component('mail::button', ['url' => $post->website->url])
    Visit Website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

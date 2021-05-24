@extends('layouts.app')

@section('content')
<div class="container">
    
    <chat-component @if(Auth::check()) api_token = {{ Auth::user()->api_token}}  @endif></chat-component>
</div>
@endsection

@extends('emails.layout')

@section('title')
    Hello {{ $username }}
@stop

@section('content')
    You lost your password, this is an uniq link to generate a new password for you account <a href="http://cuisine.lahaxe.fr/#/changeLostPassword?token={{ $token }}&email={{ $email }}">. <br/>
    This link is valid 1 hour.
@stop
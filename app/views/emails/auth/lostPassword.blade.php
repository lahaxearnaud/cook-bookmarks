@extends('emails.layout')

@section('title')
    Hello {{ $username }}
@stop

@section('content')
    You lost your password, this is an uniq link to generate a new password for you account <a href="http://localhost:3333/#/lost/password/change?token={{ $token }}&email={{ $email }}">click here</a> <br/>
    This link is valid 1 hour.
@stop

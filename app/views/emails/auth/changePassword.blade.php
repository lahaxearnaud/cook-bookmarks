@extends('emails.layout')

@section('title')
    Hello {{ $username }}
@stop

@section('content')
    We signal you that your password was change. <br/>
    If you didn't change your password please use the lost my password feature to change your password again.
@stop
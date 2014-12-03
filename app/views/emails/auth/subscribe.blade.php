@extends('emails.layout')

@section('title')
    Hello {{ $username }}
@stop

@section('content')
    You just create a new cookbook online. <br/>
    You can access to your cookbook by clickin on <a href="http://cuisine.lahaxe.fr">this link</a>.
@stop

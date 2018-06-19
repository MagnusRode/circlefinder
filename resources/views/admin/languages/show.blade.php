@extends('admin.layouts.app')

@section('title', $item)

@section('content')
    

    <p>Code: {{ $item->code }}</p>
    <p>Title: {{ $item->title }}</p>

    @include('admin.inc.res-action', ['item' => $item, 'route_prefix' => 'admin.languages.'])
    
@endsection
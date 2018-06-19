@extends('admin.layouts.app')

@section('title', 'Edit ' . $item)

@section('content')
    @include('admin.languages.form', ['item' => $item])
@endsection
@extends('admin.layouts.app')

@if(is_trash_route())
@section('title', 'Trash: Languages')
@else
@section('title', 'Languages')
@endif

@section('content')
    @include('admin.inc.index-nav', ['route_prefix' => 'admin.languages.'])

    @if(count($items) > 0)

    @include('admin.inc.pagination')

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
        
        @foreach($items as $item)
        <tr class="item-{{ $item->id }}">
            <td class="align-middle">{{ $item->id }}</td>
            <td class="align-middle">{{ $item->code }}</td>
            <td class="align-middle"><a href="{{ route('admin.languages.show', ['id' => $item->id]) }}">{{ $item->title }}</a></td>
            <td>@include('admin.inc.res-action', ['item' => $item, 'route_prefix' => 'admin.languages.'])</td>
        </tr>
        @endforeach
    </table>
    
    @include('admin.inc.pagination')

    @else
        <p>No languages were found</p>
    @endif
@endsection
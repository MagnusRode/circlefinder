@if(isset($item))
    {!! Form::model($item, ['route' => ['admin.languages.update', 'id' => $item->id], 'method' => 'put']) !!}
@else
    {!! Form::open(['route' => 'admin.languages.store']) !!}
@endif

    <div class="form-group">
        {{ Form::label('code', 'Code') }}
        {{ Form::text('code', null, ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>
    
    @if(isset($item))
        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
    @else
        {{ Form::submit('Create', ['class' => 'btn btn-success']) }}
    @endif

@if(isset($item) && $item->trashed())
    <a href="{{ route('admin.languages.trash') }}" class="btn btn-light">Cancel</a>
@else
    <a href="{{ route('admin.languages.index') }}" class="btn btn-light">Cancel</a>
@endif

{!! Form::close() !!}
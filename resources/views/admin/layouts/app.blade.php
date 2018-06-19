@include('admin.inc.header')

<main class="py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a class="list-group-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="list-group-item" href="{{ route('admin.users.index') }}">Users</a>
                    <a class="list-group-item" href="{{ route('admin.roles.index') }}">Roles</a>
                    <a class="list-group-item" href="{{ route('admin.languages.index') }}">Languages</a>
                </div>
            </div>
            <div class="col-9">
                <h1>@yield('title')</h1>
                
                @include('admin.inc.messages')

                @yield('content')
            </div>
        </div>
    </div>
</main>

@include('admin.inc.footer')
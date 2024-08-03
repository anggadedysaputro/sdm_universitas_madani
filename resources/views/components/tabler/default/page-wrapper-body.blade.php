<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        @if (session('deniedmiddlewaremenu'))
        <div class="alert alert-{{ session('deniedmiddlewaremenu')['type'] }}">
            {{ session('deniedmiddlewaremenu')['alert'] }}
        </div>
        @endif
        <div class="row row-deck row-cards">
            @yield('content')
        </div>
    </div>
</div>

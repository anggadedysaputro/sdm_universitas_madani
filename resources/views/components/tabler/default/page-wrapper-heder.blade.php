<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle mb-3">
                    @yield('breadcrumb')
                </div>
                <h2 class="page-title">
                    @yield('page-title')
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    @yield('action-list')
                </div>
            </div>
        </div>
    </div>
</div>
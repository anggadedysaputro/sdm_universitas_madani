@extends('app')
@section('title')
    Title
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.masters.sub-unit.index"/>
@endsection
@section('page-title')
    Sub unit
@endsection
@section('action-list')
<a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasEnd" role="button" aria-controls="offcanvasEnd">
	<i class="ti ti-plus"></i> Tambah sub unit
</a>
@endsection
@section('search')
    <form action="./" method="get" autocomplete="off" novalidate>
        <div class="input-icon">
            <span class="input-icon-addon">
                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
            </span>
            <input type="text" value="" class="form-control" placeholder="Search…"
                aria-label="Search in website">
        </div>
    </form>
@endsection
@section('content')
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Input unit</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
		<div class="row">
			<div class="col-md-12">
				<div class="mb-3">
					<label class="form-label">Nama unit</label>
					<input type="text" class="form-control" name="example-password-input" placeholder="Input placeholder" fdprocessedid="tigmx5">
				</div>
			</div>
		</div>
		<div class="mt-3">
			<button class="btn btn-success" type="button"><i class="ti ti-send"></i> Simpan</button>
			<button class="btn btn-primary" type="button" data-bs-dismiss="offcanvas">
				Close offcanvas
			</button>
		</div>
    </div>
</div>
@endsection
@section('jsweb')
    <script type="module">

        class Helper {
            constructor(){
                
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel

            constructor() {
                super();
            }

            async serialLoadData() {

                // aturan penggunaan resolve
                // harus dipassing boolean
                // reject(true);

                // aturan penggunaan reject
                // harus di passing object dengan key alert
                // reject({alert:'bla bla..',});

                return new Promise((resolve, reject) => {
                    // // to code ajax first
                    resolve(true);
                    // Global.callAjax('{{ url('menu/show') }}', toastr, 'Loading data menu...').then((result)=>{
                    //     // console.log(Global.promiseResult(data.status));
                    //     resolve(result.status);
                    // }).catch((error)=>{
                    //     reject(error);
                    // });
                });
            }

            loadInjector(){
                return this;
            }

            loadMain() {
                return this;
            }

            bindEvent() {
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
                return this;
            }

            loadFinish() {
                return this;
            }

            startApp() {
                this.serialLoadData().then((res) => {
                    // toastr.clear();
                    // toastr.success('Seluruh data berhasil dimuat');
                    console.log('Seluruh data berhasil dimuat');
                    this.loadInjector().loadMain().loadDefaultValue().loadFinish().bindEvent().fireEvent();
                }).catch((error) => {
                    console.log(error);
                    // toastr.clear();
                    // toastr.error(error.responseJSON.message);
                    // console.log(error.responseJSON.message);
                });

                return this;
            }
        }

        $(document).ready(function() {
            window.Myapp = Index;
            new Myapp().startApp();
        });

    </script>
@endsection
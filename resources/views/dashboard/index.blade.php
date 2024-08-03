@extends('app')
@section('title')
    Dashboard
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="dashboard.index"/>
@endsection
@section('page-title')
    DASHBOARD
@endsection
@section('action-list')

@endsection
@section('search')
@endsection
@section('content')
    <div class="row row-deck row-cards">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <i class="ti ti-users-group"></i>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                      Jumlah Karyawan
                    </div>
                    <div class="text-secondary">
                        {{ $jumlahpegawai }}
                    </div>
                  </div>
                </div>
              </div>
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

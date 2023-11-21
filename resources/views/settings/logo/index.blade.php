@extends('app')
@section('title')
    Logo
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.logo.index"/>
@endsection
@section('page-title')
    Logo
@endsection
@section('action-list')
    {{-- <button>Add new</button> --}}
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
            <input type="text" value="" class="form-control" placeholder="Search…"aria-label="Search in website">
        </div>
    </form>
@endsection
@section('content')
<div class="d-flex justify-content-center">

    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
          
            <img id="image-logo" src="{{ asset('assets/ilustration/logo-default.png') }}" class="card-img-top" style="max-height: 100%; max-width:100%;">
          <div class="card-body">
            <div class="d-flex align-items-center">
                <input type="file" placeholder="Pilih logo" id="upload-logo">
              <a href="#" class="btn btn-sm text-secondary">
                <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                <i class="ti ti-send text-success"></i> Simpan
              </a>
              <a href="#" class="ms-3 btn btn-sm text-secondary">
                <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                <i class="ti ti-backspace text-danger"></i> Hapus
              </a>
            </div>
          </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Crop Image Before Upload</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="img-container">
                  <div class="row">
                      <div class="col-md-8">
                          <img src="" id="sample_image" />
                      </div>
                      <div class="col-md-4">
                          <div class="preview"></div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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

            shownModalEvent(){
                Index.CROPPER_Logo = new Cropper(document.getElementById('sample_image'), {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview:'.preview'
                });
            }

            hiddenModalEvent(){
                Index.CROPPER_Logo.destroy();
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static INPUT_UploadLogo;
            static CROPPER_Logo;
            static MD_CropperLogo;

            constructor() {
                super();
                Index.INPUT_UploadLogo = $('#upload-logo');
            //     Index.CROPPER_Logo = new Cropper(document.getElementById('sample_image'),{
            //         aspectRatio: 1,
            //         viewMode: 1
            //    });
               Index.MD_CropperLogo = $('#modal');
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
                Index.INPUT_UploadLogo.change(function(event){
                    let files = event.target.files;

                    let done = function(url){
                        $('#sample_image').attr('src',url);
                        Index.MD_CropperLogo.modal('show');
                    };

                    if(files && files.length > 0)
                    {
                        let reader = new FileReader();
                        reader.onload = function(event)
                        {
                            done(reader.result);
                        };
                        reader.readAsDataURL(files[0]);
                    }
                });

                Index.MD_CropperLogo.on('shown.bs.modal', this.shownModalEvent);
                Index.MD_CropperLogo.on('hidden.bs.modal', this.hiddenModalEvent);
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
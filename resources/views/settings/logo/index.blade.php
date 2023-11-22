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
    {{-- <form action="./" method="get" autocomplete="off" novalidate>
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
    </form> --}}
@endsection
@section('content')
<div class="d-flex justify-content-center">

    <div class="col-sm-6 col-lg-4">
        <div class="card card-sm">
            <form action="#" id="form-logo">
                <img id="image-logo" src="{{ empty($logo)?asset('assets/ilustration/logo-default.png'):asset('storage')."/".$logo}}" class="card-img-top" style="max-height: 100%; max-width:100%;">
                <input name="logo" type="hidden"/>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <input type="file" placeholder="Pilih logo" id="upload-logo">
                        <a href="#" class="btn btn-success text-white" id="simpan">
                            <i class="ti ti-send text-white"></i> Simpan
                        </a>
                        <a href="#" class="ms-3 btn btn-danger text-white">
                            <i class="ti ti-backspace text-white"></i> Hapus
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="modal">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title">Crop image</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">
					<div class="d-flex justify-content-center">
						<div style="height: 300px; width:500px;">
							<img id="sample_image">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		  <button type="button" class="btn btn-primary" id="crop">Crop</button>
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

            simpan(){
                var fd = new FormData();
                fd.append('file', Index.TMP_FileCropped);

                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin menyimpan data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('settings.logo.store') }}",
                            method : "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data : fd,
                            processData: false,
                            contentType: false,
                            beforeSend : function(){
                                Swal.fire({
                                    title: 'Menghapus data!',
                                    html: 'Silahkan tunggu...',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success : function(result){
                                Swal.fire({
                                    title : 'Berhasil',
                                    text : result.message,
                                    icon : 'success',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                });
                            },
                            error : function(){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }

            crop(){
                Index.MD_CropperLogo.modal('hide');
                Index.CROPPER_Logo.getCroppedCanvas({
                    minWidth:109,
                    minHeight:32
                }).toBlob((blob)=>{
                    let file = new File([blob], "angga.jpg");
                    let reader = new FileReader();
					
                    Index.TMP_FileCropped = file;
                    reader.readAsDataURL(blob); 
                    reader.onloadend = function() {
                        let base64data = reader.result;
                        $('#image-logo').attr('src',base64data);
                    }
                });
            }

            changeUpload(event){
                let files = event.target.files;
                let input = $(event.currentTarget);

                let done = function(url){
                    Index.MD_CropperLogo.modal('show');
                    Index.CROPPER_Logo.replace(url);
                };

                if(files && files.length > 0)
                {
                    let reader = new FileReader();
                    reader.onload = function(event)
                    {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                    input.val("");
                }
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static INPUT_UploadLogo;
            static CROPPER_Logo;
            static MD_CropperLogo;
            static BTN_Crop;
            static BTN_Simpan;
            static TMP_FileCropped;

            constructor() {
                super();
                Index.INPUT_UploadLogo = $('#upload-logo');
                Index.CROPPER_Logo = new Cropper(document.getElementById('sample_image'),{
                    dragMode: 'move',
					restore: false,
					guides: false,
					center: false,
					highlight: false,
					cropBoxMovable: false,
					cropBoxResizable: false,
					toggleDragModeOnDblclick: false,
					aspecRatio : 4 / 3
               });
               Index.MD_CropperLogo = $('#modal');
               Index.BTN_Crop = $('#crop');
               Index.BTN_Simpan = $('#simpan');
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
                Index.INPUT_UploadLogo.on('change', this.changeUpload);
                Index.BTN_Crop.on('click', this.crop);
                Index.BTN_Simpan.on('click', this.simpan);
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
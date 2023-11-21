@extends('app')
@section('title')
    Jabatan fungsional
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.masters.jabatan.fungsional.index"/>
@endsection
@section('page-title')
    fungsional
@endsection
@section('action-list')
<a id="tambah-fungsional" class="btn btn-primary" role="button">
	<i class="ti ti-plus"></i> Tambah fungsional
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
<div class="card p-3">
    <div class="card-table table-responsive">
        <table class="table table-vcenter" id="table-jabatan-fungsional">
            <thead>
            <tr>
                <th class="col-md-1 text-center">Kode jabatan fungsional</th>
                <th class="col-md-9 text-center">Urai</th>
                <th class="col-md-2 text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
                {{-- @foreach ($jabatan as $value)
                    <tr>
                        <td class="text-center">{{ $value->kodejabatanstruktural }}</td>
                        <td>{{ $value->urai }}</td>
                        <td class="text-center">
                            <button class="btn btn-danger"><i class="ti ti-trash-x"></i></button>
                            <button class="btn btn-warning"><i class="ti ti-edit-circle"></i></button>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
  </div>
<div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-jabatan">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Input fungsional</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="#" id="form-fungsional">
            <input type="hidden" id="id" name="id"/>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Nama fungsional</label>
                        <input type="text" class="form-control" name="urai" placeholder="Input nama fungsional" fdprocessedid="tigmx5" required>
                    </div>
                </div>
            </div>
        </form>
		<div class="mt-3">
			<button class="btn btn-success" type="button" id="simpan"><i class="ti ti-send"></i> Simpan</button>
			<button class="btn btn-primary" type="button" data-bs-dismiss="offcanvas" id="close-offcanvas">Batal</button>
		</div>
    </div>
</div>
@endsection
@section('jsweb')
    <script type="module">

        class Helper {
            constructor(){
                
            }

            tambah(){
                Index.BTN_Simpan.attr('mode','tambah');
                Myapp.OFFCNVS_Jabatan.show();
            }

            simpan(){
                let data = Index.FRM_Fungsional.serializeObject();
                let send = true;
                let mode = Index.BTN_Simpan.attr('mode');
                let text = (mode == 'edit' ? 'Anda ingin mengubah data?' : 'Anda ingin menyimpan data?');
                let url = (mode == 'edit' ? '{{ route('settings.masters.jabatan.fungsional.edit') }}' : '{{ route('settings.masters.jabatan.fungsional.store') }}');
                let method = (mode == 'edit' ? 'PATCH' : 'POST');
                let id = $('#id').val();
                
                $.each(Index.FRM_Fungsional[0].elements, function(i,e){
                    $(e).removeClass('is-invalid');
                    if( (e.nodeName == 'INPUT' || e.nodeName == 'SELECT') && e.type != 'hidden'){
                        let v = $(e).val() || '';

                        if(v == '' && e.hasAttribute('required')){
                            $(e).addClass('is-invalid');
                            send = false;
                        }
                    }
                });

                if(send){
                    Swal.fire({
                        title : 'Konfirmasi',
                        text,
                        icon : 'question',
                        showCancelButton : true,
                        cancelButtonText: 'Tidak',
                        confirmButtonText : 'Ya'
                    }).then((result)=>{
                        if(result.isConfirmed){
                            $.ajax({
                                url,
                                method,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data,
                                beforeSend : function(){
                                    Swal.fire({
                                        title: 'Menyimpan data!',
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
                                    }).then(()=>{
                                        Myapp.OFFCNVS_Jabatan.hide();
                                        Index.DT_Jabatan.draw();
                                    });
                                },
                                error : function(error){
                                    Swal.fire('Gagal',error.responseJSON.message,'error');
                                }
                            })
                        }
                    });
                }
            }

            static hapus(e){
                let data = $(e.currentTarget).data();
                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin menghapus data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('settings.masters.jabatan.fungsional.delete') }}",
                            method : "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data,
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
                                }).then(()=>{
                                    Index.DT_Jabatan.draw();
                                });
                            },
                            error : function(){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }

            static edit(e){
                let data = $(e.currentTarget).data();
                Index.BTN_Simpan.attr('mode','edit');
                Index.FRM_Fungsional.find('input[name="urai"]').val(data.urai);
                Index.FRM_Fungsional.find('input[name="id"]').val(data.kodejabatanfungsional);
                Index.OFFCNVS_Jabatan.show();
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static BTN_Simpan;
            static BTN_Tambah;
            static DT_Jabatan;
            static FRM_Fungsional;
            static OFFCNVS_Jabatan;

            constructor() {
                super();
                Index.BTN_Simpan=$('#simpan');
                Index.FRM_Fungsional=$('#form-fungsional');
                Index.BTN_Tambah=$('#tambah-fungsional');
                Index.DT_Jabatan=$("#table-jabatan-fungsional").DataTable({
                    ajax : {
                        url : "{{ route('settings.masters.jabatan.fungsional.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    processing : true,
                    serverSide : true,
                    columns : [
                        {data : "kodejabatanfungsional"},
                        {data : "urai"},
                        {
                            data : null,
                            defaultContent : `
                                <button class="btn btn-danger hapus"><i class="ti ti-trash-x"></i></button>
                                <button class="btn btn-warning edit"><i class="ti ti-edit-circle"></i></button>
                            `
                        }
                    ],
                    createdRow : function(row,data){
                        $(row).find('.hapus').on('click', Helper.hapus).data(data);
                        $(row).find('.edit').on('click', Helper.edit).data(data);
                    }
                });
                Index.OFFCNVS_Jabatan = new bootstrap.Offcanvas(document.getElementById('canvas-jabatan'));
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
                Index.BTN_Simpan.on('click', this.simpan);
                Index.BTN_Tambah.on('click',this.tambah);
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
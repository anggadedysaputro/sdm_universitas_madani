@extends('app')
@section('title')
    Konfig aplikasi
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.config-app.index"/>
@endsection
@section('page-title')
    KONFIG APLIKASI
@endsection
@section('action-list')
    <button class="btn btn-primary" id="tambah"><i class="ti ti-plus"></i>Tambah</button>
@endsection
@section('search')
@endsection
@section('content')
<div class="card p-3">
    <div class="card-body table-responsive">
        <table class="table table-vcenter table-bordered" id="table-main" style="width:100%;">
            <thead>
            <tr>
                <th class="col-md-1 text-center">Id konfig</th>
                <th class="col-md-3 text-center">Tahun</th>
                <th class="col-md-4 text-center">Urai</th>
                <th class="col-md-3 text-center">Aktif</th>
                <th class="col-md-1 text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-main">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Input konfig umum</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="#" id="form-main">
            <input type="hidden" class="form-control" name="id">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Id konfig umum</label>
                        <input type="text" class="form-control integer-mask" name="idkonfig" placeholder="Input id konfig" fdprocessedid="tigmx5" required readonly>
                        <div class="invalid-feedback">ID konfig umum belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" class="form-control integer-mask" name="tahun" placeholder="Input tahun" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Tahun belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Urai</label>
                        <input type="text" class="form-control" name="urai" placeholder="Input urai" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Urai belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <div class="form-label">Status</div>
                        <div>
                          <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="aktif">
                            <span class="form-check-label">aktif</span>
                          </label>
                        </div>
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
<div class="modal" tabindex="-1" id="modal-konfig-umum">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfig umum</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body table-responsive">
            <table class="table table-bordered display responsive" id="table-konfig-umum" style="width:100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-md-1 text-center">Id konfig umum</th>
                        <th class="col-md-1 text-center">Masuk</th>
                        <th class="col-md-1 text-center">Pulang</th>
                        <th class="col-md-2 text-center">Lokasi</th>
                        <th class="col-md-2 text-center">Masuk puasa</th>
                        <th class="col-md-1 text-center">Pulang puasa</th>
                        <th class="col-md-1 text-center">Tanggal awal puasa</th>
                        <th class="col-md-1 text-center">Tanggal akhir puasa</th>
                        <th class="col-md-1 text-center">Cuti</th>
                        <th class="col-md-1 text-center">Hari libur</th>
                    </tr>
                </thead>
            </table>
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

            static clear(){
                Index.FRM_Main[0].reset();
            }

            selectKonfigUmum(e, dt, type, indexes){
                if (type === 'row') {
                    var data = Index.DT_KonfigUmum.rows(indexes).data()[0];
                    Index.FRM_Main.find("input[name='idkonfig']").val(data.idkonfigumum);
                    Index.MD_KonfigUmum.modal("hide");
                }
            }

            showKonfigUmum(){
                Myapp.DT_KonfigUmum.rows().deselect();
                Index.MD_KonfigUmum.modal("show");
            }

            tambah(){
                Helper.clear();
                Index.BTN_Simpan.attr('mode','tambah');
                Index.OFFCNVS_Main.show();
            }

            simpan(){
                let data = Index.FRM_Main.serializeObject();
                let send = true;
                let mode = Index.BTN_Simpan.attr('mode');
                let text = (mode == 'edit' ? 'Anda ingin mengubah data?' : 'Anda ingin menyimpan data?');
                let url = (mode == 'edit' ? '{{ route('settings.config-app.edit') }}' : '{{ route('settings.config-app.store') }}');
                let method = (mode == 'edit' ? 'PATCH' : 'POST');
                let id = $('#id').val();

                $.each(Index.FRM_Main[0].elements, function(i,e){
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
                                        Myapp.OFFCNVS_Main.hide();
                                        Index.DT_Main.draw();
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
                            url : "{{ route('settings.config-app.delete') }}",
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
                                    Index.DT_Main.draw();
                                });
                            },
                            error : function(error){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }

            static edit(e){
                let data = $(e.currentTarget).data();
                Index.BTN_Simpan.attr('mode','edit');
                $.each(Index.FRM_Main[0].elements, function(i,e){
                    if($(e).hasClass("flatpicker-date")){
                        e._flatpickr.setDate(data[e.name]);
                    }else if(e.type == "checkbox"){
                        $(e).prop("checked",data[e.name]);
                    }else{
                        $(e).val(data[e.name]);
                    }
                });

                Index.OFFCNVS_Main.show();
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static BTN_Simpan;
            static BTN_Tambah;
            static DT_Main;
            static FRM_Main;
            static DATA_Menu;
            static MD_KonfigUmum;
            static OFFCNVS_Main;
            static DT_KonfigUmum;

            constructor() {
                super();
                Index.MD_KonfigUmum = $('#modal-konfig-umum');
                Index.BTN_Simpan=$('#simpan');
                Index.FRM_Main=$('#form-main');
                Index.BTN_Tambah=$('#tambah');

                Index.DT_KonfigUmum = $('#table-konfig-umum').DataTable({
                    ajax : {
                        url : "{{ route('settings.konfig-umum.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columnDefs: [
                        {
                            orderable: false,
                            className: 'select-checkbox',
                            targets: 0
                        }
                    ],
                    select: {
                        style: 'os',
                        selector: 'td:first-child',
                        headerCheckbox: false
                    },
                    processing : true,
                    serverSide : true,
                    columns : [
                        {data : null, defaultContent:"", orderable:false, searchable:false},
                        {data : "idkonfigumum"},
                        {data : "masuk"},
                        {data : "pulang"},
                        {data : "lokasidef"},
                        {data : "masukpuasa"},
                        {data : "pulangpuasa"},
                        {data : "tanggalawalpuasa"},
                        {data : "tanggalakhirpuasa"},
                        {data : "defcuti"},
                        {data : "harilibur"}
                    ]

                });

                Index.DT_Main=$("#table-main").DataTable({
                    ajax : {
                        url : "{{ route('settings.config-app.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    processing : true,
                    serverSide : true,
                    columns : [
                        {data : "idkonfig"},
                        {data : "tahun"},
                        {data : "urai"},
                        {data : "aktif"},
                        {
                            data : null,
                            defaultContent : `
                                <button class="btn btn-danger btn-sm hapus"><i class="ti ti-trash-x"></i></button>
                                <button class="btn btn-warning btn-sm edit"><i class="ti ti-edit-circle"></i></button>
                            `
                        }
                    ],
                    createdRow : function(row,data){
                        $(row).find('.hapus').on('click', Helper.hapus).data(data);
                        $(row).find('.edit').on('click', Helper.edit).data(data);
                    }
                });
                Index.OFFCNVS_Main = new bootstrap.Offcanvas(document.getElementById('canvas-main'));
                flatpickr('.flatpicker-time',{
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });
                flatpickr('.flatpicker-date',{
                    disableMobile: "true",
                    dateFormat: "j F Y",
                });
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
                Index.FRM_Main.find("input[name='idkonfig']").on('click', this.showKonfigUmum);
                Index.DT_KonfigUmum.on('select', this.selectKonfigUmum);
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

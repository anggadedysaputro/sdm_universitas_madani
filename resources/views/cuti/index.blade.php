@extends('app')
@section('title')
    Cuti
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="cuti.index"/>
@endsection
@section('page-title')
    Cuti
@endsection
@section('action-list')
    <button class="btn btn-primary" id="tambah"><i class="ti ti-plus"></i> Tambah</button>
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
        <table class="table table-bordered table-vcenter" id="table-main" style="width:100%;">
            <thead>
                <tr>
                    <th class="col-md-1 text-center">Id</th>
                    <th class="col-md-2 text-center">Nomor pegawai</th>
                    <th class="col-md-2 text-center">Tanggal awal</th>
                    <th class="col-md-2 text-center">Tanggal akhir</th>
                    <th class="col-md-2 text-center">Keterangan</th>
                    <th class="col-md-1 text-center">Jumlah</th>
                    <th class="col-md-1 text-center">Sisa</th>
                    <th class="col-md-1 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal" tabindex="-1" id="modal-main">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulir cuti</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#" id="form-main">
            <input type="hidden" name="id">
            <div class="mb-3">
                <label for="tanggalawal" class="form-label">Tanggal awal</label>
                <input type="text" class="form-control flat-picker" id="tanggalawal" placeholder="Input tanggal awal" name="tgl_akhir" required>
                <div class="invalid-feedback">Tanggal awal belum diisi!</div>
              </div>
              <div class="mb-3">
                <label for="tanggalakhir" class="form-label">Tanggal akhir</label>
                <input type="text" class="form-control flat-picker" id="tanggalakhir" placeholder="Input tanggal akhir" name="tgl_awal" required>
                <div class="invalid-feedback">Tanggal akhir belum diisi!</div>
              </div>
              <label for="jumlahcuti" class="form-label">Jumlah cuti</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control integer-mask" id="jumlahcuti" placeholder="Input jumlah cuti" name="jumlah" required>
                <span class="input-group-text" id="basic-addon2">Sisa cuti ({{ $sisacuti }})</span>
                <div class="invalid-feedback">Jumlah cuti belum diisi!</div>
              </div>
              <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" placeholder="Input keterangan" name="keterangan" required></textarea>
                <div class="invalid-feedback">Keterangan belum diisi!</div>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" id="simpan">Simpan</button>
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

            hitungCuti(e){
                const jumlah = $(e.currentTarget).val();
                if(parseInt(jumlah) > parseInt(Index.DATA_SisaCuti)) $(e.currentTarget).val(Index.DATA_SisaCuti);
            }

            tambah(){
                Helper.clearForm();
                Index.MD_Main.modal('show');
                Index.BTN_Simpan.attr('mode','add');
            }

            simpan(){

                if(Angga.validate(Index.FRM_Main, Index.MD_Main, Index.MD_Main.find('.modal-body'))){

                    Swal.fire({
                        title : 'Konfirmasi',
                        text : 'Apakah anda yakin ingin menyimpan data?',
                        icon : 'question',
                        showCancelButton : true,
                        cancelButtonText: 'Tidak',
                        confirmButtonText : 'Ya'
                    }).then((result)=>{
                        if(result.isConfirmed){
                            let formData = Index.FRM_Main.serializeObject();
                            let mode = Index.BTN_Simpan.attr('mode');
                            let text = (mode == 'edit' ? 'Anda ingin mengubah data?' : 'Anda ingin menyimpan data?');
                            let url = (mode == 'edit' ? '{{ route('cuti.edit') }}' : '{{ route('cuti.store') }}');
                            let method = (mode == 'edit' ? 'PATCH' : 'POST');
                            $.ajax({
                                url,
                                method,
                                data : formData,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
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
                                        Index.MD_Main.modal('hide');
                                        Index.DT_Main.ajax.reload();
                                    });
                                },
                                error : function(error){
                                    Swal.fire('Gagal',error.responseJSON.message,'error');
                                }
                            });
                        }
                    });
                }
            }

            static clearForm(){
                Index.FRM_Main[0].reset();
            }

            static hapus(e){
                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin menghapus data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        let formData = $(e.currentTarget).data();
                        $.ajax({
                            url : "{{ route('cuti.delete') }}",
                            method : "DELETE",
                            data : formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
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
                                    Index.DT_Main.ajax.reload();
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
                const data = $(e.currentTarget).data();
                Helper.clearForm();
                Index.BTN_Simpan.attr('mode','edit');

                $.each(Index.FRM_Main[0].elements, function(i,e){
                    if($(e).hasClass("flat-picker")){
                        e._flatpickr.setDate(data[e.name].replace(/\s\s+/g, ' '));
                    }else{
                        $(e).val(data[e.name]);
                    }
                });

                Index.MD_Main.modal("show");
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static MD_Main;
            static BTN_Tambah;
            static BTN_Simpan;
            static FRM_Main;
            static DATA_SisaCuti;
            static DT_Main;

            constructor() {
                super();
                Index.MD_Main = $('#modal-main');
                Index.BTN_Tambah = $('#tambah');
                Index.FRM_Main = $('#form-main');
                flatpickr('.flat-picker',{
                    disableMobile: "true",
                    dateFormat: "j F Y",
                });
                Index.BTN_Simpan = $('#simpan');
                Index.DATA_SisaCuti = "{{ $sisacuti }}";
                Index.DT_Main=$("#table-main").DataTable({
                    ajax : {
                        url : "{{ route('cuti.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    processing : true,
                    serverSide : true,
                    columns : [
                        {data : "id"},
                        {data : "nopeg"},
                        {data : "tgl_awal"},
                        {data : "tgl_akhir"},
                        {data : "keterangan"},
                        {data : "jumlah"},
                        {data : "sisa"},
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
                Index.BTN_Tambah.on('click', this.tambah);
                Index.BTN_Simpan.on('click', this.simpan);
                Index.FRM_Main.find("input[name='jumlah']").on('change', this.hitungCuti);
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
                Index.BTN_Simpan.attr('mode','add');
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

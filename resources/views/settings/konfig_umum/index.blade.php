@extends('app')
@section('title')
    Konfig umum
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.konfig-umum.index"/>
@endsection
@section('page-title')
    KONFIG UMUM
@endsection
@section('action-list')
    <button class="btn btn-primary" id="tambah"><i class="ti ti-plus"></i>Tambah</button>
@endsection
@section('search')
@endsection
@section('content')
<div class="card p-3">
    <div class="card-table table-responsive">
        <table class="table table-vcenter" id="table-main" style="width:100%;">
            <thead>
            <tr>
                <th class="col-md-1 text-center">Id konfig umum</th>
                <th class="col-md-1 text-center">Masuk</th>
                <th class="col-md-1 text-center">Pulang</th>
                <th class="col-md-1 text-center">Masuk puasa</th>
                <th class="col-md-1 text-center">Pulang puasa</th>
                <th class="col-md-1 text-center">Tanggal awal puasa</th>
                <th class="col-md-1 text-center">Tanggal akhir puasa</th>
                <th class="col-md-1 text-center">Cuti</th>
                <th class="col-md-1 text-center">Hari libur</th>
                <th class="col-md-1 text-center">Tanggal awal bulan</th>
                <th class="col-md-1 text-center">Tanggal akhir bulan</th>
                <th class="col-md-1 text-center">Radius (M)</th>
                <th class="col-md-1 text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="offcanvas offcanvas-end" aria-labelledby="offcanvasEndLabel" id="canvas-main" data-trap-focus="false">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Input konfig umum</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="#" id="form-main">
            <input type="hidden" class="form-control" name="idkonfigumum">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Jam masuk</label>
                        <input type="text" class="form-control flatpicker-time" name="masuk" placeholder="Input jam masuk" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Jam masuk belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Jam pulang</label>
                        <input type="text" class="form-control flatpicker-time" name="pulang" placeholder="Input jam pulang" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Jam pulang belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Jam masuk puasa</label>
                        <input type="text" class="form-control flatpicker-time" name="masukpuasa" placeholder="Input jam masuk puasa" fdprocessedid="tigmx5">
                        <div class="invalid-feedback">Jam masuk belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Jam pulang puasa</label>
                        <input type="text" class="form-control flatpicker-time" name="pulangpuasa" placeholder="Input jam pulang puasa" fdprocessedid="tigmx5">
                        <div class="invalid-feedback">Jam pulang puasa belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Tanggal awal puasa</label>
                        <input type="text" class="form-control flatpicker-date" name="tanggalawalpuasa" placeholder="Input Tanggal awal puasa" fdprocessedid="tigmx5">
                        <div class="invalid-feedback">Tanggal awal puasa belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Tanggal akhir puasa</label>
                        <input type="text" class="form-control flatpicker-date" name="tanggalakhirpuasa" placeholder="Input Tanggal akhir puasa" fdprocessedid="tigmx5">
                        <div class="invalid-feedback">Tanggal akhir puasa belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Jumlah cuti</label>
                        <input type="text" class="form-control integer-mask" name="defcuti" placeholder="Input jumlah cuti" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Jumlah cuti belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Hari libur</label>
                        <select class="form-select" name="harilibur">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jum'at">Jum'at</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                        <div class="invalid-feedback">Jumlah cuti belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Tanggal awal bulan</label>
                        <input type="text" class="form-control integer-mask" name="tglawalbulan" placeholder="Input tanggal awal bulan" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Tanggal awal bulan belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Tanggal akhir bulan</label>
                        <input type="text" class="form-control integer-mask" name="tglakhirbulan" placeholder="Input tanggal akhir bulan" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Tanggal akhir bulan belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Radius (M)</label>
                        <input type="text" class="form-control integer-mask" name="radius" placeholder="Input radius" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Radius belum diisi</div>
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

            static clear(){
                Index.FRM_Main[0].reset();
            }

            static removeLokasi(e){
                $(e.currentTarget).parents('.mb-3:first').remove();
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
                let url = (mode == 'edit' ? '{{ route('settings.konfig-umum.edit') }}' : '{{ route('settings.konfig-umum.store') }}');
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
                            url : "{{ route('settings.konfig-umum.delete') }}",
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
                // decode semua value string di data
                for (let k in data) {
                    if (typeof data[k] === 'string') {
                        data[k] = data[k]
                            .replace(/&quot;/g, '"')
                            .replace(/&#039;/g, "'")
                            .replace(/&apos;/g, "'")
                            .replace(/&amp;/g, '&')
                            .replace(/&lt;/g, '<')
                            .replace(/&gt;/g, '>');
                    }
                }

                let latlong = JSON.parse(data.latlong.replace(/&quot;/g,'"'));
                Index.OFFCNVS_Main.show();
                Index.BTN_Simpan.attr('mode','edit');
                $.each(Index.FRM_Main[0].elements, function(i,e){
                    if($(e).hasClass("flatpicker-date")){
                        e._flatpickr.setDate(data[e.name]);
                    }else{
                        $(e).val(data[e.name]);
                    }
                });
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static BTN_Simpan;
            static BTN_Tambah;
            static DT_Main;
            static FRM_Main;
            static DATA_Menu;
            static OFFCNVS_Main;
            static FLATPICKR_Date;
            static BTN_TambahLokasi;

            constructor() {
                super();
                Index.MAPS_LatLong = [-7.84338, 110.44319];
                Index.BTN_TerapkanMaps = $('#terapkan-maps');
                Index.BTN_Simpan=$('#simpan');
                Index.FRM_Main=$('#form-main');
                Index.BTN_Tambah=$('#tambah');
                Index.BTN_TambahLokasi = $('#tambah-lokasi');
                Index.DT_Main=$("#table-main").DataTable({
                    ajax : {
                        url : "{{ route('settings.konfig-umum.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    processing : true,
                    serverSide : true,
                    columns : [
                        {data : "idkonfigumum"},
                        {data : "masuk"},
                        {data : "pulang"},
                        {data : "masukpuasa"},
                        {data : "pulangpuasa"},
                        {data : "tanggalawalpuasa"},
                        {data : "tanggalakhirpuasa"},
                        {data : "defcuti"},
                        {data : "harilibur"},
                        {data : "tglawalbulan"},
                        {data : "tglakhirbulan"},
                        {data : "radius"},
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
                    minuteIncrement: 1,
                    time_24hr: true
                });
                Index.FLATPICKR_Date = flatpickr('.flatpicker-date',{
                    disableMobile: "true",
                    dateFormat: "j F Y",
                    static : true,
                    onOpen: [
                        function(selectedDates, dateStr, instance){
                            let value = instance._input.value || flatpickr.formatDate(new Date(), "j F Y");
                            instance.setDate(value);
                        },
                    ]
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
                $('#loading-search-maps').hide();
                return this;
            }

            bindEvent() {
                Index.BTN_Simpan.on('click', this.simpan);
                Index.BTN_Tambah.on('click',this.tambah);
                Index.BTN_TambahLokasi.on('click',Helper.tambahLokasi);
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
                Index.FLATPICKR_Date.forEach(element => {
                    element.setDate("8 August 2024");
                });
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

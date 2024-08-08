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
                <th class="col-md-1 text-center">Lokasi</th>
                <th class="col-md-1 text-center">Masuk puasa</th>
                <th class="col-md-1 text-center">Pulang puasa</th>
                <th class="col-md-1 text-center">Tanggal awal puasa</th>
                <th class="col-md-1 text-center">Tanggal akhir puasa</th>
                <th class="col-md-1 text-center">Cuti</th>
                <th class="col-md-1 text-center">Hari libur</th>
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
                        <label class="form-label">Lokasi <button type="button" id="tambah-lokasi" class="btn btn-sm btn-success"><i class="ti ti-plus"></i></button></label>
                        <div id="wrapper-lokasi-input"></div>
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
<div class="modal" tabindex="-1" id="modal-tambahlokasi">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Maps</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="#" id="form-maps">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
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
                                <input type="text" value="" name="search" class="form-control" placeholder="Search…" aria-label="Search in website">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center" id="loading-search-maps">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <ul class="list-group">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label>Pilih lokasi</label>
                            <div id="render-map" style="width: 100%; min-height:50vh;"></div>
                            <input type="text" class="form-control" name="latlong" placeholder="Ex : -7.841313293355481, 110.43993586602298" fdprocessedid="tigmx5" required>
                            <div class="invalid-feedback">Lokasi belum dipilih</div>
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
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="terapkan-maps">Terapkan</button>
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

            static clearMaps(){
                Index.FRM_Maps[0].reset();
                Index.LFT_Lokasi.setView(new L.LatLng(Index.MAPS_LatLong[0], Index.MAPS_LatLong[1]), 17);
                Index.LFT_LokasiMarker.setLatLng(Index.MAPS_LatLong);
            }

            searchLocation(e) {
                let keyword = $(e.currentTarget).val();
                if(keyword) {
                    $('#loading-search-maps').show();
                    fetch(`https://nominatim.openstreetmap.org/search?q=${keyword}&format=json`)
                    .then((response) => {
                        return response.json()
                    }).then(json => {
                        // get response data from nominatim
                        $('#loading-search-maps').hide();
                        if(json.length > 0) return Helper.renderResults(json)
                        else alert("lokasi tidak ditemukan")
                    });
                }else{
                    $('.list-group').html([]);
                }
            }

            static renderResults(result) {
                let resultsHTML = [];

                result.map((n) => {
                    let content = `<li class="list-group-item p-2"><a href="#">${n.display_name}</a></li>`;
                    let elContent = $(content);
                    elContent.on('click', Helper.setLocation).data(n);
                    resultsHTML.push(elContent);
                })

                $('.list-group').html(resultsHTML);
            }

            static setLocation(e){
                const data = $(e.currentTarget).data();
                Index.LFT_Lokasi.setView(new L.LatLng(data.lat, data.lon), 17);
                Index.LFT_LokasiMarker.setLatLng([data.lat, data.lon]);
                Index.FRM_Maps.find('input[name="latlong"]').val(data.lat+", "+data.lon);
                $('.list-group').html([]);
            }

            terapkanMaps(){
                if(Angga.validate(Index.FRM_Maps,Index.MD_TambahLokasi, Index.MD_TambahLokasi.find('.modal-body'),['search'])){
                    let data = Index.FRM_Maps.serializeObject();
                    Helper.addViewLocation(data);
                };
            }

            static addViewLocation(data){
                let content = `
                    <div class="card mb-3 position-relative">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" >
                            <i class="ti ti-minus text-white"></i>
                        </span>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Latitude & Longitude</label>
                                    <input type="text" class="form-control" name="latlong[]" value="${data.latlong}">
                                    </div>
                                    <div class="col-md-6">
                                    <label class="form-label">Urai</label>
                                    <input type="text" class="form-control" name="urai[]" value="${data.urai}">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                let elementContent = $(content);
                elementContent.find('.badge').on('click', (e)=> $(e.currentTarget).parent().remove()).css('cursor','pointer');
                $("#wrapper-lokasi-input").append(elementContent);
                Index.MD_TambahLokasi.modal('hide');
                Index.OFFCNVS_Main.show();
            }

            dragMarker(e){
                const {lat, lng} = e.target._latlng;
                Index.FRM_Maps.find('input[name="latlong"]').val(lat+", "+lng);
            }

            selectMap(e){
                const {lat, lng} = e.latlng
                Index.FRM_Maps.find('input[name="latlong"]').val(lat+", "+lng);
                Index.LFT_LokasiMarker.setLatLng([lat, lng]);
            }

            tambahLokasi(){
                Index.OFFCNVS_Main.hide();
                Index.MD_TambahLokasi.one("shown.bs.modal", function(){
                    Index.LFT_Lokasi.invalidateSize();
                    Helper.clearMaps();
                }).modal("show");
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

                if(!Index.FRM_Main.serializeObject().hasOwnProperty('latlong') && send){
                    Swal.fire("Informasi","Lokasi belum dimasukkan","info");
                    send = false;
                }

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
                Index.BTN_Simpan.attr('mode','edit');
                $.each(Index.FRM_Main[0].elements, function(i,e){
                    if($(e).hasClass("flatpicker-date")){
                        e._flatpickr.setDate(data[e.name]);
                    }else{
                        $(e).val(data[e.name]);
                    }
                });
                const lokasi = JSON.parse(data.lokasidef.replace(/&quot;/g,'"'));
                $("#wrapper-lokasi-input").html([]);
                lokasi.forEach((e,i)=>{
                    Helper.addViewLocation(e);
                });
                Index.OFFCNVS_Main.show();
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static BTN_Simpan;
            static BTN_Tambah;
            static BTN_TambahLokasi;
            static BTN_TerapkanMaps;
            static DT_Main;
            static FRM_Main;
            static DATA_Menu;
            static OFFCNVS_Main;
            static MD_TambahLokasi;
            static LFT_Lokasi;
            static LFT_LokasiMarker;
            static FRM_Maps;
            static MAPS_LatLong;

            constructor() {
                super();
                Index.MAPS_LatLong = [-7.84338, 110.44319];
                Index.BTN_TerapkanMaps = $('#terapkan-maps');
                Index.FRM_Maps = $('#form-maps');
                Index.LFT_Lokasi = L.map("render-map");
                Index.LFT_Lokasi.setView(new L.LatLng(Index.MAPS_LatLong[0], Index.MAPS_LatLong[1]), 17);
                Index.LFT_Lokasi.addLayer(new L.TileLayer(
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                    { minZoom: 4, maxZoom: 20, attribution: 'Binbaz <a href="https://binbaz.or.id">ICBB<a>' })
                );

                Index.LFT_LokasiMarker = L.marker(Index.MAPS_LatLong,{
                    draggable: true,
                    autoPan: true,
                    icon : L.icon({
                        iconUrl: '{{ asset('assets/icons/marker-icon.png') }}',
                        shadowUrl: '{{ asset('assets/icons/marker-shadow.png') }}'
                    })
                }).addTo(Index.LFT_Lokasi);

                Index.MD_TambahLokasi = $('#modal-tambahlokasi');
                Index.BTN_TambahLokasi = $('#tambah-lokasi');
                Index.BTN_Simpan=$('#simpan');
                Index.FRM_Main=$('#form-main');
                Index.BTN_Tambah=$('#tambah');
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
                        {data : "lokasidef"},
                        {data : "masukpuasa"},
                        {data : "pulangpuasa"},
                        {data : "tanggalawalpuasa"},
                        {data : "tanggalakhirpuasa"},
                        {data : "defcuti"},
                        {data : "harilibur"},
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
                $('#loading-search-maps').hide();
                return this;
            }

            bindEvent() {
                Index.BTN_Simpan.on('click', this.simpan);
                Index.BTN_Tambah.on('click',this.tambah);
                Index.BTN_TambahLokasi.on('click', this.tambahLokasi);
                Index.LFT_Lokasi.on('click', this.selectMap);
                Index.LFT_LokasiMarker.on('dragend', this.dragMarker);
                Index.BTN_TerapkanMaps.on('click', this.terapkanMaps);
                Index.FRM_Maps.find('input[name="search"]').keyup(Angga.throttle(this.searchLocation,500));
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

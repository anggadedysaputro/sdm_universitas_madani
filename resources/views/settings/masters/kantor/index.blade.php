@extends('app')
@section('title')
    Kantor
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.masters.kantor.index"/>
@endsection
@section('page-title')
    Kantor
@endsection
@section('action-list')
<a id="tambah" class="btn btn-primary" role="button">
	<i class="ti ti-plus"></i> Tambah kantor
</a>
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
            <input type="text" value="" class="form-control" placeholder="Search…"
                aria-label="Search in website">
        </div>
    </form> --}}
@endsection
@section('content')
<div class="card p-3">
    <div class="card-table table-responsive">
        <table class="table table-vcenter" id="table-main">
            <thead>
            <tr>
                <th class="col-md-1 text-center">#</th>
                <th class="col-md-3 text-center">Nama</th>
                <th class="col-md-1 text-center">Approval</th>
                <th class="col-md-2 text-center">Latitude & Longitude</th>
                <th class="col-md-2 text-center">Pemohon</th>
                <th class="col-md-2 text-center">Aksi</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </div>
<div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-main">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Input kantor</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="#" id="form-main">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="id">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Nama kantor</label>
                        <input type="text" class="form-control" name="nama" placeholder="Input nama kantor" fdprocessedid="tigmx5" required>
                        <div class="invalid-feedback">Nama kantor belum diisi</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <div class="row g-2">
                          <div class="col">
                            <input type="text" class="form-control" placeholder="Klik icon search…"  name="latlong">
                          </div>
                          <div class="col-auto">
                            <a href="#" class="btn btn-icon" aria-label="Button" id="tambah-lokasi">
                              <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                              <i class="ti ti-search"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <div style="width: 100%">
                    <iframe id="iframe-maps"
                        width="100%"
                        height="450"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                    >
                    </iframe>
                    <br />
                    <small>
                        <a id="link-maps" href="#" target="_blank" style="color:#0000FF;text-align:left">
                            Lihat di Google Maps Besar
                        </a>
                    </small>
                </div>
            </div>
        </div>
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

            static updateIframeMaps(lat, lng) {
                const url = `https://maps.google.com/maps?q=${lat},${lng}&hl=id&z=15&output=embed`;
                const link = `https://maps.google.com/maps?q=${lat},${lng}&hl=id&z=15`;

                $('#iframe-maps').attr('src', url);
                $('#link-maps').attr('href', link);
            }


            tambah(){
                Index.FRM_Main[0].reset();
                Index.BTN_Simpan.attr('mode','tambah');
                Index.OFFCNVS_Main.show();
            }

            simpan(){
                let data = Index.FRM_Main.serializeObject();
                let send = true;
                let mode = Index.BTN_Simpan.attr('mode');
                let text = (mode == 'edit' ? 'Anda ingin mengubah data?' : 'Anda ingin menyimpan data?');
                let url = (mode == 'edit' ? '{{ route('settings.masters.kantor.edit') }}' : '{{ route('settings.masters.kantor.store') }}');
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
                            url : "{{ route('settings.masters.kantor.delete') }}",
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

            static setujui(e){
                let data = $(e.currentTarget).data();
                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin mengapprove data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('settings.masters.kantor.setujui') }}",
                            method : "PATCH",
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

            static tolak(e){
                let data = $(e.currentTarget).data();
                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin menolak data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('settings.masters.kantor.tolak') }}",
                            method : "PATCH",
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
                Index.FRM_Main[0].reset();
                let data = $(e.currentTarget).data();
                Index.BTN_Simpan.attr('mode','edit');
                Index.FRM_Main.find('input[name="nama"]').val(data.nama);
                Index.FRM_Main.find('input[name="latlong"]').val(data.latlong);
                Index.FRM_Main.find('input[name="id"]').val(data.id);
                Helper.updateIframeMaps(data.latlong.split(",")[0].trim(), data.latlong.split(",")[1].trim());
                Index.OFFCNVS_Main.show();
            }

            static clearMaps() {
                Index.LFT_Lokasi.setView(new L.LatLng(Index.MAPS_LatLong[0], Index.MAPS_LatLong[1]), 17);
                Index.LFT_LokasiMarker.setLatLng(Index.MAPS_LatLong);
            }

            searchLocation(e) {
                let keyword = $(e.currentTarget).val();
                if (keyword) {
                    $('#loading-search-maps').show();
                    fetch(`https://nominatim.openstreetmap.org/search?q=${keyword}&format=json`)
                        .then((response) => {
                            return response.json()
                        }).then(json => {
                            // get response data from nominatim
                            $('#loading-search-maps').hide();
                            if (json.length > 0) return Helper.renderResults(json)
                            else alert("lokasi tidak ditemukan")
                        });
                } else {
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

            static setLocation(e) {
                const data = $(e.currentTarget).data();
                Index.LFT_Lokasi.setView(new L.LatLng(data.lat, data.lon), 17);
                Index.LFT_LokasiMarker.setLatLng([data.lat, data.lon]);
                Index.FRM_Main.find('input[name="latlong"]').val(data.lat + ", " + data.lon);
                $('.list-group').html([]);
            }

            terapkanMaps() {
                const data = Myapp.LFT_LokasiMarker._latlng;
                Index.FRM_Main.find("input[name='latlong']").val(data.lat + ", " + data.lng)
                Index.MD_TambahLokasi.modal("hide");
                Helper.updateIframeMaps(data.lat, data.lng);
                Index.OFFCNVS_Main.show();
            }

            selectMap(e) {
                const {
                    lat,
                    lng
                } = e.latlng
                Index.LFT_LokasiMarker.setLatLng([lat, lng]);
            }


            tambahLokasi() {
                Index.OFFCNVS_Main.hide();
                Index.MD_TambahLokasi.one("shown.bs.modal", function() {
                    Index.LFT_Lokasi.invalidateSize();
                    Helper.clearMaps();
                }).modal("show");
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
            static BTN_TambahLokasi;
            static BTN_TerapkanMaps;
            static MD_TambahLokasi;
            static LFT_Lokasi;
            static LFT_LokasiMarker;
            static FRM_Maps;
            static MAPS_LatLong;

            constructor() {
                super();
                Index.BTN_TambahLokasi = $('#tambah-lokasi');
                Index.BTN_Simpan=$('#simpan');
                Index.FRM_Main=$('#form-main');
                Index.BTN_Tambah=$('#tambah');
                Index.MD_TambahLokasi = $('#modal-tambahlokasi');
                Index.MAPS_LatLong = [-7.84338, 110.44319];
                Index.BTN_TerapkanMaps = $('#terapkan-maps');
                Index.LFT_Lokasi = L.map("render-map");
                Index.LFT_Lokasi.setView(new L.LatLng(Index.MAPS_LatLong[0], Index.MAPS_LatLong[1]), 17);
                Index.LFT_Lokasi.addLayer(new L.TileLayer(
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        minZoom: 4,
                        maxZoom: 20,
                        attribution: 'Binbaz <a href="https://binbaz.or.id">ICBB<a>'
                    }));

                Index.LFT_LokasiMarker = L.marker(Index.MAPS_LatLong, {
                    draggable: true,
                    autoPan: true,
                    icon: L.icon({
                        iconUrl: '{{ asset('assets/icons/marker-icon.png ') }}',
                        shadowUrl: '{{ asset('assets/icons/marker-shadow.png') }}'
                    })
                }).addTo(Index.LFT_Lokasi);

                Index.DT_Main=$("#table-main").DataTable({
                    ajax : {
                        url : "{{ route('settings.masters.kantor.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    processing : true,
                    serverSide : true,
                    columns : [
                        {data : "id"},
                        {data : "nama"},
                        {
                            data : null,
                            className : "approval text-center",
                            defaultContent : ""
                        },
                        {data : "latlong"},
                        {data : "name"},
                        {
                            data : null,
                            defaultContent : `
                                <button class="btn btn-danger btn-sm hapus"><i class="ti ti-trash-x"></i></button>
                                <button class="btn btn-warning btn-sm edit"><i class="ti ti-edit-circle"></i></button>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item setujui" href="#">Approve</a></li>
                                        <li><a class="dropdown-item tolak" href="#">Tolak</a></li>
                                    </ul>
                                </div>
                            `
                        }
                    ],
                    createdRow : function(row,data){
                        if(data.approval == null){
                            $(row).find('.approval').html('<span class="badge badge-sm bg-warning-lt text-uppercase ms-auto">Pending</span>');
                        }else if(data.approval == 'Y'){
                            $(row).find('.approval').html('<span class="badge badge-sm bg-success-lt text-uppercase ms-auto">Aktif</span>');
                        }else{
                            $(row).find('.approval').html('<span class="badge badge-sm bg-danger-lt text-uppercase ms-auto">Di tolak</span>');
                        }
                        $(row).find('.hapus').on('click', Helper.hapus).data(data);
                        $(row).find('.edit').on('click', Helper.edit).data(data);
                        $(row).find('.setujui').on('click', Helper.setujui).data(data);
                        $(row).find('.tolak').on('click', Helper.tolak).data(data);
                    }
                });
                Index.OFFCNVS_Main = new bootstrap.Offcanvas(document.getElementById('canvas-main'));
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
                Index.BTN_TerapkanMaps.on('click', this.terapkanMaps);
                Index.FRM_Main.find('input[name="search"]').keyup(Angga.throttle(this.searchLocation, 500));
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

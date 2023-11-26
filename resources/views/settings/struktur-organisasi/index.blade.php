@extends('app')
@section('title')
    Struktur organisasi
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.struktur-organisasi.index"/>
@endsection
@section('page-title')
    Struktur organisasi
@endsection
@section('action-list')
    {{-- <button class="btn btn-primary" id="tambah-data"><i class="ti ti-plus"></i>Tambah data</button> --}}
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
            <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
        </div>
    </form>
@endsection
@section('content')
    <div class="d-flex">
        Klik kanan pada pohon menu, untuk menampilkan konteks menu
    </div>
    <div class="d-flex">
        <a href="#" class="card card-link card-link-pop flex-fill">
            <div class="card-body">
                <div id="jstree_demo_div">
                </div>
            </div>
        </a>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-organisasi">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Input data</h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="#" id="formAddOrganisasi">
                <div class="row">
                    {{-- <div class="col-md-12 0">
                        <div class="mb-3">
                            <label class="form-label">Bidang</label>
                            <select class="select-organisasi" name="bidang" id="bidang" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="col-md-12 1">
                        <div class="mb-3">
                            <label class="form-label">Divisi</label>
                            <select class="select-organisasi" name="kodedivisi" id="kodedivisi" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="col-md-12 2">
                        <div class="mb-3">
                            <label class="form-label">Sub divisi</label>
                            <select class="select-organisasi" name="kodesubdivisi" id="kodesubdivisi" style="width: 100%;"></select>
                        </div>
                    </div>
                    <div class="col-md-12 3">
                        <div class="mb-3">
                            <label class="form-label">Sub sub divisi</label>
                            <select class="select-organisasi" name="kodesubsubdivisi" id="kodesubsubdivisi" style="width: 100%;"></select>
                        </div>
                    </div> --}}
                    <input type="hidden" name="id" id="id"/>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Urai</label>
                            <input type="text" class="form-control" name="urai" placeholder="Urai" fdprocessedid="tigmx5" required>
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

            simpan(){
                let data = Index.FRM_Organisasi.serializeObject();
                let send = true;
                let mode = Index.BTN_Simpan.attr('mode');
                let text;
                let url;
                let method;
                data = $.extend({mode : mode}, data);
                
                if(mode == 'edit'){
                    text = 'Anda ingin mengubah data?';
                    url = '';
                    method = 'PATCH';
                } else if(mode == 'tambah anak' || mode =='tambah saudara'){
                    text = 'Anda ingin menyimpan data?';
                    url = '{{ route('settings.struktur-organisasi.simpan') }}';
                    method = 'POST';
                }
                
                $.each(Index.FRM_Organisasi[0].elements, function(i,e){
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
                                        Helper.getMenuJstree().then((result)=>{
                                            Index.JSTREE_Main.settings.core.data = result.data;
                                            Index.JSTREE_Main.refresh();
                                        }).catch((error)=>{
                                            console.log(error);
                                        });
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

            static saudara(e){
                Index.BTN_Simpan.attr('mode','tambah saudara');
                $('#id').val(e.id);
                $('#formAddOrganisasi').find('input[name="urai"]').val("");
                Index.OFFCNVS_Jabatan.show();
            }

            static anak(e){
                Index.BTN_Simpan.attr('mode', 'tambah anak');
                $('#id').val(e.id);
                $('#formAddOrganisasi').find('input[name="urai"]').val("");
                Index.OFFCNVS_Jabatan.show();
            }

            static getMenuJstree(){
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url : "{{ route('jstree.struktur-organisasi.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend : function(){
                            Swal.fire({
                                title: 'Mendapatkan data!',
                                html: 'Silahkan tunggu...',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                        },
                        success : function(result){     
                            Swal.close();
                            // result.data.forEach(function(e,i){
                            //     Index.JSTREE_Main.create_node(e.parent,{text:e.text,id:e.id});
                            // });
                            resolve(result);
                        },
                        error : function(error){
                            Swal.close();
                            reject(error.responseJSON.message ?? error.responseJSON);
                        }
                    });
                });
                
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static JSTREE_Main;
            static DATA_Menu;
            static OFFCNVS_Jabatan;
            static BTN_TambahData;
            static BTN_Simpan;
            static S2_Bidang;
            static S2_Divisi;
            static S2_SubDivisi;
            static S2_SubsubDivisi;
            static AJAX_Object;
            static FRM_Organisasi;

            constructor() {
                super();

                Index.JSTREE_Main = $("#jstree_demo_div").jstree({
                    "core" : {
                    "check_callback" : true
                    },
                    "plugins" : [ "dnd","contextmenu" ],
                    "contextmenu": {  
                        items: function (node) {  
                            return {  
                                "tambah" : {
                                    "label": "Tambah",  
                                    "icon": "ti ti-add",  
                                    "submenu" : {
                                        "anak" : {
                                            "label" : "Anak",
                                            "_class" :"asc",
                                            "action": function (obj) {  
                                                let last = node.id.split(".").pop();
                                                if(last != '0'){
                                                    Swal.fire("Informasi","Tidak boleh tambah anak lagi","info");
                                                    return;
                                                }else{
                                                    Helper.anak(node);
                                                }
                                            },  
                                        },
                                        "saudara" : {
                                            "label" : "Saudara",
                                            "_class" :"asc",
                                            "action": function (obj) {  
                                                if(node.id == 0){
                                                    Swal.fire('Informasi','Tidak boleh menambah saudara pada root tree','info');
                                                }else{
                                                    Helper.saudara(node);
                                                }
                                            },  
                                        }
                                    },
                                    "_class": "asc"  
                                },
                                "hapus": {  
                                    "label": "Delete",  
                                    "icon": "fa-times",  
                                    "action": function (obj) {  
                                        // Helper.removeNode(node);
                                    },  
                                    "_class": "asc"  
                                },
                                "edit": {  
                                    "label": "Edit",  
                                    "icon": "uil-times-circle",  
                                    "action": function (obj) {  
                                        // Helper.editNode(node);
                                    },  
                                    "_class": "asc"  
                                }
                            }  
                        },  
                    },  
                });

                Index.JSTREE_Main = $.jstree.reference(Index.JSTREE_Main);
                Index.OFFCNVS_Jabatan =new bootstrap.Offcanvas(document.getElementById('canvas-organisasi'));
                Index.AJAX_Object = {
                    generalselect2 : {
                        allowClear: true
                    },
                    bidang : {
                        placeholder : 'Pilih bidang',
                        ajax : {
                            url : "{{ route('settings.struktur-organisasi.bidang') }}",
                            method : "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        }
                    },
                    divisi : {
                        placeholder : 'Pilih divisi',
                    },
                    subdivisi : {
                        placeholder : 'Pilih sub divisi',
                    },
                    subsubdivisi : {
                        placeholder : 'Pilih sub sub divisi',
                    }
                }
                Index.BTN_TambahData = $("#tambah-data");
                Index.S2_Bidang = $('#bidang').select2($.extend(Index.AJAX_Object.generalselect2,Index.AJAX_Object.bidang));
                Index.S2_Divisi = $('#kodedivisi').select2($.extend(Index.AJAX_Object.generalselect2,Index.AJAX_Object.divisi));
                Index.S2_SubDivisi = $('#kodesubdivisi').select2($.extend(Index.AJAX_Object.divisi,Index.AJAX_Object.subdivisi));
                Index.S2_SubsubDivisi = $('#kodesubsubdivisi').select2($.extend(Index.AJAX_Object.subdivisi,Index.AJAX_Object.subsubdivisi));
                Index.BTN_Simpan = $('#simpan');
                Index.FRM_Organisasi = $('#formAddOrganisasi');
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
                    // resolve(true);
                    Helper.getMenuJstree().then((result)=>{
                        Index.DATA_Menu = result;
                        resolve(true);
                    }).catch((error)=>{
                        console.log(error);
                    });
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
                $('.select-organisasi').not('#bidang').each(function(i,e){
                    $(e).parents('.col-md-12:first').hide();
                });
                return this;
            }

            bindEvent() {
                Index.BTN_TambahData.on('click', this.tambahData);
                Index.BTN_Simpan.on('click', this.simpan);
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
                Index.DATA_Menu.data.forEach(function(e,i){
                    Index.JSTREE_Main.create_node(e.parent,{text:e.text,id:e.id});
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
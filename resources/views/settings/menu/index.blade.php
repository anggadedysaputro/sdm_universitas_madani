@extends('app')
@section('title')
    Menu
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.menu.index"/>
@endsection
@section('page-title')
    Menu
@endsection
@section('action-list')
    <button class="btn btn-primary" id="addNew"><i class="ti ti-plus"></i> Tambah menu</button>
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
    
    <!-- Large Modal -->
    <div class="modal modal-blur fade" id="menu-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-simple modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="lfgck6"></button>
                    <div class="p-3 p-md-5">
                        <div class="text-center mb-4">
                            <h3 id="title-view">Tambah menu baru</h3>
                        </div>
                        <form id="addMenuForm" class="row fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" novalidate="novalidate">
                            <div class="col-12 mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="modalPermissionName">Nama menu</label>
                                <input type="text" id="modalPermissionName" name="nama" class="form-control is-invalid" placeholder="Nama menu" autofocus="" fdprocessedid="jzw2mj" required>
                                <div class="invalid-feedback">
                                    Masukkan nama menu
                                </div>
                            </div>
                            <div class="col-12 mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="icon-menu">Icon</label>
                                <select id="icon-menu" name="icon"></select>
                            </div>
                            <div class="col-12 mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="parent">Induk</label>
                                <select id="parent" name="parent"></select>
                            </div>
                            <div class="col-12 mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="link-menu">Link</label>
                                <select id="link-menu" name="link"></select>
                            </div>
                            <div class="col-12 mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                                <label class="form-label" for="isactive">Status</label>
                                <select id="isactive" name="isactive" class="is-invalid" required>
                                    <option value="">Pilih status</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak aktif</option>
                                </select>
                                <div class="invalid-feedback">
                                    Masukkan status
                                </div>
                            </div>
                            <div class="col-12 text-center demo-vertical-spacing">
                                <button type="button" class="btn btn-success" id="create-menu"><i class="ti ti-send"></i> Simpan</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="mbavig"><i class="ti ti-circle-x"></i> Batal</button>
                            </div>
                            <input type="hidden" name="id" id="id">
                        </form>
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

            clearForm(){

            }

            addNew(e){
                Index.BTN_Simpan.attr('mode','insert')
                $('#id').val(0);
                Index.MD_Main.modal('show');
            }

            static resetForm(){
                Index.FRM_Main[0].reset();
                Index.S2_Link.val("").trigger('change');
                Index.S2_MenuAktif.val("").trigger('change');
                Index.S2_MenuIcon.val("").trigger('change');
                Index.S2_Parent.val("").trigger('change');
            }

            static editNode(node){
                let id = node.id;
                Index.BTN_Simpan.attr('mode','edit');
                $('#id').val(id);
                $.ajax({
                    url : '{{ route('settings.menu.byid') }}',
                    method : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        id
                    },
                    beforeSend : function(){
                        Swal.fire({
                            title: 'Mengambil data menu by ID!',
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
                        $('#modalPermissionName').val(result.data.nama);
                        let icon = {
                            id : result.data.icon_id,
                            text : result.data.icon_name
                        }
                        let parent = {
                            id : result.data.parent,
                            text : result.data.parent_name
                        }
                        let status = {
                            id : +result.data.isactive
                        }
                        let link = {
                            id : result.data.link,
                            text : result.data.link
                        }
                        Angga.setValueSelect2AjaxRemote(Index.S2_MenuIcon,icon);
                        Angga.setValueSelect2AjaxRemote(Index.S2_MenuAktif,status);
                        Angga.setValueSelect2AjaxRemote(Index.S2_Link,link);
                        if(result.data.parent > 0) Angga.setValueSelect2AjaxRemote(Index.S2_Parent,parent);
                        Index.MD_Main.modal('show');
                    },
                    error : function(error){
                        Swal.fire('Gagal',error.responseJSON.message,'error');
                    }
                })
            }

            static removeNode(node){
                let id = node.id;

                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Anda ingin menghapus data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : '{{ route('settings.menu.delete') }}',
                            method : "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data : {
                                id
                            },
                            beforeSend : function(){
                                Swal.fire({
                                    title: 'Menghapus menu!',
                                    html: 'Silahkan tunggu...',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success : function(result){
                                Swal.fire('Berhasil',result.message,'success').then(()=>{
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
                        });
                    }
                });

            }

            save(){
                let data = Index.FRM_Main.serializeObject();
                let send = true;
                let mode = Index.BTN_Simpan.attr('mode');
                let text = (mode == 'edit' ? 'Anda ingin mengubah data?' : 'Anda ingin menyimpan data?');
                let url = (mode == 'edit' ? '{{ route('settings.menu.edit') }}' : '{{ route('settings.menu.store') }}');
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
                                data : Index.FRM_Main.serializeObject(),
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
                                        Index.MD_Main.modal('hide').on('hidden.bs.modal', function(){
                                            Helper.getMenuJstree().then((result)=>{
                                                Index.JSTREE_Main.settings.core.data = result.data;
                                                Index.JSTREE_Main.refresh();
                                                Helper.resetForm();
                                            }).catch((error)=>{
                                                console.log(error);
                                            });
                                            $(this).off('hidden.bs.modal');
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

            static getMenuJstree(){
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url : "{{ route('jstree.menu.data') }}",
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
            static MD_Main;
            static S2_MenuIcon;
            static S2_MenuAktif;
            static S2_Parent;
            static S2_Link;
			static AJAX_Object;
            static FRM_Main;
            static DATA_Menu;
            static BTN_Simpan;

            constructor() {
                super();
                Index.BTN_Simpan = $('#create-menu');
                Index.FRM_Main = $('#addMenuForm');
                Index.AJAX_Object = {
                    menuactive : {
                        dropdownParent : $('.modal-content'),
						theme : 'bootstrap-5',
                        placeholder : 'Pilih status',
                        allowClear: true,
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                        templateSelection: function(data) {
                            return "<span class='ms-4'>"+data.text+"</span>";
                        }
                    },
					menuicon : Angga.generalAjaxSelect2('{{ route('settings.menu.icon') }}','Pilih icon'),
                    menuparent : Angga.generalAjaxSelect2('{{ route('settings.menu.parent') }}','Pilih induk'),
                    menulink : Angga.generalAjaxSelect2('{{ route('settings.menu.link') }}','Pilih link'),
				}

                Index.S2_MenuIcon = $('#icon-menu').select2(Index.AJAX_Object.menuicon);
                Index.S2_MenuAktif = $('#isactive').select2(Index.AJAX_Object.menuactive);
                Index.S2_Parent = $('#parent').select2(Index.AJAX_Object.menuparent);
                Index.S2_Link = $('#link-menu').select2(Index.AJAX_Object.menulink);

                Index.JSTREE_Main = $("#jstree_demo_div").jstree({
                    "core" : {
                    "check_callback" : true
                    },
                    "plugins" : [ "dnd","contextmenu" ],
                    "contextmenu": {  
                        items: function (node) {  
                            return {  
                                "hapus": {  
                                    "label": "Delete",  
                                    "icon": "fa-times",  
                                    "action": function (obj) {  
                                        Helper.removeNode(node);
                                    },  
                                    "_class": "asc"  
                                },
                                "edit": {  
                                    "label": "Edit",  
                                    "icon": "uil-times-circle",  
                                    "action": function (obj) {  
                                        Helper.editNode(node);
                                    },  
                                    "_class": "asc"  
                                }
                            }  
                        },  
                    },  
                });

                Index.JSTREE_Main = $.jstree.reference(Index.JSTREE_Main);

                Index.MD_Main = $('#menu-modal');
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
                    Index.getMenuJstree().then((result)=>{
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
                return this;
            }

            bindEvent() {
                $('#addNew').on('click',this.addNew);
                Index.BTN_Simpan.on('click', this.save);
                Index.JSTREE_Main.element.on('move_node.jstree', (node,parent)=>{
                    console.log(parent);
                });
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
@extends('app')
@section('title')
    Permission
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.permission.index"/>
@endsection
@section('page-title')
    Permission
@endsection
@section('action-list')
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
            <div id="main-search"></div>
            
        </div>
    </form>
@endsection
@section('content')

<div class="row">
    <div class="col-md-6">
        <span>
            Klik kanan pada pohon menu, untuk menampilkan konteks menu [tambah permission]
        </span>
        <div class="d-flex">
            <a href="#" class="card card-link card-link-pop flex-fill">
                <div class="card-body">
                    <div id="jstree_demo_div">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-6">
        <span>
            Daftar permission
        </span>
        <div class="d-flex">
            <a href="#" class="card card-link card-link-pop flex-fill">
                <div class="card-body">
                    <div class="list-group list-group-flush" id="daftar-akses">
                        
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Large Modal -->
<div class="modal modal-blur fade" id="permissions-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-simple modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="lfgck6"></button>
                <div class="p-3 p-md-5">
                    <div class="text-center mb-4">
                        <h3>Tambah izin baru</h3>
                        <p>Izin yang dapat Anda gunakan dan berikan kepada pengguna Anda.</p>
                    </div>
                    <form id="addPermissionForm" class="row fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" novalidate="novalidate">
                        <div class="col-12 mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                        <label class="form-label" for="modalPermissionName">Nama izin</label>
                        <input type="hidden" name="id" id="id-permission"/>
                        <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control is-invalid" placeholder="Nama izin" autofocus="" fdprocessedid="jzw2mj">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"><div data-field="modalPermissionName" data-validator="notEmpty">Masukkan nama izin</div></div></div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="button" class="btn btn-success" id="create-permission"><i class="ti ti-send"></i> Simpan</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="mbavig"><i class="ti ti-circle-x"></i> Batal</button>
                        </div>
                        <input type="hidden">
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

            static templatePermissions(data){
                let content = [];
                $.each(data, function(i,e){
                    let plainText = `
                        <form action="#">
                            <div class="list-group-item p-1">
                                <div class="row align-items-center">
                                    <div class="col text-truncate">
                                        <input type="text" value="${e.name}" class="form-control" name="name">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-danger hapus" nitip="${e.id}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success edit" nitip="${e.id}">
                                            <i class="ti ti-send"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    `;

                    let element = $(plainText);
					element.find('.hapus').on('click',Helper.hapusPermission).data(e);
                    element.find('.edit').on('click',Helper.editPermission).data(e);
					content.push(element);
                });

                if(data.length==0){
                    let plainText = `
                        <div class="list-group-item p-1">
                            <div class="row align-items-center">
                                <div class="col text-center">
                                    Data tidak ditemukan
                                </div>
                            </div>
                        </div>
                    `;

                    let element = $(plainText);
					content.push(element);
                }

                $('#daftar-akses').html(content);
            }

            static hapusPermission(e){
                let id = $(e.currentTarget).attr('nitip');
                let idmenu = Myapp.JSTREE_Main.get_selected()[0];
                Swal.fire({
                    title : 'Informasi',
                    text  : `Apakah anda yakin ingin menghapus izin ?`,
                    icon  : 'info',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('settings.permission.delete') }}",
                            method : "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data : {id,idmenu},
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
                                    title: 'Berhasil',
                                    html: result.message,
                                    icon:'success',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false
                                }).then(()=>{
                                    Helper.templatePermissions(result.data);
                                });
                            },
                            error : function(error){
                                Swal.fire({
                                    title: 'Error',
                                    html: result.responseJSON.message,
                                    icon:'error',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false
                                });
                            }
                        })
                    }
                });
            }

            static editPermission(e){
                let id = $(e.currentTarget).attr('nitip');
                let idmenu = Myapp.JSTREE_Main.get_selected()[0];
                let nama = $(e.currentTarget).parents('form').serializeObject().name;
                Swal.fire({
                    title : 'Informasi',
                    text  : `Apakah anda yakin ingin mengubah izin ?`,
                    icon  : 'info',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('settings.permission.update') }}",
                            method : "PUT",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data : {id,idmenu,nama},
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
                                    title: 'Berhasil',
                                    html: result.message,
                                    icon:'success',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false
                                }).then(()=>{
                                    Helper.templatePermissions(result.data);
                                });
                            },
                            error : function(error){
                                Swal.fire({
                                    title: 'Error',
                                    html: error.responseJSON.message,
                                    icon:'error',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false
                                });
                            }
                        })
                    }
                });
            }

            activateNode(e, data){
                let id = Myapp.JSTREE_Main.get_selected()[0];
                
                $.ajax({
                    url : "{{ route('settings.permission.single') }}",
                    method : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        id
                    },
                    beforeSend:function(){
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
                    success:function(result){
                        Swal.close();
                        
                        Helper.templatePermissions(result.data);

                        if(result.data.length==0){
                           Helper.templatePermissions([]);
                        }
                    },
                    error:function(error){
                        Swal.fire({
                            title: 'Error',
                            html: error.responseJSON.message,
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        });
                    }
                })
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

            simpan(e){
				let ePermissionName = $('#modalPermissionName');
				let ePermissionId = $('#id-permission');
				let vPermissionName = ePermissionName.val() || '';
				let vPermissionId = ePermissionId.val();
				let isMethod = $(e.currentTarget).attr('nitip') == 'edit' ? 'Mengubah' : 'Membuat';
				let method = $(e.currentTarget).attr('nitip') == 'edit' ? 'PUT' : 'POST';
				let uri = $(e.currentTarget).attr('nitip') == 'edit' ? "{{ route('settings.permission.update') }}" : "{{ route('settings.permission.create') }}";
				let send = false;

				if(vPermissionName == ''){
					ePermissionName.addClass('is-invalid');
					ePermissionName.next().text('Masukkan nama izin');
					send = false;
				}else{
					ePermissionName.next().text('');
					ePermissionName.removeClass('is-invalid');
					send = true;

					if(send){
						Index.MD_AddPermissions.modal('hide').one('hidden.bs.modal', function(){
							Swal.fire({
								title : 'Informasi',
								text  : `Apakah anda yakin ingin ${isMethod.toLowerCase()} izin ?`,
								icon  : 'info',
								showCancelButton : true,
								cancelButtonText: 'Tidak',
								confirmButtonText : 'Ya'
							}).then((result)=>{
								if(result.isConfirmed){
                                    let idmenu = Myapp.JSTREE_Main.get_selected()[0];
									$.ajax({
										url : uri,
										method : method,
										headers: {
											'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										},
										data : {
											nama : vPermissionName,
											id : vPermissionId,
                                            idmenu
										},
										beforeSend : function(){
											Swal.fire({
												title: isMethod+' permission!',
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
											Swal.fire({
												title : 'Berhasil',
												html : result.message,
												icon : 'success',
												allowEscapeKey: false,
												allowOutsideClick: false,
											}).then(()=>{
                                                $('#daftar-akses').html(Helper.templatePermissions(result.data));
											});
										},
										error : function(error){
											Swal.close();
											Swal.fire({
												title : 'Informasi',
												html : error.responseJSON.message,
												icon : 'error',
												allowEscapeKey: false,
												allowOutsideClick: false,
											}).then(()=>{
												Index.MD_AddPermissions.modal('show');
											});
										}
									});
								}else{
									Index.MD_AddPermissions.modal('show');
								}
							});
						});
					}
				}
			}
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static JSTREE_Main;
            static MD_AddPermissions;
            static MD_Main;
            static BTN_Simpan;

            constructor() {
                super();
                Index.MD_Main = $('#permissions-modal');
                Index.BTN_Simpan = $('#create-permission');
                Index.MD_AddPermissions = $('#permissions-modal');
                
                Index.JSTREE_Main = $("#jstree_demo_div").jstree({
                    "core" : {
                    	"check_callback" : true
                    },
                    "plugins" : [ "contextmenu"],
                    "contextmenu": {  
                        items: function (node) {  
                            return {  
                                "tambah": {  
                                    "label": "Tambah",  
                                    "icon": "ti ti-plus",  
                                    "action": function (obj) {  
                                        Index.MD_Main.modal('show');
                                    },  
                                    "_class": "asc"  
                                }
                            }  
                        },  
                    },  
                });

                Index.JSTREE_Main = $.jstree.reference(Index.JSTREE_Main);
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
                Helper.templatePermissions([]);
                return this;
            }

            bindEvent() {
                Index.BTN_Simpan.on('click',this.simpan);
                Myapp.JSTREE_Main.element.on('activate_node.jstree', this.activateNode);
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
                Index.JSTREE_Main.settings.core.data = Index.DATA_Menu.data;
                Index.JSTREE_Main.refresh();
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
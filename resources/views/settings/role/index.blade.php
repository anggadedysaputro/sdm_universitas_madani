@extends('app')
@section('title')
    Title
@endsection
@section('breadcrumb')
<x-bread-crumbs breadcrumbtitle="settings.role.index"/>
@endsection
@section('page-title')
    Peran
@endsection
@section('action-list')
    <a href="#" class="btn btn-primary d-none d-sm-inline-block add-new-role">
        <i class="ti ti-plus"></i> Tambah peran baru    
    </a>
@endsection
@section('content')
    <div class="row g-4">
        @foreach ($role as $key => $value)
        {{-- {{ dd($value['idrole']) }} --}}
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                    <h6 class="fw-normal">Total {{ $value['jumlah'] }} Pengguna | Total {{ $value['jumlahmenu'] }} Menu</h6>
                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                        @foreach ($value['users'] as $users)
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-sm pull-up" aria-label="{{ $users['name'] }}" data-bs-original-title="{{ $users['name'] }}">
                                <img class="rounded-circle p-1" src="{{ defaultImgUser(); }}" alt="Avatar">
                            </li>
                        @endforeach
                    </ul>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                    <div class="role-heading">
                        <h4 class="mb-1">{{$key}}</h4>
                        <a href="javascript:;" class="role-edit-modal" nitip="{{ $key }}" idrole="{{ $value['idrole'] }}"><small>Ubah peran</small></a>
                    </div>
                    <a href="javascript:void(0);" class="text-muted hapus-peran" idrole="{{ $value['idrole'] }}"><i class="ti ti-trash-x-filled text-danger"></i></a>
                    </div>
                </div>
                </div>
            </div>
        @endforeach
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
            <div class="card-body p-1">
                <div class="row">
                <div class="col-sm-5 d-flex justify-content-center align-items-end">
                    <div class="mt-sm-0 mt-3">
                    <img src="{{ asset('assets/ilustration/man-with-laptop-light.png') }}" class="img-fluid" alt="Image" width="120" data-app-light-img="illustrations/sitting-girl-with-laptop-light.png" data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="card-body text-sm-end text-center ps-sm-0">
                    <p class="mb-0">Tambah peran, jika belum ada</p>
                    </div>
                </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <!-- Large Modal -->
	<div class="modal modal-blur fade" id="role-modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered " role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel3">Peran</h5>
			  <button
				type="button"
				class="btn-close"
				data-bs-dismiss="modal"
				aria-label="Close"
			  ></button>
			</div>
			<div class="modal-body p-3 p-md-5">
				<div class="text-center mb-4">
					<h3 class="role-title">Tambah peran baru</h3>
					<p>Tetapkan izin peran</p>
				</div>
				<form id="addRoleForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" onsubmit="return false" novalidate="novalidate">
					<div class="col-12 mb-4 fv-plugins-icon-container">
						<div class="form-input">
							<label class="form-label" for="modalRoleName">Nama peran</label>
							<input type="text" id="modalRoleName" name="rolename" class="form-control" placeholder="Masukkan nama peran" tabindex="-1">
							<input type="hidden" id="idRole" value="">
							<div class="is-invalid">
							</div>
						</div>
					</div>
					<div class="col-12 mb-4 fv-plugins-icon-container">
						<div class="card">
							<div class="card-header">
							  <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
								<li class="nav-item" role="presentation">
								  <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
									<i class="ti ti-shield-cog"></i>
									Peran</a>
								</li>
								<li class="nav-item" role="presentation">
								  <a href="#tabs-profile-7" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
									<i class="ti ti-template"></i>
									Menu</a>
								</li>
							  </ul>
							</div>
							<div class="card-body">
							  <div class="tab-content">
								<div class="tab-pane active show" id="tabs-home-7" role="tabpanel">
								  <h4>Izin peran</h4>
					  
									<table class="table table-flush-spacing">
										<tbody>
										<tr>
											<td class="text-nowrap fw-medium">
												Akses penuh <i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Izinkan peran untuk akses sepenuhnya" data-bs-original-title="Izinkan peran untuk akses sepenuhnya"></i>
											</td>
											<td>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="selectAll">
												<label class="form-check-label" for="selectAll">
												Pilih semua
												</label>
											</div>
											</td>
										</tr>
										@foreach ($permission as $value)
										<tr>
											<td class="text-nowrap fw-medium">
												<input type="hidden" name="permissionname[]" value="{{ $value->name }}"/>
												{{ $value->name }}
											</td>
											<td>
											<div class="d-flex">
												<div class="form-check me-3 me-lg-5">
													<input class="form-check-input allow-permission" type="checkbox" id="{{ str_replace(" ","",$value->name)."_allow" }}"/>
													<label class="form-check-label" for="{{ str_replace(" ","",$value->name)."_allow" }}">
													Izinkan
													</label>
												</div>
											</div>
											</td>
										</tr>
										@endforeach
										</tbody>
									</table>
								</div>
								<div class="tab-pane" id="tabs-profile-7" role="tabpanel">
									<h4>Menu</h4>
									<div id="jstree_demo_div">
									</div>
								</div>
							  </div>
							</div>
						  </div>
					</div>
					<div class="col-12 text-center">
						{{-- <button type="button" class="btn btn-danger me-sm-3 me-1" id="delete-peran"><i class="ti ti-trash-x-filled"></i> Delete</button> --}}
					  	<button type="button" class="btn btn-success" id="submit"><i class="ti ti-send"></i> Simpan</button>
					  	<button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-circle-x"></i> Batal</button>
					</div>
				</form>
			</div>
		  </div>
		</div>
	</div>
@endsection
@section('jsweb')
    <script type="module">

        class Helper {
            constructor(){
                // alert('helper');
            }
            peran(){
				$('.allow-permission').prop('checked',false);
				$('#modalRoleName').val("");
				$('#idRole').val("");
				Index.MD_RoleModal.attr('nitip','add');
				Index.MD_RoleModal.find('h3').text("Tambah peran baru");
				Myapp.JSTREE_Main.uncheck_all();
				Index.MD_RoleModal.modal('show');
			}

			simpan(e){
				let eRoleName = $('#modalRoleName');
				let eIdRole = $('#idRole');
				let vRoleName = eRoleName.val() || '';
				let vIdRole = eIdRole.val();
				let send = false;

				if(vRoleName == ''){
					eRoleName.addClass('is-invalid');
					eRoleName.next().text('Role name masih kosong!');
					send = false;
				}else{
					eRoleName.next().text('');
					eRoleName.removeClass('is-invalid');
					send = true;
					let tbody = Index.FRM_addRoleForm.find('table tbody tr');
					let method = Index.MD_RoleModal.attr('nitip') == 'edit' ? "PUT" : "POST";
					let uri = Index.MD_RoleModal.attr('nitip') == 'edit' ? "{{ route('settings.role.update') }}" : "{{ route('settings.role.create') }}";
					let aksi = Index.MD_RoleModal.attr('nitip') == 'edit' ? "Mengubah" : "Membuat";

					let permission = tbody.find('.allow-permission').map(function(index, element){
						return $(element).is(':checked');
					}).get();

					let unique = [...new Set(Myapp.JSTREE_Main.get_checked())];
					let data = $.extend(Index.FRM_addRoleForm.serializeObject(),{menu:unique});
					data['id'] = vIdRole;
					data['create'] = permission;

					if(send){
						Index.MD_RoleModal.modal('hide').one('hidden.bs.modal', function(){
							Swal.fire({
								title : 'Informasi',
								text  : `Apakah anda yakin ingin ${aksi} peran ?`,
								icon  : 'info',
								showCancelButton : true,
								cancelButtonText: 'Tidak',
								confirmButtonText : 'Ya'
							}).then((result)=>{
								if(result.isConfirmed){
									$.ajax({
										url : uri,
										method : method,
										data : data,
										headers: {
											'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										},
										beforeSend : function(){
											Swal.fire({
												title: aksi+' role!',
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
												window.location.reload();
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
												Index.MD_RoleModal.modal('show');
											});
										}
									});
								}else{
									Index.MD_RoleModal.modal('show');
								}
							
							});
						});
					}
				}
			}

			eventNamaPeran(e){
				let eInputRoleName = $(e.currentTarget);
				let vInputRoleName = eInputRoleName.val() || '';

				if(vInputRoleName != ''){
					eInputRoleName.removeClass('is-invalid');
					eInputRoleName.next().text('');
				}else{
					eInputRoleName.addClass('is-invalid');
					eInputRoleName.next().text('Role name masih kosong!');
				}
			}

			hapusPeran(e){
				let id = $(e.currentTarget).attr('idrole');
				Swal.fire({
					title : 'Informasi',
					text  : `Apakah anda yakin ingin menghapus peran ?`,
					icon  : 'info',
					showCancelButton : true,
					cancelButtonText: 'Tidak',
					confirmButtonText : 'Ya'
				}).then((result)=>{
					if(result.isConfirmed){
						$.ajax({
							url : "{{ route('settings.role.delete') }}",
							method : "DELETE",
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							data : {
								id : id
							},
							beforeSend : function(){
								Swal.fire({
									title: 'Menghapus peran ini !',
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
									html : result.message,
									icon : "success",
									allowEscapeKey: false,
									allowOutsideClick: false,
								}).then(()=>{
									window.location.reload();
								});

							},
							error : function(){
								Swal.fire({
									title : 'Informasi',
									html : error.responseJSON.message,
									icon : 'error',
									allowEscapeKey: false,
									allowOutsideClick: false,
								});
							}
						})
					}
				});
			}

			ubahPeran(e){
				let roleName = $(e.currentTarget).attr('nitip');
				let idRole = $(e.currentTarget).attr('idrole');
				Helper.getPermission(roleName,idRole).then((result)=>{
					Helper.getMenuJstree(idRole).then((result)=>{						
						let clone = Object.assign({}, result.data);
						
						$.map( clone, function( val, i ) {
							val['state'] = {
								checked : val.state,
								opened : true
							}
							return val;
						});

						Index.JSTREE_Main.settings.core.data = Object.values(clone);
                        Index.JSTREE_Main.refresh(true, true);
						Index.MD_RoleModal.modal('show');
					}).catch((message)=>{
						Swal.fire({
							title : 'Informasi',
							html : message,
							icon : 'error',
							allowEscapeKey: false,
							allowOutsideClick: false,
						});
					});
				}).catch((error)=>{
					Swal.fire({
						title : 'Informasi',
						html : error.responseJSON.message,
						icon : 'error',
						allowEscapeKey: false,
						allowOutsideClick: false,
					});
				})
			}

			static getPermission(roleName, idRole){
				return new Promise((resolve, reject) => {
					$.ajax({
						url : "{{ route('settings.role.mypermission') }}",
						method : "POST",
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data : {
							name : roleName
						},
						beforeSend : function(){
							Swal.fire({
								title: 'Mendapatkan izin peran ini !',
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
							$('.allow-permission').prop('checked',false);
							Index.MD_RoleModal.find('h3').text("Ubah peran");
							$('#modalRoleName').val(roleName);
							$('#idRole').val(idRole);
							Index.MD_RoleModal.attr('nitip','edit');
							result.data[0].permissions.forEach((data,index)=>{
								$('#'+data.name.replaceAll(" ","")+"_allow").prop('checked', true);
							});
							resolve(true);
						},
						error : function(error){
							resolve(error);
						}
					});
				});
			}

			static getMenuJstree(role=null){
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url : "{{ route('jstree.menu.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
						data :{
							role
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
			static MD_RoleModal;
			static FRM_addRoleForm;
			static JSTREE_Main;
			static DATA_Menu;

            constructor() {
                super();
                Index.MD_RoleModal = $('#role-modal');
				Index.FRM_addRoleForm = $('#addRoleForm');
				Index.JSTREE_Main = $("#jstree_demo_div").jstree({
                    "core" : {
                    	"check_callback" : true
                    },
					"checkbox": {
                        "three_state": false,
                        "keep_selected_style": false,
                        "whole_node": false,
                        "tie_selection": false
                    },
                    "plugins" : [ "contextmenu","checkbox" ]
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
                return this;
            }

            bindEvent() {
                $('.add-new-role').on('click', this.peran);
				$('#submit').on('click', this.simpan);
				$("#modalRoleName").on('change', this.eventNamaPeran);
				$('.role-edit-modal').on('click', this.ubahPeran);
				$('.hapus-peran').on('click', this.hapusPeran);

                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
				Index.DATA_Menu.data.forEach(function(e,i){
                    Index.JSTREE_Main.create_node(e.parent,{text:e.text,id:e.id});
                });
				Myapp.JSTREE_Main.open_all();
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
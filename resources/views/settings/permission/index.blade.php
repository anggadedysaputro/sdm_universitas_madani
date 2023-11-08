@extends('app')
@section('title')
    Title
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.permission.index"/>
@endsection
@section('page-title')
    Permission
@endsection
@section('action-list')
    <button class="dt-button add-new-permissions btn btn-primary mb-3 mb-md-0 ms-3"><span> <i class="ti ti-plus"></i> Tambah izin</span></button>
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

<div class="col-md-12">
    <div class="card">
        <div class="d-flex justify-content-between p-3">
            <div id="main-show-row"></div>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-vcenter card-table" id="main-table">
            <caption class="ms-4">
                <div id="main-pagging-view"></div>
            </caption>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Ditugaskan untuk</th>
                        <th>Tanggal dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            <tbody>
            </tbody>
          </table>
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
                            <button type="button" class="btn btn-primary me-sm-3 me-1" id="create-permission"><i class="ti ti-device-floppy"></i> Simpan</button>
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

            static editPermission(e){
				let data = $(e.currentTarget).data();
				Index.MD_AddPermissions.modal('show');
				$('#modalPermissionName').val(data.name).trigger('change');
				$('#id-permission').val(data.id);
				Index.MD_AddPermissions.find('h3').text('Ubah nama izin');
				$('#create-permission').attr("nitip","edit");
			}

			static removePermission(e){
				let data = $(e.currentTarget).data();

				Swal.fire({
					title : 'Informasi',
					text  : 'Apakah anda yakin ingin menghapus permission ?',
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
							data : {
								id : data.id
							},
							beforeSend : function(){
								Swal.fire({
									title: 'Menghapus permission!',
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
									Index.SMT_MainTable.draw();
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
								});
							}
						})
					}
				});
			}

            permission(){
				Index.MD_AddPermissions.find('h3').text('Tambah izin baru');
                Index.MD_AddPermissions.modal('show');
				$('#modalPermissionName').val("").trigger('change');
				$('#create-permission').attr('nitip','add');
            }

            changePermissionName(e){
                let eInputPermissionNmae = $(e.currentTarget);
				let vInputPermissionName = eInputPermissionNmae.val() || '';

				if(vInputPermissionName != ''){
					eInputPermissionNmae.removeClass('is-invalid');
					eInputPermissionNmae.next().text('');
				}else{
					eInputPermissionNmae.addClass('is-invalid');
					eInputPermissionNmae.next().text('Masukkan nama izin');
				}
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
									$.ajax({
										url : uri,
										method : method,
										headers: {
											'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										},
										data : {
											nama : vPermissionName,
											id : vPermissionId
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
												Index.SMT_MainTable.draw();
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
			static MD_AddPermissions;
            static SMT_MainTable;
            static CT_Formulir;
            static CT_Main;
            static CT_MainPaggingView;
            static CT_MainShowRow;
            static CT_MainIsi;
            static CT_MainSearch;

            constructor() {
                super();

                Index.MD_AddPermissions = $('#permissions-modal');
                Index.CT_Formulir = $('#container-formulir');
                Index.CT_Main = $('#container-main');
                Index.CT_MainPaggingView = $('#main-pagging-view');
                Index.CT_MainShowRow = $('#main-show-row');
                Index.CT_MainIsi = $('#main-table').find('tbody');
                Index.CT_MainSearch = $('#main-search');

                Index.SMT_MainTable = new AnggaTables({
                    container : Index.CT_Main,
                    containerPaging : Index.CT_MainPaggingView,
                    containerTampilBaris : Index.CT_MainShowRow,
                    containerIsi : Index.CT_MainIsi,
                    containerSearch : Index.CT_MainSearch,
                    customSearchView : `
                        <input type="search" class="form-control ps-5" placeholder="Cari izin" id="global-search-custumizable">
                    `,
                    contentLoading : `
                        <tr>
                            <td colspan="9" class="text-center">Loading data...</td>
                        </tr>
                    `,
                    nodata : `
                        <tr>
                            <td colspan="9" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    `,
                    request : {
                        url : '{{ route('settings.permission.all') }}',
                        data : function(data){
                            return data;
                        },
                    },
                    columns : this.COL_Main,
                    content : function(data){
						let content = ``;
						let role = JSON.parse(data.assign.replace(/&quot;/g,'"')).nama ?? [];
						role.forEach(element => {
							content += `<span class="badge rounded-pill bg-label-primary">${element}</span>`;
						});

                        return `
                            <tr id="row_${data.ids}">
                                <td>${data.name}</td>
                                <td>${content}</td>
                                <td>${data.created_at_view}</td>
								<td>
									<button class="btn btn-sm btn-icon me-2 edit-record"><i class="ti ti-pencil"></i></button>
									<button class="btn btn-sm btn-icon delete-record" fdprocessedid="63pthc"><i class="ti ti-trash"></i></button>
								</td>
                            </tr>
                        `;
                    },
                    createdRow : function(row, data){
                        $(row).find('.delete-record').on('click', Helper.removePermission).data(data);
						$(row).find('.edit-record').on('click', Helper.editPermission).data(data);
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
                $('#create-permission').on('click', this.simpan);
                $('.add-new-permissions').on('click', this.permission);
                $("#modalPermissionName").on('change', this.changePermissionName);
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
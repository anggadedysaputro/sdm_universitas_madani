@extends('app')
@section('title')
    Title
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="settings.user.index"/>
@endsection
@section('page-title')
    User
@endsection
@section('action-list')
    <button class="dt-button add-new-users btn btn-primary mb-3 mb-md-0 ms-3"><span><i class="ti ti-plus"></i> Tambah pengguna</span></button>
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
                        <th>Peran</th>
                        <th>Telpon</th>
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
<div class="col-lg-4 col-md-6">
    <div class="mt-3">
      <div
        class="offcanvas offcanvas-end"
        data-bs-scroll="true"
        tabindex="-1"
        id="offcanvasBoth"
        aria-labelledby="offcanvasBothLabel"
      >
        <div class="offcanvas-header">
          <h5 id="offcanvasBothLabel" class="offcanvas-title">Tambah pengguna</h5>
          <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>
        <div class="offcanvas-body">
            <form class="pt-0 fv-plugins-bootstrap5 fv-plugins-framework" id="addNewUserForm">
                <input class="iduser" name="id" type="hidden"/>
                <div class="mb-3 fv-plugins-icon-container">
                  <label class="form-label" for="add-user-fullname">
                    <i class="bx bx-star"></i> Nama
                  </label>
                  <input type="text" class="form-control" id="add-user-fullname" placeholder="angga dedy saputro" name="name" aria-label="anggadedysaputro" required>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="mb-3 fv-plugins-icon-container" id="wrapper-password">
                    <label class="form-label" for="add-user-fullname">
                        <i class="bx bx-star"></i> Kata sandi
                    </label>
                    <input type="password" class="form-control" id="add-user-password" placeholder="*****" name="password" required autocomplete>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                <div class="mb-3 fv-plugins-icon-container" id="wrapper-ulangi-password">
                    <label class="form-label" for="add-user-fullname">
                        <i class="bx bx-star"></i> Ulangi Kata sandi
                    </label>
                    <input type="password" class="form-control" id="add-user-repassword" placeholder="*****" name="repassword" required autocomplete>
                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label" for="add-user-contact">Telpon</label>
                  <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="083865659266" aria-label="john.doe@example.com" name="telpon">
                </div>
                <div class="mb-3">
                  <label class="form-label" for="add-user-company">Email</label>
                  <input type="text" id="add-user-company" class="form-control" placeholder="angga@gmail.com" aria-label="jdoe1" name="email" required>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="user-role">
                    <i class="bx bx-star"></i> Peran
                  </label>
                  <select id="user-role" class="form-select" name="idrole" required>
                    @foreach ($role as $value)
                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                    @endforeach
                  </select>
                </div>
                <button type="button" class="btn btn-success data-submit"><i class="ti ti-send"></i> Simpan</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas"><i class="ti ti-circle-x"></i> Batal</button>
            <input type="hidden"></form>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="users-modal" tabindex="-1" aria-hidden="true">
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
                            <button type="button" class="btn btn-primary me-sm-3 me-1" id="create-permission">Simpan</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="mbavig">Batal</button>
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
            add(e){
				Index.FRM_Pengguna.find('#wrapper-password').show();
				Index.FRM_Pengguna.find('#wrapper-ulangi-password').show();
				$('#offcanvasBoth').attr('nitip',"add");
				$.each(Index.FRM_Pengguna[0].elements, function(i,e){
					if(e.nodeName == "INPUT"){
						$(e).val("");
					}else if(e.nodeName == "SELECT"){
						$(e).val("").trigger('change');
					}
				});
				Index.CNVS_Add.show();
			}

			simpan(e){
				let data = Index.FRM_Pengguna.serializeObject();
				let proses = true;

				$.each(Index.FRM_Pengguna[0].elements, function(i,e){
					if(e.nodeName == 'INPUT' && e.type == "text" || e.type == "password" || e.type == "hidden"){
						if(e.hasAttribute('required')){
							let val = $(e).val() || '';

							if(val == ''){
								$(e).removeClass('is-valid').addClass('is-invalid');
								proses = false;
							}else{
								$(e).removeClass('is-invalid').addClass('is-valid');
							}
						}
					}else if(e.nodeName == "SELECT"){
						if(e.hasAttribute('required')){
							let val = $(e).val() || '';

							if(val == ''){
								$(e).removeClass('is-valid').addClass('is-invalid');
								proses = false;
							}else{
								$(e).removeClass('is-invalid').addClass('is-valid');
							}
						}
					}
				});

				if( !(data.repassword == data.password)){
					Index.CNVS_Add.hide();
					Swal.fire({
						title : 'Informasi',
						html : 'Password tidak sama!',
						icon : 'info',
						allowEscapeKey: false,
						allowOutsideClick: false,
					}).then(()=>{
						Index.CNVS_Add.show();
					});
					proses = false;
				}

				if(proses){
					Index.CNVS_Add.hide();
					let nitip = $('#offcanvasBoth').attr('nitip');
					let uri = (nitip == "edit" ? "{{ route('settings.user.update') }}" : "{{ route('settings.user.store') }}");
					let text = (nitip == "edit" ? "mengubah" : "membuat");
					let method = (nitip == "edit" ? "PUT" : "POST");

					Swal.fire({
						title : 'Informasi',
						text  : 'Apakah anda yakin ingin '+text+' pengguna ?',
						icon  : 'info',
						showCancelButton : true,
						cancelButtonText: 'Tidak',
						confirmButtonText : 'Ya'
					}).then((result)=>{
						if(result.isConfirmed){
							$.ajax({
								url : uri,
								method,
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								data : data,
								beforeSend : function(result){
									Swal.fire({
										title: 'Membuat pengguna !',
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
										icon : 'success',
										allowEscapeKey: false,
										allowOutsideClick: false,
									}).then(()=>{
										Index.SMT_MainTable.draw();
									});
								},
								error : function(error){
									Swal.fire('Gagal',error.responseJSON.message,'error');
								}
							})
						}else{
							Index.CNVS_Add.show();
						}
					});
				}
			}

			static removeUser(e){
				let data = $(e.currentTarget).parents('tr').data();
				
				Swal.fire({
					title : 'Informasi',
					text  : 'Apakah anda yakin ingin menghapus pengguna ?',
					icon  : 'info',
					showCancelButton : true,
					cancelButtonText: 'Tidak',
					confirmButtonText : 'Ya'
				}).then((result)=>{
					if(result.isConfirmed){
						$.ajax({
							url : "{{ route('settings.user.delete') }}",
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							method : "DELETE",
							data : data,
							beforeSend : function(){
								Swal.fire({
									title: 'Menghapus pengguna!',
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
									icon : 'success',
									allowEscapeKey: false,
									allowOutsideClick: false
								}).then(()=>{
									Index.SMT_MainTable.draw();
								});
							},
							error : function(error){
								Swal.fire('Gagal',error.responseJSON.message,'error');
							}
						})
					}
				});
			}

			static editUser(e){
				let data = $(e.currentTarget).parents('tr').data();
				let idrole = data.roles.length > 0 ? data.roles[0].name : '';
				let map = { password : "pass", repassword : "pass"};
				$('#offcanvasBoth').attr('nitip',"edit");
				Index.FRM_Pengguna.find('#wrapper-password').hide();
				Index.FRM_Pengguna.find('#wrapper-ulangi-password').hide();
				$.each(Index.FRM_Pengguna[0].elements, function(i,e){
					
					if(e.nodeName == "INPUT" && (e.type == "text" || e.type == "password" || e.type == "hidden") ){
						if(map.hasOwnProperty(e.name)){
							$(e).val(data[map[e.name]]);
						}else{
							$(e).val(data[e.name]);
						}

					}else if(e.nodeName == "SELECT"){
						$(e).val(idrole).trigger('change');
					}
				});

				Index.CNVS_Add.show();
			}
        }

        class Index extends Helper{
            // deklarasi variabel
            static SMT_MainTable;
            static CT_Formulir;
            static CT_Main;
            static CT_MainPaggingView;
            static CT_MainShowRow;
            static CT_MainIsi;
            static CT_MainSearch;
			static CNVS_Add;
			static S2_UserRole;
			static S2RAJAX_Object;
			static FRM_Pengguna;
            COL_Main;

            constructor() {
                super();

                Index.CT_Formulir = $('#container-formulir');
                Index.CT_Main = $('#container-main');
                Index.CT_MainPaggingView = $('#main-pagging-view');
                Index.CT_MainShowRow = $('#main-show-row');
                Index.CT_MainIsi = $('#main-table').find('tbody');
                Index.CT_MainSearch = $('#main-search');
				Index.FRM_Pengguna = $('#addNewUserForm');
				Index.CNVS_Add = new bootstrap.Offcanvas($('#offcanvasBoth'));
				Index.S2RAJAX_Object = {
					role : {
						dropdownParent : $('.offcanvas-body'),
						theme : 'bootstrap-5',
                        placeholder : 'Pilih role'
					}
				}
                // console.log(select2);
                this.COL_Main = [
                    {data : "name"},
                    {data : "email"},
                ];
                
				Index.S2_UserRole = $('#user-role').select2(Index.S2RAJAX_Object.role);

                Index.SMT_MainTable = new AnggaTables({
                    container : Index.CT_Main,
                    containerPaging : Index.CT_MainPaggingView,
                    containerTampilBaris : Index.CT_MainShowRow,
                    containerIsi : Index.CT_MainIsi,
                    containerSearch : Index.CT_MainSearch,
                    customSearchView : `
                        <input type="search" class="form-control ps-5" placeholder="Search user" id="global-search-custumizable">
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
                        url : '{{ route('settings.user.all') }}',
                        data : function(data){
                            return data;
                        },
                    },
                    columns : this.COL_Main,
                    content : function(data){
                        let role = data.roles.length > 0 ? data.roles[0].name : '';
                        return `
                            <tr id="row_${data.ids}">
								<td>${data.name}</td>
                                <td>${role}</td>
                                <td>${data.telpon}</td>
                                <td>${data.created_at_view}</td>
								<td>
									<button class="btn btn-warning btn-icon edit-record"><i class="ti ti-pencil"></i></button>
									<button class="btn btn-danger btn-icon delete-record" fdprocessedid="63pthc"><i class="ti ti-trash"></i></button>
								</td>
                            </tr>
                        `;
                    },
                    createdRow : function(row, data){
                        $(row).find('.delete-record').on('click', Helper.removeUser).data(data);
						$(row).find('.edit-record').on('click', Helper.editUser).data(data);
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
                $('.add-new-users').on('click', this.add);
				$('.data-submit').on('click', this.simpan);
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
            new Index().startApp();
        });

    </script>
@endsection
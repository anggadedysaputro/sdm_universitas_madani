@extends('app')
@section('title')
    Tambah karyawan
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="karyawan.add.index"/>
@endsection
@section('page-title')
    Tambah karywan
@endsection
@section('action-list')
    <a href="{{ route('karyawan.index') }}" class="btn btn-primary"><i class="ti ti-users-group"></i> &nbsp;Data karyawan</a>
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
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <div class="small-12 medium-2 large-2 columns">
                    <div class="circle">
                      <img class="profile-pic" src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg">
               
                    </div>
                    <div class="p-image">
                      <i class="ti ti-camera-filled upload-button"></i>
                       <input class="file-upload" type="file" accept="image/*"/>
                    </div>
                 </div>
            </div>
            <div class="col-md-8">
                <div class="d-flex flex-column">
                    <form action="#" id="form-karyawan">
                        <div id="smartwizard">
                            <ul class="nav">
                                <li class="nav-item">
                                <a class="nav-link" href="#step-1">
                                    <div class="num">1</div>
                                    Personal
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#step-2">
                                    <span class="num">2</span>
                                    Kepegawaian
                                </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-3">
                                    <span class="num">3</span>
                                    Payroll
                                    </a>
                                </li>
                            </ul>
                        
                            <div class="tab-content">
                                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                    <div class="d-flex flex-column gap-3">
                                        <h3>Informasi pribadi</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">NIPY</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="NIPY" name="nopeg" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">No kartu keluarga</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="Nomor kartu keluarga" name="nokk" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Nama lengkap</label>
                                                    <input type="text" class="form-control form-step-1" placeholder="Input nama lengkap" name="nama" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Tempat lahir</label>
                                                    <input type="text" class="form-control form-step-1" placeholder="Tempat lahir" name="tempatlahir" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Tanggal lahir</label>
                                                    <input type="text" class="form-control flat-picker form-step-1" placeholder="Tempat lahir" name="tgl_lahir" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label required">Jenis kelamin</label>
                                                <div class="row">
                                                    <div class="col-6 col-sm-4">
                                                        <label class="form-imagecheck mb-2">
                                                        <input name="form-imagecheck-radio" type="radio" value="1" class="form-imagecheck-input form-step-1" name="jns_kel" required>
                                                        <span class="form-imagecheck-figure">
                                                            <img src="{{ asset('assets/ilustration/male.jpg') }}" width="100" height="100"/>
                                                        </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-6 col-sm-4">
                                                        <label class="form-imagecheck mb-2">
                                                        <input name="form-imagecheck-radio" type="radio" value="2" class="form-imagecheck-input form-step-1" checked="" name="jns_kel" required>
                                                        <span class="form-imagecheck-figure">
                                                            <img src="{{ asset('assets/ilustration/female.jpg') }}" width="100" height="100"/>
                                                        </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Status perkawinan</label>
                                                    <select type="text" class="form-select tomselected form-step-1" name="idstatusnikah" required>
                                                        @foreach ($statusnikah as $value)
                                                            <option value="{{ $value->idstatusnikah }}">{{ $value->status }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Golongan darah</label>
                                                    <select type="text" class="form-select tomselected form-step-1" name="gol_darah" required>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="AB">AB</option>
                                                        <option value="O">O</option>
                                                    </select>                       
                                                    <div class="invalid-feedback"></div>                     
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Agama</label>
                                                    <select type="text" class="form-select tomselected form-step-1" name="agama" required>
                                                        @foreach ($agama as $value)
                                                            <option value="{{ $value->id }}">{{ $value->urai }}</option>
                                                        @endforeach
                                                    </select>                                            
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-flex flex-column">
                                                    <label class="form-label required">Kewarganegaraan</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <select type="text" class="form-select tomselected form-step-1" name="kewarganegaraan" required>
                                                                    <option value="WNI" selected>WNI</option>
                                                                    <option value="WNA">WNA</option>
                                                                </select>    
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <select type="text" class="form-select tomselected form-step-1" name="idwarganegara" required>
                                                                    @foreach ($negara as $value)
                                                                        <option value="{{ $value->id }}" {{ strtolower($value->keterangan)=='indonesia' ? 'selected' : '' }}>{{ $value->keterangan }}</option>
                                                                    @endforeach
                                                                </select>  
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3>Informasi kontak</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Tipe kartu identitas</label>
                                                    <select type="text" class="form-select tomselected form-step-1" name="idkartuidentitas" required>
                                                        @foreach ($kartuidentitas as $value)
                                                            <option value="{{ $value->id }}">{{ $value->keterangan }}</option>
                                                        @endforeach
                                                    </select>      
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">ID kartu identitas</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="Input ID kartu identitas" name="noidentitas" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Email</label>
                                                    <input type="text" class="form-control form-step-1 email-mask" placeholder="Email" name="email" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">No. HP</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. HP" name="nohp" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">No. telepon</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. Telepon" name="telp" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">No. telepon darurat</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. telepon darurat" name="notelpdarurat">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Alamat kartu identitas <span class="form-label-description"></label>
                                                    <textarea class="form-control form-step-1" rows="6" placeholder="Alamat kartu identitas" name="alamat" required></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3>Pendidikan terakhir</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Jenjang pendidikan terakhir</label>
                                                    <select type="text" class="form-select tomselected form-step-1" name="kodependidikan" required>
                                                        @foreach ($pendidikan as $value)
                                                            <option value="{{ $value->kodependidikan }}">{{ $value->keterangan }}</option>
                                                        @endforeach
                                                    </select>      
                                                    <div class="invalid-feedback"></div>                                      
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Tahun lulus</label>
                                                    <input type="text" class="form-control form-step-1 flat-picker-years" placeholder="Tahun lulus" name="tahun_lulus" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Nama institusi pendidikan</label>
                                                    <input type="text" class="form-control form-step-1" placeholder="Nama institusi pendidikan" name="namasekolah" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Program studi</label>
                                                    <input type="text" class="form-control form-step-1" placeholder="Program studi" name="prodi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                    <div class="d-flex flex-column gap-3">
                                        <h3>Kepegawaian</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Status karyawan</label>
                                                    <select type="text" class="form-select tomselected form-step-2" name="idstatuspegawai" required>
                                                        @foreach ($statuspegawai as $value)
                                                            <option value="{{ $value->idstatuspegawai }}">{{ $value->keterangan }}</option>
                                                        @endforeach
                                                    </select>       
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Tanggal bergabung</label>
                                                    <input type="text" class="form-control flat-picker form-step-2" placeholder="Tanggal bergabung" name="tgl_masuk" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Pilih organisasi</label>
                                                    <div class="row g-2">
                                                      <div class="col">
                                                        <input type="hidden">
                                                        <input type="text" class="form-control" placeholder="Klik tombol cari.." disabled name="organisasi">
                                                      </div>
                                                      <div class="col-auto">
                                                        <a href="#" class="btn btn-icon" aria-label="Button" id="search-organisasi">
                                                          <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                                                        </a>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Jabatan struktural</label>
                                                    <select type="text" class="form-select tomselected" name="kodestruktural">
                                                    </select>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Jabatan fungsional</label>
                                                    <select type="text" class="form-select tomselected" name="kodejabfung">
                                                    </select>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                    <div class="d-flex flex-column gap-3">
                                        <h3>NPWP</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="NPWP" name="npwp">
                                                </div>
                                            </div>
                                        </div>
                                        <h3>Rekening BANK</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="Nomor rekening bank" name="rek_bank">
                                                </div>
                                            </div>
                                        </div>
                                        <h3>BPJS</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No KPJ BPJS ketenagakerjaan</label>
                                                    <input type="text" class="form-control" placeholder="Tempat lahir" name="no_bpjs_ketenagakerjaan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Efektif <i class="ti ti-info-circle-filled"></i></label>
                                                    <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" name="tgl_bpjs_ketenagakerjaan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No BPJS kesehatan</label>
                                                    <input type="text" class="form-control" placeholder="Tempat lahir" name="no_bpjs_kesehatan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Efektif <i class="ti ti-info-circle-filled"></i></label>
                                                    <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" name="tgl_bpjs_kesehatan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </form>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-default me-1" id="kembali">Kembali</button>
                        <button class="btn btn-primary me-1" id="selanjutnya">Selanjutnya</button>
                        <button class="btn btn-success" id="simpan" style="display: none;">Simpan</button>
                    </div>
                </div>
            </div>
            <div class="col-md-2">

            </div>
        </div>
        
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-main">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Daftar fungsional</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <div id="organisasi"></div>
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

            static assignLocalStorage() {
                localStorage.removeItem(Index.LCS_Formulir);
                localStorage.setItem(Index.LCS_Formulir, JSON.stringify(Index.FRM_Main.serializeObject()));
            }

            static validate(step){
                const elements = Index.FRM_Main.find('.'+step);
                let allow = true;
                let scroll = true;
                $.each(elements, function(i,e){
                    $(e).removeClass('is-invalid');
                    if(e.nodeName == 'INPUT' && e.type == 'text' || e.nodeName == 'TEXTAREA' || e.nodeName == 'SELECT'){
                        if($(e).val() == '' && $(e).attr('required')){
                            $(e).next().text($(e).attr('placeholder')+' belum disii!');
                            $(e).addClass('is-invalid');
                            allow = false;
                            if(scroll) $(window).scrollTop($(e).position().top);
                            scroll = false;
                        };
                    }
                });

                Myapp.WIZARD_Main.smartWizard("fixHeight");
                return allow;
            }

            static verify(){
                let stepInfo = Index.WIZARD_Main.smartWizard("getStepInfo");
                let next = false;
                Index.BTN_Simpan.hide();
                Index.BTN_Next.show();

                if(stepInfo.currentStep == 0){
                    next = Helper.validate('form-step-1');
                }else if(stepInfo.currentStep == 1){
                    next = Helper.validate('form-step-2');
                    if(next){
                        Index.BTN_Next.hide();
                        Index.BTN_Simpan.show();
                    }
                }
                
                if(next) Index.WIZARD_Main.smartWizard('next');
            }

            next(){     
                Helper.verify();          
                Helper.assignLocalStorage();
            }
            simpan(){
                let data = Index.FRM_Main.serializeObject();
                let alamat = Index.FRM_Main.find('textarea[name="alamat"]').val();
                data = $.extend(data, {alamat});
                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin menyimpan data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('karyawan.add.store') }}",
                            method : "POST",
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
                                    window.location.href = "{{ route('karyawan.index') }}";
                                });
                            },
                            error : function(error){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }
            previous(){
                Index.BTN_Next.show();
                Index.BTN_Simpan.hide();
                Index.WIZARD_Main.smartWizard('prev');
            }
            showCanvas(){
                Index.OFFCNVS_Main.show();
            }
            selectedOrg(node,selected,event){
                if(selected.node.original.id == '0'){
                    Swal.fire('Informasi','Tidak boleh memilih yayasan','info');
                }else{
                    Index.FRM_Main.find('input[name="organisasi"]').val(selected.node.original.text).prev().val(selected.node.original.id);
                    Index.OFFCNVS_Main.hide();
                    Angga.setValueSelect2AjaxRemote(Index.S2_JabatanFungsional,{text : '', id:''});
                    Angga.setValueSelect2AjaxRemote(Index.S2_JabatanStruktural,{text : '', id:''});
                }
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
            static WIZARD_Main;
            static BTN_Next;
            static BTN_Previous;
            static BTN_Simpan;
            static BTN_SearchOrg;
            static FRM_Main;
            static LCS_Formulir;
            static S2_JabatanStruktural;
            static S2_JabatanFungsional;
            static JSTREE_Main;
            static DATA_Menu;
            static OFFCNVS_Main;

            constructor() {
                super();  
                Index.JSTREE_Main = $("#organisasi").jstree({
                    "core" : {
                    "check_callback" : true
                    }
                });

                Index.JSTREE_Main = $.jstree.reference(Index.JSTREE_Main);
                Index.OFFCNVS_Main = new bootstrap.Offcanvas(document.getElementById('canvas-main'));

                Index.LCS_Formulir = 'formulir_sdm_icbb_';
                Index.WIZARD_Main = $("#smartwizard").smartWizard({
                    theme: 'dots', 
                    toolbar: {
                        position: 'none', // none|top|bottom|both
                        showNextButton: true, // show/hide a Next button
                        showPreviousButton: true, // show/hide a Previous button
                        extraHtml: '' // Extra html to show on toolbar
                    },
                    enableUrlHash : false,
                    keyboard: {
                        keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                    },
                }); 

                Index.BTN_Next = $('#selanjutnya');
                Index.BTN_Previous = $('#kembali');
                Index.BTN_Simpan = $('#simpan');

                flatpickr('.flat-picker',{
                    disableMobile: "true",
                    dateFormat: "j F Y",
                });
                flatpickr('.flat-picker-years',{
                    disableMobile: "true",
                    dateFormat: "Y",
                    plugins: [
                        new monthSelectPlugin({
                        shorthand: false, //defaults to false
                        dateFormat: "Y", //defaults to "F Y"
                        altFormat: "Y", //defaults to "F Y"
                        })
                    ]
                });
                Index.FRM_Main = $('#form-karyawan');
                Index.S2_JabatanFungsional = Index.FRM_Main.find('select[name="kodejabfung"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.fungsional.data') }}','Pilih jabatan fungsional'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_Main.find('input[name="organisasi"]').prev().val();
                                    const $request = $.ajax(params);
                                    $request.then(success);
                                    $request.fail(failure);
                                    return $request;
                                }
                            }
                        }
                    )
                );
                Index.S2_JabatanStruktural = Index.FRM_Main.find('select[name="kodestruktural"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.struktural.data') }}','Pilih jabatan struktural'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_Main.find('input[name="organisasi"]').prev().val();
                                    const $request = $.ajax(params);
                                    $request.then(success);
                                    $request.fail(failure);
                                    return $request;
                                }
                            }
                        }
                    )
                );
                Index.BTN_SearchOrg = $('#search-organisasi');
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
                return this;
            }

            bindEvent() {
                // console.log(Index.BTN_Next);
                Index.BTN_Next.on('click', this.next);
                Index.BTN_Previous.on('click', this.previous);
                Index.BTN_SearchOrg.on('click', this.showCanvas);
                Index.JSTREE_Main.element.on('select_node.jstree', this.selectedOrg);
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
                // $('#smartwizard').SmartWizard();
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
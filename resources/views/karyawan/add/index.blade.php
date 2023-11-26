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

            </div>
            <div class="col-md-8">
                <div class="d-flex flex-column">
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
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nama lengkap</label>
                                                <input type="text" class="form-control" placeholder="Nama lengkap" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tempat lahir</label>
                                                <input type="text" class="form-control" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal lahir</label>
                                                <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis kelamin</label>
                                            <div class="row">
                                                <div class="col-6 col-sm-4">
                                                    <label class="form-imagecheck mb-2">
                                                      <input name="form-imagecheck-radio" type="radio" value="1" class="form-imagecheck-input">
                                                      <span class="form-imagecheck-figure">
                                                        <img src="{{ asset('assets/ilustration/male.jpg') }}" width="100" height="100"/>
                                                      </span>
                                                    </label>
                                                  </div>
                                                  <div class="col-6 col-sm-4">
                                                    <label class="form-imagecheck mb-2">
                                                      <input name="form-imagecheck-radio" type="radio" value="2" class="form-imagecheck-input" checked="">
                                                      <span class="form-imagecheck-figure">
                                                        <img src="{{ asset('assets/ilustration/female.jpg') }}" width="100" height="100"/>
                                                      </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Status perkawinan</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">Menikah</option>
                                                    <option value="3">Belum Menikah</option>
                                                    <option value="4">Janda</option>
                                                    <option value="1">Duda</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Golongan darah</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">A</option>
                                                    <option value="3">B</option>
                                                    <option value="4">AB</option>
                                                    <option value="1">O</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Agama</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">Islam</option>
                                                    <option value="3">Kristen</option>
                                                    <option value="4">Hindu</option>
                                                    <option value="1">Budha</option>
                                                    <option value="1">Konghuchu</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex flex-column">
                                                <label class="form-label">Kewarganegaraan</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <select type="text" class="form-select tomselected" id="select-users">
                                                                <option value="2">WNI</option>
                                                                <option value="3">WNA</option>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <select type="text" class="form-select tomselected" id="select-users">
                                                                <option value="2">Afrika</option>
                                                                <option value="3">Andalusia</option>
                                                                <option value="3">Indonesia</option>
                                                            </select>  
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
                                                <label class="form-label">Tipe kartu identitas</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">KTP</option>
                                                    <option value="3">Passport</option>
                                                    <option value="4">Kartu izin tinggal terbatas (KITAS)</option>
                                                    <option value="4">Kartu izin tinggal tetap (KITAP)</option>
                                                    <option value="1">Surat izin mengemudi (SIM)</option>
                                                    <option value="1">Lainnya</option>
                                                </select>      
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">ID kartu identitas</label>
                                                <input type="text" class="form-control" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" placeholder="Email" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">No. HP</label>
                                                <input type="text" class="form-control" placeholder="No. HP" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">No. Telepon</label>
                                                <input type="text" class="form-control" placeholder="No. Telepon" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Alamat kartu identitas <span class="form-label-description"></label>
                                                <textarea class="form-control" name="example-textarea-input" rows="6" placeholder="Alamat kartu identitas"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Pendidikan terakhir</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Jenjang pendidikan terakhir</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">SD</option>
                                                    <option value="3">SMP</option>
                                                    <option value="4">SMA</option>
                                                    <option value="1">SMK</option>
                                                    <option value="1">S1</option>
                                                    <option value="1">S2</option>
                                                    <option value="1">S3</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama institusi pendidikan</label>
                                                <input type="text" class="form-control" placeholder="Nama institusi pendidikan" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Program studi</label>
                                                <input type="text" class="form-control" placeholder="Program studi" fdprocessedid="hd92zs">
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
                                                <label class="form-label">Status karyawan</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">Tetap permanen</option>
                                                    <option value="3">Tetap percobaan</option>
                                                    <option value="4">PKWT</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal bergabung</label>
                                                <input type="text" class="form-control flat-picker" placeholder="Tanggal bergabung" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan struktural</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">Kabit IT</option>
                                                    <option value="3">Sekretaris</option>
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan fungsional</label>
                                                <select type="text" class="form-select tomselected" id="select-users">
                                                    <option value="2">IT support</option>
                                                    <option value="3">front end dev</option>
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
                                            <div class="d-flex flex-column">
                                                <label class="form-label">NPWP</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <select type="text" class="form-select tomselected" id="select-users">
                                                                <option value="2">K0 - kawin, tanggungan 0</option>
                                                                <option value="3">K1 - kawin, tanggungan 1</option>
                                                                <option value="3">K2 - kawin, tanggungan 2</option>
                                                                <option value="3">K3 - kawin, tanggungan 3</option>
                                                            </select>    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" placeholder="NPWP" fdprocessedid="hd92zs">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <h3>BPJS</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">No KPJ BPJS ketenagakerjaan</label>
                                                <input type="text" class="form-control" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Efektif <i class="ti ti-info-circle-filled"></i></label>
                                                <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">No BPJS kesehatan</label>
                                                <input type="text" class="form-control" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Efektif <i class="ti ti-info-circle-filled"></i></label>
                                                <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" fdprocessedid="hd92zs">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-default me-1" id="kembali">Kembali</button>
                        <button class="btn btn-primary" id="selanjutnya">Selanjutnya</button>
                    </div>
                </div>
            </div>
            <div class="col-md-2">

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

            next(){
                Index.WIZARD_Karyawan.smartWizard('next');
            }
            previous(){
                Index.WIZARD_Karyawan.smartWizard('prev');
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static WIZARD_Karyawan;
            static BTN_Next;
            static BTN_Previous;

            constructor() {
                super();  
                Index.WIZARD_Karyawan = $("#smartwizard").smartWizard({
                    theme: 'dots', 
                    toolbar: {
                        position: 'none', // none|top|bottom|both
                        showNextButton: true, // show/hide a Next button
                        showPreviousButton: true, // show/hide a Previous button
                        extraHtml: '' // Extra html to show on toolbar
                    },
                }); 

                Index.BTN_Next = $('#selanjutnya');
                Index.BTN_Previous = $('#kembali');
                flatpickr('.flat-picker',{
                    disableMobile: "true",
                    dateFormat: "j F Y",
                })
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
                // console.log(Index.BTN_Next);
                Index.BTN_Next.on('click', this.next);
                Index.BTN_Previous.on('click', this.previous);
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
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
@extends('app')
@section('title')
    Karyawan
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="karyawan.index"/>
@endsection
@section('page-title')
    Karyawan
@endsection
@section('action-list')
    <a href="#" class="btn btn-info" id="btn-upload"><i class="ti ti-upload"></i> Upload Excel</a>
    <a href="{{ route('karyawan.template') }}" class="btn btn-success"><i class="ti ti-download"></i> Download template</a>
    <a href="{{ route('karyawan.add.index') }}" class="btn btn-primary"><i class="ti ti-plus"></i> Tambah karyawan</a>
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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card" id="form-upload">
        <div class="card-body">
            <form action="{{ route('karyawan.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div class="form-label">Pilih file excel</div>
                            <input type="file" class="form-control" accept=".xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success"><i class="ti ti-send"></i> Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="display responsive" id="table-main" class="row-border" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="all checboxs"></th>
                                <th class="all dt-responsive-control"></th>
                                <th class="all nopeg">Nomor Pegawai</th>
                                <th class="informasi-pribadi nama">Nama</th>
                                <th class="informasi-pribadi tanggal_lahir">Tanggal lahir</th>
                                <th class="informasi-pribadi jenis_kelamin">Jenis kelamin</th>
                                <th class="informasi-pribadi golongan_daran">Golongan darah</th>
                                <th class="informasi-pribadi agama">Agama</th>
                                <th class="informasi-pribadi status_perkawinan">Status perkawinan</th>
                                <th class="informasi-pribadi kewarganegaraan">Kewarganegaraan</th>
                                <th class="informasi-pribadi negara">Negara</th>
                                <th class="kontak tipe_kartu_identitas">Tipe kartu identitas</th>
                                <th class="kontak nomor_kartu_identitas">Nomor kartu identitas</th>
                                <th class="kontak alamat">Alamat</th>
                                <th class="kontak no_telepon_darurat">No. telepon darurat</th>
                                <th class="kontak email">Email</th>
                                <th class="kepegawaian status_pegawai">Status pegawai</th>
                                <th class="kepegawaian tanggal_bergabung">Tanggal bergabung</th>
                                <th class="kepegawaian jabatan_fungsional">Jabatan fungsional</th>
                                <th class="kepegawaian jabatan_struktural">Jabatan struktural</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="modal-error">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data yang perlu di perbaiki</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="wrapper-personal">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA PERSONAL</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-personal" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Nama lengkap *</td>
                                    <td>Nama panggilan</td>
                                    <td>Tipe kartu identitas * 📦</td>
                                    <td>ID kartu identitas * 🔢</td>
                                    <td>Tempat lahir *</td>
                                    <td>Tanggal lahir * 📆</td>
                                    <td>Jenis kelamin * 📦</td>
                                    <td>Golongan darah * 📦</td>
                                    <td>Alamat kartu identitas</td>
                                    <td>Alamat domisili</td>
                                    <td>Agama * 📦</td>
                                    <td>Status perkawinan * 📦</td>
                                    <td>Kewarganegaraan * 📦</td>
                                    <td>Negara * 📦</td>
                                    <td>No. HP * 🔢</td>
                                    <td>No. telepon 🔢</td>
                                    <td>No. telepon darurat 🔢</td>
                                    <td>Email * 📧</td>
                                    <td>Foto Diri * 📤</td>
                                    <td>No NPWP 🔢</td>
                                    <td>Foto NPWP 📤</td>
                                    <td>No BPJS kesehatan 🔢</td>
                                    <td>Tanggal Efektif No BPJS kesehatan 📆</td>
                                    <td>Foto BPJS Kesehatan 📤</td>
                                    <td>No. KPJ BPJS ketenagakerjaan 🔢</td>
                                    <td>Tanggal Efektif No KPJ BPJS ketenagakerjaan 📆</td>
                                    <td>Foto BPJS Ketenagakerjaan 📤</td>
                                    <td>No Rekening</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-keluarga">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA KELUARGA</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-keluarga" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>No kartu keluarga * 🔢</td>
                                    <td>Nama kepala keluarga *</td>
                                    <td>Nama keluarga darurat</td>
                                    <td>No. telepon keluarga darurat 🔢</td>
                                    <td>Nama *</td>
                                    <td>Hubungan * 📦</td>
                                    <td>Tempat lahir</td>
                                    <td>Tanggal lahir 📆</td>
                                    <td>No. telepon 🔢</td>
                                    <td>Alamat</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-pekerjaan">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA PEKERJAAN</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-pekerjaan" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Status karyawan * 📦</td>
                                    <td>Tgl. Masuk Yayasan * 📆</td>
                                    <td>Tgl. Berakhir Kontrak 📆</td>
                                    <td>Masa Bakti 🔢</td>
                                    <td>Pilih Organisasi * 📦</td>
                                    <td>Jabatan struktural 📦</td>
                                    <td>Jabatan fungsional 📦</td>
                                    <td>Tugas tambahan</td>
                                    <td>Dok. Surat Penjanjian Kerja 📤</td>
                                    <td>Dok. Pakta Integritas 📤</td>
                                    <td>Dok. Hasil Test 📤</td>
                                    <td>Dok. Hasil Interview 📤</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-pendidikan">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA PENDIDIKAN</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-pendidikan" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Jenjang pendidikan terakhir * 📦</td>
                                    <td>Tahun lulus * 📦</td>
                                    <td>Nama Lembaga Pendidikan *</td>
                                    <td>Program studi</td>
                                    <td>Dok. Ijazah 📤</td>
                                    <td>Dok. Transkrip Nilai 📤</td>
                                    <td>Gelar</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-sertifikat">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA SERTIFIKAT</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-sertifikat" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Nomor sertifikat *</td>
                                    <td>Jenis sertifikat * 📦</td>
                                    <td>Lembaga penyelenggara</td>
                                    <td>Tahun * 📦</td>
                                    <td>Biaya * 🔢</td>
                                    <td>Jenis biaya * 📦</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-kompetensi">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA KOMPETENSI</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-kompetensi" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Kompetensi Hard Skill</td>
                                    <td>Kompetensi Soft Skill</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-pengalaman-kerja">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA PENGALAMAN KERJA</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-pengalaman-kerja" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Dari tahun * 📦</td>
                                    <td>Sampai tahun * 📦</td>
                                    <td>Jabatan</td>
                                    <td>Paklaring</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="row" id="wrapper-fasilitas">
                    <div class="col-md-12 mb-3">
                        <span class="badge bg-primary text-white">DATA FASILITAS</span>
                    </div>
                    <div class="col-md-12 table-responsive mb-3">
                        <table class="table table-bordered" id="table-fasilitas" style="width:100%;">
                            <thead>
                                <tr>
                                    <td>Nomor Baris File Excel</td>
                                    <td>Nomor pegawai * 🔢</td>
                                    <td>Biaya Tempat Tinggal Pertahun 🔢</td>
                                    <td>Jumlah beras Perkg 🔢</td>
                                    <td>Merk kendaraan</td>
                                    <td>Tahun kendaraan 📦</td>
                                    <td>Nama lembaga beasiswa pendidikan</td>
                                    <td>Biaya beasiswa per semester 🔢</td>
                                    <td>anak ke 🔢</td>
                                    <td>Jenjang pendidikan 📦</td>
                                    <td>Jenis biaya pendidikan</td>
                                    <td>Besaran dispensasi 🔢</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
            triggeredButtonDTMain( e, buttonApi, dataTable, node, config ){
                dataTable.columns.adjust();
            }
            triggeredSelectDTMain(e, dt, type, indexes){
                let rowData = Index.DT_Main.rows(indexes).data().toArray()[0];
                window.location.href = "{{ url('karyawan/edit/index') }}"+"/"+rowData.nopeg;
            }
            showUpload(){
                $('#form-upload').toggle();
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static DT_Main;
            static BTN_Upload;
            static ErrorData;
            static DT_Personal;
            static DT_Keluarga;
            static DT_Pekerjaan;
            static DT_Pendidikan;
            static DT_Sertifikat;
            static DT_PengalamanKerja;
            static DT_Kompetensi;
            static DT_Fasilitas;
            static HasAnyError;
            static MD_Error;

            constructor() {
                super();
                Index.MD_Error = $('#modal-error');
                Index.ErrorData = @json(session('error_data')) ?? {
                    "DATA PERSONAL" : [],
                    "DATA KELUARGA" : [],
                    "DATA PEKERJAAN" : [],
                    "DATA PENDIDIKAN" : [],
                    "DATA SERTIFIKAT" : [],
                    "DATA KOMPETENSI" : [],
                    "DATA PENGALAMAN KERJA" : [],
                    "DATA FASILITAS" : []
                };

                Index.HasAnyError = Object.values(Index.ErrorData).some(arr => arr.length > 0);

                Index.DT_Fasilitas = $('#table-fasilitas').DataTable({
                    data : Index.ErrorData['DATA FASILITAS'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"biaya_tempat_tinggal_pertahun"},
                        {"data":"jumlah_beras_kg"},
                        {"data":"merk_kendaraan"},
                        {"data":"tahun_kendaraan"},
                        {"data":"nama_lembaga_beasiswa_pendidikan"},
                        {"data":"biaya_beasiswa_per_semester"},
                        {"data":"anak_ke"},
                        {"data":"idjenjangpendidikan"},
                        {"data":"jenis_biaya_pendidikan"},
                        {"data":"besaran_dispensasi"}
                    ]
                });

                Index.DT_PengalamanKerja = $('#table-pengalaman-kerja').DataTable({
                    data : Index.ErrorData['DATA PENGALAMAN KERJA'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"dari_tahun"},
                        {"data":"sampai_tahun"},
                        {"data":"jabatan"},
                        {"data":"paklaring"}
                    ]
                });

                Index.DT_Kompetensi = $('#table-kompetensi').DataTable({
                    data : Index.ErrorData['DATA KOMPETENSI'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"kompetensi_hard_skill"},
                        {"data":"kompetensi_soft_skill"}
                    ]
                });

                Index.DT_Sertifikat = $('#table-sertifikat').DataTable({
                    data : Index.ErrorData['DATA SERTIFIKAT'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"nomor_sertifikat"},
                        {"data":"idjenissertifikat"},
                        {"data":"lembaga_penyelenggara"},
                        {"data":"tahun"},
                        {"data":"biaya"},
                        {"data":"idjenisbiaya"}
                    ]
                });

                Index.DT_Pendidikan = $('#table-pendidikan').DataTable({
                    data : Index.ErrorData['DATA PENDIDIKAN'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"kodependidikan"},
                        {"data":"tahun_lulus"},
                        {"data":"namasekolah"},
                        {"data":"prodi"},
                        {"data":"dok_ijazah"},
                        {"data":"dok_transkrip_nilai"},
                        {"data":"gelar"}
                    ]
                });

                Index.DT_Keluarga = $('#table-keluarga').DataTable({
                    data : Index.ErrorData['DATA KELUARGA'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"nokk"},
                        {"data":"nama_kepala_keluarga"},
                        {"data":"nama_keluarga_darurat"},
                        {"data":"telp_keluarga_darurat"},
                        {"data":"nama"},
                        {"data":"hubungan"},
                        {"data":"tempatlahir"},
                        {"data":"tgllahir"},
                        {"data":"telp"},
                        {"data":"alamat"}
                    ]
                });

                Index.DT_Pekerjaan = $('#table-pekerjaan').DataTable({
                    data : Index.ErrorData['DATA PEKERJAAN'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data":"idstatuspegawai"},
                        {"data":"tgl_masuk"},
                        {"data":"tgl_berakhir_kontrak"},
                        {"data":"masa_bakti"},
                        {"data":"idbidang"},
                        {"data":"idjabatanstruktural"},
                        {"data":"idjabatanfungsional"},
                        {"data":"tugas_tambahan"},
                        {"data":"dok_surat_perjanjian_kerja"},
                        {"data":"dok_pakta_integritas"},
                        {"data":"dok_hasil_test"},
                        {"data":"dok_hasil_interview"}
                    ]
                });

                Index.DT_Personal = $('#table-personal').DataTable({
                    data : Index.ErrorData['DATA PERSONAL'],
                    columns : [
                        {"data" : "nomor_baris"},
                        {"data" : "nopeg"},
                        {"data" : "nama"},
                        {"data" : "nama_panggilan"},
                        {"data":"idkartuidentitas"},
                        {"data":"noidentitas"},
                        {"data":"tempatlahir"},
                        {"data":"tgl_lahir"},
                        {"data":"jns_kel"},
                        {"data":"gol_darah"},
                        {"data":"alamat"},
                        {"data":"alamat_domisili"},
                        {"data":"idagama"},
                        {"data":"idstatusnikah"},
                        {"data":"jns_kel"},
                        {"data":"idnegara"},
                        {"data":"nohp"},
                        {"data":"telp"},
                        {"data":"notelpdarurat"},
                        {"data":"email"},
                        {"data":"gambar"},
                        {"data":"npwp"},
                        {"data":"foto_npwp"},
                        {"data":"no_bpjs_kesehatan"},
                        {"data":"tgl_bpjs_kesehatan"},
                        {"data":"foto_bpjs_kesehatan"},
                        {"data":"no_bpjs_ketenagakerjaan"},
                        {"data":"tgl_bpjs_ketenagakerjaan"},
                        {"data":"foto_bpjs_ketenagakerjaan"},
                        {"data":"rekbank"}
                    ]
                });

                Index.BTN_Upload = $('#btn-upload');
                Index.DT_Main = $('#table-main').DataTable( {
                    dom: 'Blfrtip',
                    language: {
                        searchPanes: {
                            collapse: {
                                0: 'Filter by column',
                                _: 'Filter by column (%d)',
                            }
                        }
                    },
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All']
                    ],
                    serverSide : true,
                    processing : true,
                    ajax : {
                        url : "{{ route('karyawan.data') }}",
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    order: [[3, 'desc']],
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                    columns : [
                        {
                            data : null,
                            defaultContent : ""
                        },
                        {
                            data : null,
                            defaultContent : ""
                        },
                        {
                            data : "nopeg"
                        },
                        {
                            data : "nama"
                        },
                        {
                            data : "tanggal_lahir"
                        },
                        {
                            data : "jenis_kelamin"
                        },

                        {
                            data : "gol_darah"
                        },
                        {
                            data : "agama"
                        },
                        {
                            data : "status_nikah"
                        },
                        {
                            data : "kewarganegaraan"
                        },
                        {
                            data : "negara"
                        },
                        {
                            data : "nama_kartuidentitas"
                        },

                        {
                            data : "noidentitas"
                        },
                        {
                            data : "alamat"
                        },

                        {
                            data : "notelpdarurat"
                        },
                        {
                            data : "email"
                        },
                        {
                            data : "status_pegawai"
                        },
                        {
                            data : "tanggal_bergabung"
                        },
                        {
                            data : "jabatan_fungsional"
                        },
                        {
                            data : "jabatan_struktural"
                        },
                    ],
                    responsive: {
                        details: {
                            type : 'column',
                            target:1
                        }
                    },
                    columnDefs: [
                        {
                            orderable: false,
                            className: 'select-checkbox',
                            targets: 0
                        },
                        {
                            className: 'dtr-control',
                            orderable: false,
                            targets: 1
                        },
                        {
                            targets: [
                                'informasi-pribadi',
                                'all'
                            ],
                            visible: true
                        },
                        { targets: '_all', visible: false },
                        {
                            searchPanes: {
                                show: true
                            },
                            targets: ['status_pegawai','nama','nomor_kartu_identitas','agama','jabatan_fungsional','jabatan_struktural']
                        }
                    ],
                    // order: [[2, 'desc']],
                    buttons: [
                        {
                            extend: 'colvisGroup',
                            text: 'Informasi pribadi',
                            show: ['.informasi-pribadi'],
                            hide: ['.kontak','.kepegawaian']
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Kontak',
                            show: ['.kontak'],
                            hide: ['.informasi-pribadi','.kepegawaian']
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Kepegawaian',
                            show: ['.kepegawaian'],
                            hide: ['.informasi-pribadi','.kontak']
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Show all',
                            show: ':hidden'
                        },
                        {
                            extend: 'searchPanes',

                            config: {
                                layout: 'columns-3',
                                cascadePanes: true,
                                viewTotal: true
                            }
                        }
                    ]
                } );
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
                $('.dataTables_length').addClass('me-3');
                $('#form-upload').hide();
                if(Index.ErrorData['DATA PERSONAL'].length == 0) $('#wrapper-personal').hide();
                if(Index.ErrorData['DATA KELUARGA'].length == 0) $('#wrapper-keluarga').hide();
                if(Index.ErrorData['DATA PEKERJAAN'].length == 0) $('#wrapper-pekerjaan').hide();
                if(Index.ErrorData['DATA PENDIDIKAN'].length == 0) $('#wrapper-pendidikan').hide();
                if(Index.ErrorData['DATA SERTIFIKAT'].length == 0) $('#wrapper-sertifikat').hide();
                if(Index.ErrorData['DATA KOMPETENSI'].length == 0) $('#wrapper-kompetensi').hide();
                if(Index.ErrorData['DATA PENGALAMAN KERJA'].length == 0) $('#wrapper-pengalaman-kerja').hide();
                if(Index.ErrorData['DATA FASILITAS'].length == 0) $('#wrapper-fasilitas').hide();

                if(Index.HasAnyError) Index.MD_Error.modal('show');
                return this;
            }

            bindEvent() {
                Index.DT_Main.on('buttons-action', this.triggeredButtonDTMain);
                Index.DT_Main.on('select', this.triggeredSelectDTMain);
                Index.BTN_Upload.on('click', this.showUpload);
                document.getElementById('form-upload').addEventListener('submit', function (e) {
                    const confirmed = confirm("Apakah Anda yakin ingin mengunggah file ini?");
                    if (!confirmed) {
                        e.preventDefault(); // Batalkan pengiriman form jika user membatalkan
                    }
                });

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

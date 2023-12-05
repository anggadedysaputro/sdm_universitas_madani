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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="display responsive" id="table-main" class="row-border" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="all">NIPY</th>
                                <th class="informasi-pribadi">Nama</th>
                                <th class="informasi-pribadi">Tanggal lahir</th>
                                <th class="informasi-pribadi">Jenis kelamin</th>
                                <th class="informasi-pribadi">Golongan darah</th>
                                <th class="informasi-pribadi">Agama</th>
                                <th class="informasi-pribadi">Status perkawinan</th>
                                <th class="informasi-pribadi">Kewarganegaraan</th>
                                <th class="kontak">Tipe kartu identitas</th>
                                <th class="kontak">Nomor kartu identitas</th>
                                <th class="kontak">Alamat</th>
                                <th class="kontak">No. telepon darurat</th>
                                <th class="kontak">Email</th>
                                <th class="kepegawaian">Status pegawai</th>
                                <th class="kepegawaian">Tanggal bergabung</th>
                                <th class="kepegawaian">Jabatan fungsional</th>
                                <th class="kepegawaian">Jabatan struktural</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static DT_Main;

            constructor() {
                super();
                Index.DT_Main = $('#table-main').DataTable( {
                    dom: 'Bfrtip',
                    serverSide : true,
                    processing : true,
                    ajax : {
                        url : "{{ route('karyawan.data') }}",
                        type : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns : [
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
                            data : "alamat"
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
                            data : "kewarganegaraan"
                        },
                        {
                            data : "status_nikah"
                        },
                        
                        {
                            data : "nama_kartuidentitas"
                        },
                        {
                            data : "noidentitas"
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
                        details: true
                    },
                    fixedColumns: {
                        left: 0,
                        right: 1
                    },
                    columnDefs: [
                        { targets: [0,1,2,3,4,5,6,7,8], visible: true},
                        { targets: '_all', visible: false },
                        {
                            searchPanes: {
                                show: true
                            },
                            targets: [0,1]
                        },
                        {
                            searchPanes: {
                                show: false
                            },
                            targets: [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]
                        }
                    ],
                    buttons: [
                        {
                            extend: 'colvisGroup',
                            text: 'Informasi pribadi',
                            show: [0, 1, 2,4,5,6,7,8],
                            hide: [9,10,3,11,12,13,14,15,16]
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Kontak',
                            show: [0,9, 10,3,11,12],
                            hide: [ 1, 2,4,5,6,7,8,13,14,15,16]
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Kepegawaian',
                            show: [0,13,14,15,16],
                            hide: [1,2,3,4,5,6,7,8,9,10,11,12]
                        },
                        {
                            extend: 'colvisGroup',
                            text: 'Show all',
                            show: ':hidden'
                        },
                        {
                            extend: 'searchPanes',
                            config: {
                                
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
                return this;
            }

            bindEvent() {
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
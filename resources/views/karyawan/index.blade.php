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
                                <th class="all checboxs"></th>
                                <th class="all dt-responsive-control"></th>
                                <th class="all nipy">NIPY</th>
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
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static DT_Main;

            constructor() {
                super();
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
                return this;
            }

            bindEvent() {
                Index.DT_Main.on('buttons-action', this.triggeredButtonDTMain);
                Index.DT_Main.on('select', this.triggeredSelectDTMain);
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
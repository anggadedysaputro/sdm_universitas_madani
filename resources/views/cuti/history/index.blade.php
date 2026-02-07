@extends('app')
@section('title')
    History Cuti
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="cuti.history.index"/>
@endsection
@section('page-title')
    History
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
            <input type="text" value="" class="form-control" placeholder="Search…"
                aria-label="Search in website">
        </div>
    </form>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="display responsive" id="table-main" class="row-border" style="width: 100%;">
                        <thead>
                            <tr>
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
                                {{-- <th class="kontak tipe_kartu_identitas">Tipe kartu identitas</th>
                                <th class="kontak nomor_kartu_identitas">Nomor kartu identitas</th>
                                <th class="kontak alamat">Alamat</th>
                                <th class="kontak no_telepon_darurat">No. telepon darurat</th>
                                <th class="kontak email">Email</th>
                                <th class="kepegawaian status_pegawai">Status pegawai</th>
                                <th class="kepegawaian tanggal_bergabung">Tanggal bergabung</th>
                                <th class="kepegawaian jabatan_fungsional">Jabatan fungsional</th>
                                <th class="kepegawaian jabatan_struktural">Jabatan struktural</th>
                                <th class="kepegawaian dosen">Sebagai Dosen</th>
                                <th class="kepegawaian nuptk">NUPTK</th> --}}
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

            static formatChild(rowData) {

                let nopeg   = rowData.nopeg;
                let safeId  = nopeg.replace(/\./g, '_');
                let tableId = 'detail_' + safeId;

                return `
                    <div class="card">
                        <div class="card-body">

                            <h5 class="mb-3">Detail Pegawai</h5>
                            <table class="table table-sm mb-4">
                                <tr><td>Alamat</td><td>${rowData.alamat ?? '-'}</td></tr>
                                <tr><td>No. Telepon Darurat</td><td>${rowData.notelpdarurat ?? '-'}</td></tr>
                                <tr><td>Email</td><td>${rowData.email ?? '-'}</td></tr>
                                <tr><td>Status Pegawai</td><td>${rowData.status_pegawai ?? '-'}</td></tr>
                                <tr><td>Jabatan Fungsional</td><td>${rowData.jabatan_fungsional ?? '-'}</td></tr>
                                <tr><td>Jabatan Struktural</td><td>${rowData.jabatan_struktural ?? '-'}</td></tr>
                            </table>

                            <h5>History Cuti</h5>
                            <table class="table table-bordered table-sm" id="${tableId}" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Cuti</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                `;
            }

        }

        export default class Index extends Helper{
            // deklarasi variabel
            static DT_Main;
            static childTables = {};

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
                    order: [[2, 'desc']],
                    columns : [

                        {
                            data: null,
                            orderable: false,
                            className: 'text-center',
                            render: function () {
                                return `
                                    <i class="ti ti-chevron-right text-primary fs-3 toggle-child" style="cursor:pointer;"></i>
                                `;
                            }
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
                        // {
                        //     data : "nama_kartuidentitas"
                        // },

                        // {
                        //     data : "noidentitas"
                        // },
                        // {
                        //     data : "alamat"
                        // },

                        // {
                        //     data : "notelpdarurat"
                        // },
                        // {
                        //     data : "email"
                        // },
                        // {
                        //     data : "status_pegawai"
                        // },
                        // {
                        //     data : "tanggal_bergabung"
                        // },
                        // {
                        //     data : "jabatan_fungsional"
                        // },
                        // {
                        //     data : "jabatan_struktural"
                        // },
                        // {
                        //     data : "dosen"
                        // },
                        // {
                        //     data : "nuptk"
                        // },
                    ],
                    responsive: false,

                    columnDefs: [
                        {
                            className: 'dt-responsive-control',
                            orderable: false,
                            targets: 0
                        },
                        {
                            searchPanes: {
                                show: true
                            },
                            targets: ['status_pegawai','nama','nomor_kartu_identitas','agama','jabatan_fungsional','jabatan_struktural']
                        }
                    ],
                    // order: [[2, 'desc']],
                    buttons: [
                        // {
                        //     extend: 'colvisGroup',
                        //     text: 'Informasi pribadi',
                        //     show: ['.informasi-pribadi'],
                        //     hide: ['.kontak','.kepegawaian']
                        // },
                        // {
                        //     extend: 'colvisGroup',
                        //     text: 'Kontak',
                        //     show: ['.kontak'],
                        //     hide: ['.informasi-pribadi','.kepegawaian']
                        // },
                        // {
                        //     extend: 'colvisGroup',
                        //     text: 'Kepegawaian',
                        //     show: ['.kepegawaian'],
                        //     hide: ['.informasi-pribadi','.kontak']
                        // },
                        // {
                        //     extend: 'colvisGroup',
                        //     text: 'Show all',
                        //     show: ':hidden'
                        // },
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
                // $('#table-main tbody').on('click', 'td.dtr-control', function () {
                //     let tr = $(this).closest('tr');
                //     let row = Index.DT_Main.row(tr);

                //     if (row.child.isShown()) {
                //         row.child.hide();
                //         tr.removeClass('shown');
                //     } else {
                //         row.child(Helper.formatDetail(row.data())).show();
                //         tr.addClass('shown');
                //     }
                // });
                $('.dataTables_length').addClass('me-3');
                return this;
            }

            bindEvent() {
                Index.DT_Main.on('buttons-action', this.triggeredButtonDTMain);
                $('#table-main tbody').on('click', '.toggle-child', function (e) {
                    e.stopPropagation();

                    let tr  = $(this).closest('tr');
                    let row = Index.DT_Main.row(tr);
                    let data = row.data();

                    let icon = $(this);

                    let safeId  = data.nopeg.replace(/\./g, '_');
                    let tableId = 'detail_' + safeId;

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');

                        icon
                            .removeClass('ti-chevron-down')
                            .addClass('ti-chevron-right');

                    } else {
                        row.child(Helper.formatChild(data)).show();
                        tr.addClass('shown');

                        icon
                            .removeClass('ti-chevron-right')
                            .addClass('ti-chevron-down');

                        if (!Index.childTables[tableId]) {
                            Index.childTables[tableId] = $('#' + tableId).DataTable({
                                processing: true,
                                paging: false,
                                searching: false,
                                info: false,
                                ordering: false,
                                ajax: {
                                    url: "{{ route('cuti.history.data') }}",
                                    type: "GET",
                                    data: { nopeg: data.nopeg }
                                },
                                columns: [
                                    { data: null, render: (d,t,r,m)=> m.row+1 },
                                    { data: "keterangan" },
                                    {
                                        data: null,
                                        render: function (data, type, row) {

                                            let detail = row.detail ?? [];

                                            // decode html entity + parse
                                            if (typeof detail === 'string') {
                                                detail = $('<textarea/>').html(detail).text();
                                                detail = JSON.parse(detail);
                                            }

                                            if (!detail.length) {
                                                return `<span class="text-white fst-italic">Tidak ada tanggal</span>`;
                                            }

                                            // sort ASC
                                            detail.sort((a, b) => new Date(a.tanggal_cuti) - new Date(b.tanggal_cuti));

                                            return `
                                                <div class="d-flex flex-wrap gap-1">
                                                    ${detail.map(item => `
                                                        <span class="badge bg-info bg-opacity-10 text-white border border-info rounded-pill px-2 py-1">
                                                            <i class="ti ti-calendar-event me-1"></i>
                                                            ${item.tanggal_cuti}
                                                        </span>
                                                    `).join('')}
                                                </div>
                                            `;
                                        }
                                    },
                                    {
                                        data: null,
                                        render: function (row) {

                                            let badge = 'bg-warning';
                                            let text  = 'Menunggu Atasan';
                                            let icon  = 'ti ti-clock';

                                            const approval      = row.approval;
                                            const approval_sdm  = row.approval_sdm;

                                            // ❌ DITOLAK (salah satu false)
                                            if (approval === false || approval_sdm === false) {
                                                badge = 'bg-danger';
                                                text  = 'Ditolak';
                                                icon  = 'ti ti-x';
                                            }
                                            // ✅ DISETUJUI (dua-duanya true)
                                            else if (approval === true && approval_sdm === true) {
                                                badge = 'bg-success';
                                                text  = 'Disetujui';
                                                icon  = 'ti ti-check';
                                            }
                                            // ⏳ MENUNGGU SDM
                                            else if (approval === true && approval_sdm === null) {
                                                badge = 'bg-info';
                                                text  = 'Menunggu SDM';
                                                icon  = 'ti ti-user-check';
                                            }
                                            // ⏳ MENUNGGU ATASAN (default)

                                            return `
                                                <span class="badge ${badge} text-white
                                                    border border-${badge.replace('bg-', '')}
                                                    rounded-pill px-3 py-1">
                                                    <i class="${icon} me-1"></i>
                                                    ${text}
                                                </span>
                                            `;
                                        }
                                    }
                                ]
                            });
                        }
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

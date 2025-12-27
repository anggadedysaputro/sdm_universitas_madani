@extends('app')
@section('title')
    Approval Cuti
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="approval.cuti.index"/>
@endsection
@section('page-title')
    Approval Cuti
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="table-approval" style="width:100%;" class="row-border">
                    <thead>
                        <tr>
                            <td class="all checkbox-control"></td>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Nama Atasan</td>
                            <td>Jumlah</td>
                            <td>Keterangan</td>
                            <td>Tanggal</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('jsweb')
    <script type="module">

        class Helper {
            constructor(){

            }

            onSelect(e,dt, type, indexes){
                if (type === 'row') {
                    var data = Index.DT_Approval.rows(indexes).data();
                    Index.TMP_Selected[data[0].id] = data[0];
                }
            }

            static pilihSatuHalaman(){
                const data = Index.DT_Approval.rows().data();

                Index.DT_Approval.rows().data().each(function(item){
                    Index.TMP_Selected[item.id] = item;
                });

                Index.DT_Approval.rows().select();
            }

            static pilihSemua(){
                $.ajax({
                    url : "{{ route('approval.cuti.list') }}",
                    method : "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend : function(){
                        Swal.fire({
                            title: 'Meengambil data!',
                            html: 'Silahkan tunggu...',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success : function(result){
                        for(const item of result){
                            Index.TMP_Selected[item.id] = item;
                        }
                        Index.DT_Approval.rows().select();
                        Swal.close();
                    },
                    error : function(error){
                        Swal.fire('Gagal',error.responseJSON.message,'error');
                    }
                });
            }

            static permohonan(mode){
                const data = Index.TMP_Selected;
                if(Object.keys(data).length == 0){
                    Swal.fire('Informasi','Pilih data terlebih dahulu','info');
                    return;
                }
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
                            url : "{{ route('approval.cuti.store') }}",
                            method : "POST",
                            data : {data : Object.keys(data), mode},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
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
                                    Index.TMP_Selected = {};
                                    Index.DT_Approval.ajax.reload();
                                });
                            },
                            error : function(error){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static DT_Approval;
            static TMP_Selected;

            constructor() {
                super();
                Index.TMP_Selected = {};

                Index.DT_Approval = $('#table-approval').DataTable({
                    ajax : {
                        url : "{{ route('approval.cuti.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    processing : true,
                    serverSide : true,
                    rowId: 'id',
                    dom: 'Blfrtip',
                    columns : [
                        {
                            "data": null,
                            "sortable": false,
                            "defaultContent" : "",
                            sClass : "checkbox-control-check",
                            searcahble : false,
                        },
                        {
                            "data": null,
                            "sortable": false,
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            searcahble : false,
                        },
                        {data : "nama", name:"p.nama"},
                        {data : "nama_atasan", name:"pa.nama"},
                        {data : "jumlah", name:"c.jumlah"},
                        {data : "keterangan",name:"c.keterangan"},
                        {
                            data: "tanggal",
                            name: "cd.tanggal",
                            render: function (data) {
                                let arr = JSON.parse(data);
                                if (!Array.isArray(arr)) return arr;

                                return arr.map(tgl =>
                                    `<span class="badge text-white bg-success me-1">${tgl}</span>`
                                ).join("");
                            }

                        }

                    ],
                    columnDefs: [
                        {
                            orderable: false,
                            className: 'select-checkbox no-expand',
                            targets: 'checkbox-control'
                        },
                    ],
                    order: [[1, 'asc']],
                    select: {
                        style: 'multi',
                        selector: '.checkbox-control-check',
                        info: false
                    },
                    rowCallback : function(row, data){
                        const d = (Index.TMP_Selected[data.id] ?? {id : -1});
                        if(d.id == data.id) Index.DT_Approval.row(`#${data.id}`).select();
                    },
                    buttons: [
                        {
                            text: 'Pilih satu halaman',
                            action: function ( e, dt, node, config ) {
                               Helper.pilihSatuHalaman();
                            }
                        },
                        {
                            text: 'Pilih semua',
                            action: function ( e, dt, node, config ) {
                                Helper.pilihSemua();
                            }
                        },
                        {
                            text: 'Kosongkan pilihan',
                            action: function ( e, dt, node, config ) {
                                Index.TMP_Selected = {};
                                Index.DT_Approval.rows().deselect();
                            }
                        },
                        {
                            text: 'Setujui',
                            action: function ( e, dt, node, config ) {
                                Helper.permohonan('terima');
                            }
                        },
                        {
                            text: 'Tolak',
                            action: function ( e, dt, node, config ) {
                                Helper.permohonan('tolak');
                            }
                        },
                    ],
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
                Index.DT_Approval.on('select', this.onSelect);
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

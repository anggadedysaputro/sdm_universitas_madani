@extends('app')
@section('title')
    PRESENSI
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="presensi.index"/>
@endsection
@section('page-title')
    PRESENSI
@endsection
@section('action-list')
@endsection
@section('search')
@endsection
@section('content')
<div class="row">
    <div class="col-md-4" id="wrapper-filter">
        <div class="card">
            <div class="card-header">
               <div class="header-title">
                  <h4 class="card-title">Filter presensi</h4>
               </div>
            </div>
            <div class="card-body">
                <form action="#" id="form-presensi">
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Bidang</label>
                                <select name="kodebidang" class="organisasi form-control" style="widht:100%;" placeholder="Pilih bidang"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Divisi</label>
                                <select name="kodedivisi" class="organisasi form-control kodebidang" placeholder="Pilih divisi"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sub divisi</label>
                                <select name="kodesubdivisi" class="organisasi form-control kodebidang kodedivisi" placeholder="Pilih sub divisi"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sub Sub divisi</label>
                                <select name="kodesubsubdivisi" class="organisasi form-control kodebidang kodedivisi" placeholder="Pilih sub sub divisi"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="d-flex gap-3">
                                    <button type="button" id="kosongkan" class="btn btn-default flex-fill">Kosongkan</button>
                                    <button type="button" id="terapkan" class="btn btn-warning flex-fill">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8" id="wrapper-table">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered" style="width:100%;" id="table-main">
                    <thead>
                        <tr>
                            <td>Nomor pegawai</td>
                            <td>Nama</td>
                            <td>Jan</td>
                            <td>Feb</td>
                            <td>Mar</td>
                            <td>Apr</td>
                            <td>Me</td>
                            <td>Jun</td>
                            <td>Jul</td>
                            <td>Agu</td>
                            <td>Sep</td>
                            <td>Okt</td>
                            <td>Nov</td>
                            <td>Des</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-presensi" tabindex="-1">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Data presensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table" id="table-detail-presensi">
                <thead class="sticky-top">
                  <tr class="table-primary">
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam masuk</th>
                    <th scope="col">Jam pulang</th>
                    <th scope="col">Kantor masuk</th>
                    <th scope="col">Kantor pulang</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button>
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

            static bulanLink(e){
                let bulan = $(e.currentTarget).attr('nitip');
                let nopeg = Index.DT_Main.row($(e.currentTarget).parents('tr:first')).data().nopeg;

                $.ajax({
                    url : "{{ route('presensi.detail') }}",
                    method : "POST",
                    data : {bulan, nopeg },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend : function(){
                        Swal.fire({
                            title: 'Mengambil data!',
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
                        const table = $('#table-detail-presensi');
                        let body = [];
                        table.find('tbody').html("");
                        result.forEach((e,i)=>{
                            let content = `
                                <tr>
                                    <td>${e.tg_view}</td>
                                    <td>${e.retwaktumasuk}</td>
                                    <td>${e.retwaktukeluar}</td>
                                    <td>${e.retkantormasuk}</td>
                                    <td>${e.retkantorkeluar}</td>
                                </tr>
                            `;

                            body.push($(content));
                        });
                        table.find('tbody').append(body);
                        Index.MD_Presensi.modal('show');
                    },
                    error : function(e){
                        Swal.fire('Error', e.responseJSON.message,'error');
                        Swal.close();
                    }
                })
            }

            terapkan(){
                Index.DT_Main.button('.filter-table-presensi').trigger();
                Index.DT_Main.ajax.reload();
            }

            kosongkan(){
                Index.FRM_Presensi.find('.organisasi').each(function(i,e){
                    Angga.setValueSelect2AjaxRemote($(e), {id:"",text :$(e).attr('placeholder')});
                });
                Index.DT_Main.button('.filter-table-presensi').trigger();
                Index.DT_Main.ajax.reload();
            }

            resetSelect2(e){
                Index.FRM_Presensi.find('.'+e.currentTarget.name).each(function(i,e){
                    Angga.setValueSelect2AjaxRemote($(e), {id:"",text :$(e).attr('placeholder')});
                });
            }
            static filter(e, dt, node, config){
                const show = $('#wrapper-filter').hasClass("visually-hidden");
                if(show){
                    $('#wrapper-table').removeClass("col-md-12").addClass("col-md-8");
                    $('#wrapper-filter').removeClass("visually-hidden").addClass("col-md-4");
                }else{
                    $('#wrapper-filter').removeClass("col-md-4").addClass("visually-hidden");
                    $('#wrapper-table').removeClass("col-md-8").addClass("col-md-12");
                }
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static S2_KodeBidang;
            static S2_KodeDivisi;
            static S2_KodesubDivisi;
            static S2_KodesubsubDivisi;
            static FRM_Presensi;
            static DT_Main;
            static BTN_Kosongkan;
            static BTN_Terapkan;
            static MD_Presensi;

            constructor() {
                super();

                Index.MD_Presensi = $('#modal-presensi');
                Index.BTN_Terapkan = $('#terapkan');
                Index.BTN_Kosongkan = $('#kosongkan');
                Index.FRM_Presensi = $('#form-presensi');
                Index.S2_KodeBidang = Index.FRM_Presensi.find('select[name="kodebidang"]').select2(Angga.generalAjaxSelect2("{{ route('select2.organisasi.bidang.data') }}", "Pilih bidang"));
                Index.S2_KodeDivisi = Index.FRM_Presensi.find('select[name="kodedivisi"]').select2(Angga.generalAjaxSelect2("{{ route('select2.organisasi.divisi.data') }}", "Pilih divisi", false, "kodebidang", Index.S2_KodeBidang));
                Index.S2_KodesubDivisi = Index.FRM_Presensi.find('select[name="kodesubdivisi"]').select2(Angga.generalAjaxSelect2("{{ route('select2.organisasi.sub-divisi.data') }}", "Pilih sub divisi", false, "kodedivisi", Index.S2_KodeDivisi));
                Index.S2_KodesubsubDivisi = Index.FRM_Presensi.find('select[name="kodesubsubdivisi"]').select2(Angga.generalAjaxSelect2("{{ route('select2.organisasi.sub-sub-divisi.data') }}", "Pilih sub sub divisi", false, "kodesubdivisi", Index.S2_KodesubDivisi));
                Index.DT_Main = $('#table-main').DataTable({
                    ajax : {
                        url : "{{ route('presensi.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data : function(d){
                            // d = $.extend(d,Index.FRM_Presensi.serializeObject());
                            d = $.extend(d,Index.FRM_Presensi.serializeObject());
                            return d;
                        }
                    },
                    serverSide : true,
                    processing : true,
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            text: 'Filter',
                            action: Helper.filter,
                            className : "filter-table-presensi"
                        }
                    ],
                    columns : [
                        {data:"nopeg"},
                        {data:"nama"},
                        {
                            data:"januari",
                            render: function (data, type, row, meta) {
                                return '<a nitip="1" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"februari",
                            render: function (data, type, row, meta) {
                                return '<a nitip="2" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"maret",
                            render: function (data, type, row, meta) {
                                return '<a nitip="3" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"april",
                            render: function (data, type, row, meta) {
                                return '<a nitip="4" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"mei",
                            render: function (data, type, row, meta) {
                                return '<a nitip="5" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"juni",
                            render: function (data, type, row, meta) {
                                return '<a nitip="6" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"juli",
                            render: function (data, type, row, meta) {
                                return '<a nitip="7" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"agustus",
                            render: function (data, type, row, meta) {
                                return '<a nitip="8" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"september",
                            render: function (data, type, row, meta) {
                                return '<a nitip="9" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"oktober",
                            render: function (data, type, row, meta) {
                                return '<a nitip="10" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"november",
                            render: function (data, type, row, meta) {
                                return '<a nitip="11" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                        {
                            data:"desember",
                            render: function (data, type, row, meta) {
                                return '<a nitip="12" class="bulan-link" href="#">'+data+'</a>';
                            }
                        },
                    ],
                    createdRow : function(row, data){
                        $(row).find('a.bulan-link').on('click', Helper.bulanLink);
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
                Index.S2_KodeBidang.on('select2:select select2:clearing', this.resetSelect2);
                Index.S2_KodeDivisi.on('select2:select select2:clearing', this.resetSelect2);
                Index.S2_KodesubDivisi.on('select2:select select2:clearing', this.resetSelect2);
                Index.BTN_Kosongkan.on('click', this.kosongkan);
                Index.BTN_Terapkan.on('click', this.terapkan);
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

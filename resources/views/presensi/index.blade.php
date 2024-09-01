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
                                <select name="kodebidang" class="form-control" style="widht:100%;" placeholder="Pilih bidang"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Divisi</label>
                                <select name="kodedivisi" class="form-control kodebidang" placeholder="Pilih divisi"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sub divisi</label>
                                <select name="kodesubdivisi" class="form-control kodebidang kodedivisi" placeholder="Pilih sub divisi"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Sub Sub divisi</label>
                                <select name="kodesubsubdivisi" class="form-control kodebidang kodedivisi" placeholder="Pilih sub sub divisi"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" name="tanggal" class="form-control flatpickr-range">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="d-flex gap-3">
                                    <button type="button" class="btn btn-default flex-fill">Kosongkan</button>
                                    <button type="button" class="btn btn-warning flex-fill">Terapkan</button>
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
@endsection
@section('jsweb')
    <script type="module">

        class Helper {
            constructor(){

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

            constructor() {
                super();
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
                    },
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            text: 'Filter',
                            action: Helper.filter
                        }
                    ],
                    columns : [
                        {data:"retnopeg"},
                        {data:"retnama"},
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
                Index.S2_KodeBidang.on('select2:select select2:clearing', this.resetSelect2);
                Index.S2_KodeDivisi.on('select2:select select2:clearing', this.resetSelect2);
                Index.S2_KodesubDivisi.on('select2:select select2:clearing', this.resetSelect2);
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

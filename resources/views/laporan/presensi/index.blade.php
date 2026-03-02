@extends('app')
@section('title')
    Laporan Presensi
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="laporan.presensi.index"/>
@endsection
@section('page-title')
    Presensi
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

        {{-- FORM FILTER --}}
        <form id="form-filter" class="row g-3 mb-4">

            {{-- <div class="col-md-3">
                <label class="form-label">Tanggal Awal</label>
                <input type="text" name="tgl_awal" id="tgl_awal"
                    class="form-control datepicker"
                    placeholder="YYYY-MM-DD" readonly>
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="text" name="tgl_akhir" id="tgl_akhir"
                    class="form-control datepicker"
                    placeholder="YYYY-MM-DD" readonly>
            </div> --}}
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    @php
                        $bulan = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];
                    @endphp

                    @foreach ($bulan as $key => $nama)
                        <option value="{{ $key }}"
                            {{ old('bulan') == $key ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Jenis Laporan</label>
                <select name="jenis_laporan" id="jenis_laporan" class="form-control select2">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="v1">Laporan kinerja pegawai</option>
                    <option value="v2">Laporan detail presensi pegawai</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2">
                <button class="btn btn-primary" type="button" id="tampil-modal" style="display: none;">
                        Download
                </button>
                <div class="dropdown" id="download-button">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Download
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-item btn-preview">
                                Preview (PDF)
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item btn-pdf">
                                Download PDF
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item btn-excel">
                                Download Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </form>

        {{-- PREVIEW PDF --}}
        <div id="preview-container" class="d-none position-relative">
            <hr>

            <!-- LOADING -->
            <div id="preview-loading"
                class="position-absolute top-50 start-50 translate-middle d-none"
                style="z-index:10">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div class="mt-2 text-center">Memuat preview...</div>
            </div>

            <iframe id="preview-frame"
                src=""
                style="width:100%; height:700px; border:none;">
            </iframe>
        </div>


    </div>
</div>
<div class="modal" tabindex="-1" id="modal-data-pembelajaran">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Data pembelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table" style="width:100%;">
            <thead>
                <tr>
                    <td>Nama</td>
                    <td>Program Studi</td>
                    <td>Ajar</td>
                    <td>Sks</td>
                    <td>Terpenuhi</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <div class="dropdown" id="download-button-modal">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> Simpan & Cetak </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" class="dropdown-item btn-preview">
                        Preview (PDF)
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-item btn-pdf">
                        Download PDF
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-item btn-excel">
                        Download Excel
                    </a>
                </li>
            </ul>
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
                this.previewUrl = null;
                this.previewController = null;
            }

            static inputPembelajaran(e){
                const data = $(e.currentTarget).data();
                const value = $(e.currentTarget).val();

                $.ajax({
                    url : "{{ route('laporan.presensi.update-pembelajaran') }}",
                    method : "PUT",
                    data : {
                        nopeg : data.nopeg,
                        nilai : value,
                        mode : data.mode
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend : function(){
                        Swal.fire({
                            title: 'mengambil data!',
                            html: 'Silahkan tunggu...',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success : function(result){
                        Index.DT_Main.ajax.reload();
                        Swal.fire('Success', result.message,'success');
                    },
                    error : function(error){
                        Index.DT_Main.ajax.reload();
                        Swal.fire('Gagal',error.responseJSON.message,'error');
                    }
                });
            }

            getFilter() {
                return {
                    bulan : $('#bulan').val(),
                    jenis_laporan : $('#jenis_laporan').val()
                };
            }

            previewReport() {
                const params = this.getFilter();

                if (!params.bulan) {
                    alert('Bulan wajib diisi');
                    return;
                }

                // RESET IFRAME
                const iframe = $('#preview-frame')[0];
                iframe.src = 'about:blank';

                // SHOW PREVIEW + LOADING (PASTI MUNCUL)
                $('#preview-container').removeClass('d-none');
                $('#preview-loading').removeClass('d-none');

                fetch(`{{ url('laporan/presensi/file') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        bulan: params.bulan,
                        jenis_laporan : params.jenis_laporan,
                        type: 'pdf',
                        preview: true
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal generate laporan');
                    return res.blob();
                })
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    iframe.src = url;
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal preview laporan');
                })
                .finally(() => {
                    // ⬅️ INI KUNCI UTAMANYA
                    $('#preview-loading').addClass('d-none');
                    Index.MD_Pembelajaran.modal('hide');
                });
            }

            setButtonLoading(button, isLoading, text) {
                if (isLoading) {
                    button
                        .data('origin-text', button.html())
                        .prop('disabled', true)
                        .html(`
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            ${text}
                        `);
                } else {
                    button
                        .prop('disabled', false)
                        .html(button.data('origin-text'));
                }
            }


            downloadReport(type, btn) {
                const params = this.getFilter();

                this.setButtonLoading(btn, true, 'Downloading');

                fetch(`{{ url('laporan/presensi/file') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        bulan: params.bulan,
                        jenis_laporan: params.jenis_laporan,
                        type: type,
                        preview: false
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal download');
                    return res.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `laporan_presensi.${type}`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal download laporan');
                })
                .finally(() => {
                    this.setButtonLoading(btn, false);
                });
            }



        }

        export default class Index extends Helper{
            // deklarasi variabel
            static MD_Pembelajaran = $('#modal-data-pembelajaran');
            static DT_Main;

            constructor() {
                Index.DT_Main = $('table').DataTable({
                    ajax : {
                        url : "{{ route('laporan.presensi.datatable') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                   columns: [
                        { data: "nama_pegawai" },
                        { data: "nama_organisasi" },
                        {
                            data: "ajar",
                            render: function(data, type, row, meta) {
                                return `<input type="text"
                                            class="form-control input-ajar"
                                            value="${data ?? 0}"
                                            inputmode="numeric"
                                            pattern="[0-9]*"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">`;
                            }
                        },
                        {
                            data: "sks",
                            render: function(data, type, row, meta) {
                                return `<input type="text"
                                            class="form-control input-sks"
                                            value="${data ?? 0}"
                                            inputmode="numeric"
                                            pattern="[0-9]*"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">`;
                            }
                        },
                        {
                            data: "terpenuhi",
                            render: function(data, type, row, meta) {
                                return `<input type="text"
                                            class="form-control input-terpenuhi"
                                            value="${data ?? 0}"
                                            inputmode="numeric"
                                            pattern="[0-9]*"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">`;
                            }
                        }
                    ],
                    createdRow : function(row, data){
                        $(row).find('.input-terpenuhi').on('change', Helper.inputPembelajaran).data({...data,"mode" : "terpenuhi"});
                        $(row).find('.input-sks').on('change', Helper.inputPembelajaran).data({...data,"mode" : "sks"});
                        $(row).find('.input-ajar').on('change', Helper.inputPembelajaran).data({...data,"mode" : "ajar"});
                    }
                });
                flatpickr('.datepicker', {
                    dateFormat: 'Y-m-d',
                    allowInput: false
                });
                super();
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
                $('#download-button').hide();

                console.log($('#download-button'));
                return this;
            }

            bindEvent() {

                $('#tampil-modal').on('click', function(){
                    Index.MD_Pembelajaran.modal('show');
                })
                $('#jenis_laporan').on('change', (e) => {

                    if( $('#jenis_laporan').val() != ""){
                        if($('#bulan').val() == ""){
                            Swal.fire("Informasi","Bulan belum dipilih","info");
                            $('#jenis_laporan').val("").trigger('change');
                            return;
                        }
                        if(e.target.value=='v2'){
                            $("#download-button").hide();
                            // Index.MD_Pembelajaran.modal('show');
                            $('#tampil-modal').show();
                            Index.DT_Main.ajax.reload();
                        }else{
                            $('#tampil-modal').hide();
                            $("#download-button").show();
                        }
                    }
                });

                $('.btn-preview').on('click', (e) => {
                    e.preventDefault();
                    Index.MD_Pembelajaran.modal('hide');
                    this.previewReport();
                });

                $('.btn-pdf').on('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // ⬅️ TAHAN DROPDOWN
                    this.downloadReport('pdf', $('.btn-pdf'));
                });

                $('.btn-excel').on('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // ⬅️ TAHAN DROPDOWN
                    this.downloadReport('xlsx', $('.btn-excel'));
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

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

            <div class="col-md-3">
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
            </div>


            <div class="col-md-6 d-flex align-items-end gap-2">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Download
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-item" id="btn-preview">
                                Preview (PDF)
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item" id="btn-pdf">
                                Download PDF
                            </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item" id="btn-excel">
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
@endsection
@section('jsweb')
    <script type="module">

        class Helper {
            constructor(){
                this.previewUrl = null;
                this.previewController = null;
            }

            getFilter() {
                return {
                    tgl_awal: $('#tgl_awal').val(),
                    tgl_akhir: $('#tgl_akhir').val(),
                };
            }

            previewReport() {
                const params = this.getFilter();

                if (!params.tgl_awal || !params.tgl_akhir) {
                    alert('Tanggal awal dan akhir wajib diisi');
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
                        tglawal: params.tgl_awal,
                        tglakhir: params.tgl_akhir,
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

                if (!params.tgl_awal || !params.tgl_akhir) {
                    alert('Tanggal awal dan akhir wajib diisi');
                    return;
                }

                this.setButtonLoading(btn, true, 'Downloading');

                fetch(`{{ url('laporan/presensi/file') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        tglawal: params.tgl_awal,
                        tglakhir: params.tgl_akhir,
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

            constructor() {
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
                return this;
            }

            bindEvent() {

                $('#btn-preview').on('click', (e) => {
                    e.preventDefault();
                    this.previewReport();
                });

                $('#btn-pdf').on('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // ⬅️ TAHAN DROPDOWN
                    this.downloadReport('pdf', $('#btn-pdf'));
                });

                $('#btn-excel').on('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // ⬅️ TAHAN DROPDOWN
                    this.downloadReport('xlsx', $('#btn-excel'));
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

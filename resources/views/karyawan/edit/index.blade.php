@extends('app')
@section('title')
    Karyawan
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="karyawan.edit.index"/>
@endsection
@section('page-title')
    Karyawan [{{ $id }}]
@endsection
@section('action-list')
    <a href="{{ route('karyawan.index') }}" class="btn btn-primary"><i class="ti ti-list"></i>Data karyawan</a>
@endsection
@section('search')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2" >
                    <div class="row">
                        <div class="col-md-12" id="wrapper-image-karyawan">
                            <div class="d-flex justify-content-center">
                                <div class="p-3">
                                    <img style="width:150px; height:150px;" src="{{ empty($pegawai->gambar) ? asset('assets/photos/default_upload_karyawan.png') : asset('storage/pegawai/'.$pegawai->gambar) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="display:none;">
                            <div class="d-flex justify-content-center" id="container-crop">
                                <div class="p-3">
                                    <img class="cropped" style="width:150px; height:150px;" src="{{ empty($pegawai->gambar) ? asset('assets/photos/default_upload_karyawan.png') : asset('storage/pegawai/'.$pegawai->gambar) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column">
                                <input type="file" class="form-control" id="foto-profile" placeholder="Foto" accept="image/*">
                                <button class="btn btn-success flex-fill" id="simpan-image-karyawan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <h3>Data personal</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-personal"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->nama }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tempat lahir
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tempatlahir }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tanggal lahir
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tanggal_lahir }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jenis kelamin
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->jenis_kelamin }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Status nikah
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->status_nikah }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Foto NPWP
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->foto_npwp_url))
                                            <a href="{{ $pegawai->foto_npwp_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Foto BPJS Kesehatan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->foto_bpjs_kesehatan_url))
                                            <a href="{{ $pegawai->foto_bpjs_kesehatan_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Foto BPJS Ketenagakerjaan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->foto_bpjs_ketenagakerjaan_url))
                                            <a href="{{ $pegawai->foto_bpjs_ketenagakerjaan_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Golongan darah
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->gol_darah }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Agama
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->agama }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Kewarganegaraan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->kewarganegaraan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Negara
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->negara }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tipe kartu identitas
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->kartu_identitas }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        ID kartu identitas
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->noidentitas }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h3>Data Keluarga</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-keluarga"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        No kartu keluarga
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->nokk }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama kepala keluarga
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->nama_kepala_keluarga }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama keluarga darurat
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->nama_keluarga_darurat }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        No. telepon keluarga darurat
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->telp_keluarga_darurat }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Keluarga
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                @foreach ($keluarga as $key => $value)
                                                    <div class="{{ $key > 0 ? 'd-none show-more' : '' }}">
                                                        <table class="table table-bordered mb-4">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="col-md-4">Nama</td>
                                                                    <td class="col-md-8">{{ $value->nama }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Hubungan</td>
                                                                    <td class="col-md-8">{{ $value->hubungan }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Tempat lahir</td>
                                                                    <td class="col-md-8">{{ $value->tempatlahir }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Tanggal lahir</td>
                                                                    <td class="col-md-8">{{ $value->tgllahir_view }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">No. telepon</td>
                                                                    <td class="col-md-8">{{ $value->telp }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Alamat</td>
                                                                    <td class="col-md-8">{{ $value->alamat }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach

                                                @if (count($keluarga) > 1)
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-sm btn-primary loadMore">Tampilkan lebih banyak</button>
                                                    </div>
                                                @endif

                                                @if(count($keluarga) ==0)
                                                    <div>Tidak ada data</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Data Pekerjaan</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-pekerjaan"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        NIPY
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->nopeg }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Status karyawan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->status_pegawai }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tgl. Masuk Yayasan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tanggal_masuk }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tgl. Berakhir Kontrak
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tgl_berakhir_kontrak_view }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Masa bakti
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->masa_bakti }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Organisasi
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->organisasi }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jabatan struktural
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->jabatan_struktural }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jabatan fungsional
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->jabatan_fungsional }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tugas tambahan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tugas_tambahan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Dok. Surat Penjanjian Kerja
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->dok_surat_perjanjian_kerja))
                                        <a href="{{ $pegawai->dok_surat_perjanjian_kerja_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Dok. Pakta Integritas
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->dok_pakta_integritas))
                                            <a href="{{ $pegawai->dok_pakta_integritas_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Dok. Hasil Test
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->dok_hasil_test))
                                            <a href="{{ $pegawai->dok_hasil_test_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Dok. Hasil Interview
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->dok_hasil_interview))
                                            <a href="{{ $pegawai->dok_hasil_interview_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Data pendidikan</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-pendidikan"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jenjang pendidikan terakhir
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->pendidikan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tahun lulus
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tahun_lulus }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama Lembaga Pendidikan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->namasekolah }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Program studi
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->prodi }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Dok. Ijazah
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->dok_ijazah))
                                            <a href="{{ $pegawai->dok_ijazah_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Dok. Transkrip Nilai
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        @if (!empty($pegawai->dok_transkrip_nilai))
                                            <a href="{{ $pegawai->dok_transkrip_nilai_url }}" target="blank" class="previewFileOnNewTab mb-3">Preview</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Gelar
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->gelar }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Data Sertifikat</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-sertifikat"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="card">
                                <div class="card-body">
                                    @foreach ($sertifikat as $key => $value)
                                        <div class="{{ $key > 0 ? 'd-none show-more' : '' }}">
                                            <table class="table table-bordered mb-4">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Nomor sertifikat</td>
                                                        <td class="col-md-8">{{ $value->nomor_sertifikat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Jenis sertifikat</td>
                                                        <td class="col-md-8">{{ $value->jenissertifikat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Lembaga penyelenggara</td>
                                                        <td class="col-md-8">{{ $value->lembaga_penyelenggara }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Tahun</td>
                                                        <td class="col-md-8">{{ $value->tahun }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Biaya</td>
                                                        <td class="col-md-8">{{ number_format($value->biaya,2,",",".") }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Jenis biaya</td>
                                                        <td class="col-md-8">{{ $value->jenisbiaya }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach

                                    @if (count($sertifikat) > 1)
                                        <div class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary loadMore">Tampilkan lebih banyak</button>
                                        </div>
                                    @endif

                                    @if (count($sertifikat) == 0)
                                        <div>Tidak ada data</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Data Kompetensi</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-kompetensi"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Kompetensi Hard Skill
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->kompetensi_hard_skill }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Kompetensi Soft Skill
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->kompetensi_soft_skill }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Data Pengalaman Kerja</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-pengalaman-kerja"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="card">
                                <div class="card-body">
                                    @foreach ($pengalamankerja as $key => $value)
                                        <div class="{{ $key > 0 ? 'd-none show-more' : '' }}">
                                            <table class="table table-bordered mb-4">
                                                <tbody>
                                                    <tr>
                                                        <td class="col-md-4">Dari tahun</td>
                                                        <td class="col-md-8">{{ $value->dari_tahun }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Sampai tahun</td>
                                                        <td class="col-md-8">{{ $value->sampai_tahun }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Jabatan</td>
                                                        <td class="col-md-8">{{ $value->jabatan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="col-md-4">Paklaring</td>
                                                        <td class="col-md-8">{{ $value->paklaring }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach

                                    @if (count($pengalamankerja) > 1)
                                        <div class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary loadMore">Tampilkan lebih banyak</button>
                                        </div>
                                    @endif

                                    @if (count($pengalamankerja) == 0)
                                        <div>Tidak ada data</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Data Fasilitas</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-data-fasilitas"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <h4>Tempat tinggal</h4>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Biaya per tahun
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ number_format($pegawai->biaya_tempat_tinggal_pertahun,2,',','.') }}
                                    </div>
                                </div>
                            </div>
                            <h4>Beras</h4>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jumlah KG
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->jumlah_beras_kg }}
                                    </div>
                                </div>
                            </div>
                            <h4>Kendaraan</h4>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Merk kendaraan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->merk_kendaraan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tahun kendaraan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->tahun_kendaraan }}
                                    </div>
                                </div>
                            </div>
                            <h4>Beasiswa pendidikan</h4>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama lembaga pendidikan
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ $pegawai->nama_lembaga_beasiswa_pendidikan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Biaya per semester
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        {{ number_format($pegawai->biaya_beasiswa_per_semester,2,',','.') }}
                                    </div>
                                </div>
                            </div>
                            <h4>Biaya pendidikan anak</h4>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Data biaya pendidikan anak
                                    </div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                @foreach ($biayapendidikananak as $key => $value)
                                                    <div class="{{ $key > 0 ? 'd-none show-more' : '' }}">
                                                        <table class="table table-bordered mb-4">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="col-md-4">Anak ke</td>
                                                                    <td class="col-md-8">{{ $value->anak_ke }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Jenjang pendidikan</td>
                                                                    <td class="col-md-8">{{ $value->jenjangpendidikan }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Jenis biaya pendidikan</td>
                                                                    <td class="col-md-8">{{ $value->jenis_biaya_pendidikan }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="col-md-4">Besaran dispensasi</td>
                                                                    <td class="col-md-8">{{ number_format($value->besaran_dispensasi,2,',','.') }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach

                                                @if (count($biayapendidikananak) > 1)
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-sm btn-primary loadMore">Tampilkan lebih banyak</button>
                                                    </div>
                                                @endif

                                                @if(count($biayapendidikananak) ==0)
                                                    <div>Tidak ada data</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal data personal --}}
    <div class="modal modal-blur fade" id="modal-edit-data-pribadi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data personal</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-personal">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Nama</label>
                                <input type="text" class="form-control form-step-1" placeholder="Nama lengkap" name="nama" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tempat lahir</label>
                                <input type="text" class="form-control form-step-1" placeholder="Tempat lahir" name="tempatlahir" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Tanggal lahir</label>
                                <input type="text" class="form-control form-step-1" placeholder="Tanggal lahir" name="tgl_lahir" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Jenis kelamin</label>
                            <div class="row">
                                <div class="col-md-6 col-sm-4">
                                    <label class="form-check form-check-inline">
                                    <input type="radio" value="L" class="form-check-input form-step-1" name="jns_kel" required>
                                    <span class="form-check-label">
                                        {{-- <img src="{{ asset('assets/ilustration/male.jpg') }}" width="100" height="100"/> --}}
                                        Laki-laki
                                    </span>
                                    </label>
                                </div>
                                <div class="col-md-6 col-sm-4">
                                    <label class="form-check form-check-inline">
                                    <input type="radio" value="P" class="form-check-input form-step-1" name="jns_kel" required>
                                    <span class="form-check-label">
                                        Perempuan
                                    </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Status perkawinan</label>
                                <select type="text" class="form-select tomselected form-step-1" name="idstatusnikah" required>
                                    @foreach ($statusnikah as $value)
                                        <option value="{{ $value->idstatusnikah }}">{{ $value->status }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div>
                                    <label class="form-label">Foto NPWP</label>
                                    <input type="file" name="foto_npwp" class="file-data form-control" placeholder="Foto" accept="image/*">
                                </div>
                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Foto BPJS Kesehatan</label>
                                <input type="file" name="foto_bpjs_kesehatan" class="file-data form-control" placeholder="Foto" accept="image/*" only="image/">
                            </div>
                            <a href="#" class="previewFileOnNewTab mb-3"></a>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Foto BPJS Ketenagakerjaan</label>
                                <input type="file" name="foto_bpjs_ketenagakerjaan" class="file-data form-control" placeholder="Foto" accept="image/*" only="image/">
                            </div>
                            <a href="#" class="previewFileOnNewTab mb-3"></a>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Golongan darah</label>
                                <select type="text" class="form-select tomselected form-step-1" name="gol_darah" required>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Agama</label>
                                <select type="text" class="form-select tomselected form-step-1" name="agama" required>
                                    @foreach ($agama as $value)
                                        <option value="{{ $value->id }}">{{ $value->urai }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex flex-column">
                                <label class="form-label required">Kewarganegaraan</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <select type="text" class="form-select tomselected form-step-1" name="kewarganegaraan" required>
                                                <option value="WNI" selected>WNI</option>
                                                <option value="WNA">WNA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <select type="text" class="form-select tomselected form-step-1" name="idwarganegara" required>
                                                @foreach ($negara as $value)
                                                    <option value="{{ $value->id }}" {{ strtolower($value->keterangan)=='indonesia' ? 'selected' : '' }}>{{ $value->keterangan }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tipe kartu identitas</label>
                                <select class="form-select tomselected form-step-1" name="idkartuidentitas" required placeholder="Pilih Tipe kartu identitas">
                                    <option value="">Pilih tipe kartu identitas</option>
                                    @foreach ($kartuidentitas as $value)
                                        <option value="{{ $value->id }}" {{ strtolower($value->keterangan)=='indonesia' ? 'selected' : '' }}>{{ $value->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">ID kartu identitas</label>
                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="ID kartu identitas" name="noidentitas" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-informasi-pribadi">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal data pekerjaan --}}
    <div class="modal modal-blur fade" id="modal-edit-data-pekerjaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data pekerjaan</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-pekerjaan">
                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">NIPY</label>
                                    <input type="text" class="form-control integer-mask form-step-3" placeholder="NIPY" name="nopeg" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Status karyawan</label>
                                    <select class="form-select tomselected form-step-3" name="idstatuspegawai" required>
                                        @foreach ($statuspegawai as $value)
                                            <option value="{{ $value->idstatuspegawai }}">{{ $value->keterangan }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Tgl. Masuk Yayasan</label>
                                    <input type="text" class="form-control flat-picker form-step-3" placeholder="Tanggal bergabung" name="tgl_masuk" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tgl. Berakhir Kontrak</label>
                                    <input type="text" class="form-control flat-picker" placeholder="Tanggal berakhir kontrak" name="tgl_berakhir_kontrak">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Masa Bakti</label>
                                    <input type="text" class="form-control integer-mask" placeholder="Masukkan masa bakti" name="masa_bakti">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Pilih organisasi</label>
                                    <div class="row g-2">
                                      <div class="col">
                                        <input type="hidden" class="form-step-3 required" required>
                                        <input type="text" class="form-control" placeholder="Klik tombol cari..." disabled name="organisasi">
                                        <div class="invalid-feedback"></div>
                                      </div>
                                      <div class="col-auto">
                                        <a href="#" class="btn btn-icon" aria-label="Button" id="search-organisasi">
                                          <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                                        </a>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan struktural</label>
                                    <select class="form-select tomselected step-3" name="kodestruktural">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan fungsional</label>
                                    <select class="form-select tomselected step-3" name="kodejabfung">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Tugas tambahan <span class="form-label-description"></label>
                                    <textarea class="form-control" rows="6" placeholder="Masukkan tugas tambahan" name="tugas_tambahan"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <label class="form-label">Dok. Surat Penjanjian Kerja</label>
                                    <input type="file" name="dok_surat_perjanjian_kerja" class="file-data form-control" id="basic-default-foto" placeholder="Foto">
                                </div>
                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <label class="form-label">Dok. Pakta Integritas</label>
                                    <input type="file" name="dok_pakta_integritas" class="file-data form-control" id="basic-default-foto" placeholder="Foto">
                                </div>
                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <label class="form-label">Dok. Hasil Test</label>
                                    <input type="file" name="dok_hasil_test" class="file-data form-control" id="basic-default-foto" placeholder="Foto">
                                </div>
                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <label class="form-label">Dok. Hasil Interview</label>
                                    <input type="file" name="dok_hasil_interview" class="file-data form-control" id="basic-default-foto" placeholder="Foto">
                                </div>
                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-pekerjaan">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal data pendidikan --}}
    <div class="modal modal-blur fade" id="modal-edit-data-pendidikan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit pendidikan terakhir</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-pendidikan">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Jenjang pendidikan terakhir</label>
                                <select class="form-select tomselected form-step-4" name="kodependidikan" required placeholder="Jenjang pendidikan terakhir">
                                    @foreach ($pendidikan as $value)
                                        <option value="{{ $value->kodependidikan }}" {{ strtolower($value->keterangan)=='indonesia' ? 'selected' : '' }}>{{ $value->keterangan }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tahun lulus</label>
                                <select class="form-select tomselected form-step-4" name="tahun_lulus" required placeholder="Tahun lulus"></select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Nama Lembaga Pendidikan                                                </label>
                                <input type="text" class="form-control form-step-4" placeholder="Masukkan Nama Lembaga Pendidikan" name="namasekolah" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Program studi</label>
                                <input type="text" class="form-control" placeholder="Program studi" name="prodi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dok. Ijazah</label>
                                <input type="file" name="dok_ijazah" class="file-data form-control" id="basic-default-foto">
                            </div>
                            <a href="#" class="previewFileOnNewTab mb-3"></a>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dok. Transkrip Nilai</label>
                                <input type="file" name="dok_transkrip_nilai" class="file-data form-control" id="basic-default-foto">
                            </div>
                            <a href="#" class="previewFileOnNewTab mb-3"></a>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gelar</label>
                                <input type="text" class="form-control" placeholder="Masukkan gelar" name="gelar">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-pendidikan">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal data sertifikat --}}
    <div class="modal modal-blur fade" id="modal-edit-data-sertifikat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data sertifikat</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-sertifikat">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Daftar sertifikat <button class="btn btn-success btn-sm" type="button" id="tambah-sertifikat"><i class="ti ti-plus"></i></button></h3>
                            <div class="row" id="wrapper-sertifikat">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-sertifikat">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal data kompetensi --}}
    <div class="modal modal-blur fade" id="modal-edit-data-kompetensi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data kompetensi</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-kompetensi">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi Hard Skill</label>
                                <input type="text" class="form-control form-step-6" placeholder="Masukkan kompetensi hard skill" name="kompetensi_hard_skill">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi Soft Skill</label>
                                <input type="text" class="form-control form-step-6" placeholder="Masukkan kompetensi soft skill" name="kompetensi_soft_skill">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-kompetensi">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal data pengalaman kerja --}}
    <div class="modal modal-blur fade" id="modal-edit-data-pengalaman-kerja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data pengalaman kerja</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-pengalaman-kerja">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Daftar pengalaman kerja <button class="btn btn-success btn-sm" type="button" id="tambah-pengalaman-kerja"><i class="ti ti-plus"></i></button></h3>
                            <div class="row" id="wrapper-pengalaman-kerja">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-pengalaman-kerja">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal data fasilitas --}}
    <div class="modal modal-blur fade" id="modal-edit-data-fasilitas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data fasilitas</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-data-fasilitas">
                    <div class="row">
                        <h3>Tempat tinggal</h3>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Biaya per tahun</label>
                                <input type="text" class="form-control money-mask" placeholder="masukkan biaya pertahun" name="biaya_tempat_tinggal_pertahun">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Beras</h3>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Jumlah KG</label>
                                <input type="text" class="form-control decimal-mask-morethan" placeholder="Masukkan jumlah KG" name="jumlah_beras_kg">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Kendaraan</h3>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Merk kendaraan</label>
                                <input type="text" class="form-control" placeholder="masukkan merk" name="merk_kendaraan">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tahun kendaraan</label>
                                <select class="form-select tomselected" name="tahun_kendaraan" placeholder="Pilih tahun kendaraan">

                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Beasiswa pendidikan</h3>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama lembaga pendidikan</label>
                                <input type="text" class="form-control" placeholder="masukkan nama lembaga pendidikan" name="nama_lembaga_beasiswa_pendidikan">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Biaya per semester</label>
                                <input type="text" class="form-control money-mask" placeholder="masukkan biaya per semester" name="biaya_beasiswa_per_semester">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Biaya pendidikan anak <button class="btn btn-success btn-sm" type="button" id="tambah-data-fasilitas"><i class="ti ti-plus"></i></button></h3>
                            <div class="row" id="wrapper-fasilitas">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-fasilitas">Simpan</button>
            </div>
          </div>
        </div>
    </div>


    {{-- modal keluarga --}}
    <div class="modal modal-blur fade" id="modal-edit-data-keluarga" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit data keluarga</h5>
              <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-keluarga">
                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">No kartu keluarga</label>
                                    <input type="text" class="form-control integer-mask form-step-2" placeholder="Nomor kartu keluarga" name="nokk" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama kepala keluarga</label>
                                    <input type="text" class="form-control form-step-2" placeholder="Input nama kepala keluarga" name="nama_kepala_keluarga" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama keluarga darurat</label>
                                    <input type="text" class="form-control form-step-2" placeholder="Input nama keluarga darurat" name="nama_keluarga_darurat">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No. telepon keluarga darurat</label>
                                    <input type="text" class="form-control integer-mask form-step-2" placeholder="No. telepon" name="telp_keluarga_darurat">
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Daftar keluarga <button class="btn btn-success btn-sm" type="button" id="tambah-keluarga"><i class="ti ti-plus"></i></button></h3>
                        </div>
                    </div>
                    <div class="row" id="wrapper-keluarga">
                        @foreach ($keluarga as $value)
                        <div class="col-md-12 mb-3">
                            <div class="card position-relative">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-keluarga">
                                    <i class="ti ti-minus text-white"></i>
                                </span>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Nama</label>
                                                <input type="text" class="form-control form-step-1" placeholder="Input nama lengkap" name="namakeluarga[]" value="{{$value->nama}}" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Hubungan</label>
                                                <select type="text" class="form-select tomselected form-step-1" name="hubungankeluarga[]" required>
                                                    <option value="Suami" {{$value->hubungan == "Suami" ? "selected":""}}>Suami</option>
                                                    <option value="Istri" {{$value->hubungan == "Istri" ? "selected":""}}>Istri</option>
                                                    <option value="Anak" {{$value->hubungan == "Anak" ? "selected":""}}>Anak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Tempat lahir</label>
                                                <input type="text" class="form-control form-step-1" placeholder="Tempat lahir" name="tempatlahirkeluarga[]" required value="{{$value->tempatlahir}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Tanggal lahir</label>
                                                <input type="text" class="form-control flat-picker form-step-1" placeholder="Tanggal lahir" name="tgllahirkeluarga[]" required value="{{$value->tgllahir}}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">No. telepon</label>
                                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. telepon" name="telpkeluarga[]" value="{{$value->telp}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Alamat<span class="form-label-description"></label>
                                                <textarea class="form-control form-step-1" rows="6" placeholder="Alamat" name="alamatkeluarga[]" required value="{{$value->alamat}}">{{$value->alamat}}</textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto modal-btn-close" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-data-keluarga">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-main">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Daftar fungsional</h2>
            <button type="button" class="btn-close text-reset modal-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <div id="organisasi"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-main">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">Daftar fungsional</h2>
            <button type="button" class="btn-close text-reset modal-btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <div id="organisasi"></div>
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
            }

            tambahFasilitas(){
                const data = Helper.addRowBiayaPendidikanAnak(
                    [
                        {anak_ke:""}
                    ]
                );
                let wrapper = $('#wrapper-fasilitas');
                wrapper.prepend(data);
            }

            tambahPengalamanKerja(){
                const data = Helper.addRowPengalamanKerja(
                    [
                        {tahun:""}
                    ]
                );
                let wrapper = $('#wrapper-pengalaman-kerja');
                wrapper.prepend(data);
            }

            tambahSertifikat(){
                const data = Helper.addRowSertifikat(
                    [
                        {"nomor_sertifikat":"", "jenis_sertifikat":"", "lembaga_penyelenggara" : "", "tahun":"", "biaya":"","jenis_biaya":""},
                    ]
                );
                let wrapper = $('#wrapper-sertifikat');
                wrapper.prepend(data);
            }

            tambahKeluarga(){
                const data = Helper.addRowKeluarga(
                    [
                        {"nama":"", "hubungan":"", "telp" : "", "alamat":"", "tempatlahir":"","tanggallahir":""},
                    ]
                );
                let wrapper = $('#wrapper-keluarga');
                wrapper.prepend(data);
            }

            static addRowPengalamanKerja(data){
                let row = [];
                data.forEach((e,i)=>{
                    let content = `
                        <div class="col-md-12 mb-3">
                            <div class="card position-relative">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-row-data">
                                    <i class="ti ti-minus text-white"></i>
                                </span>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Dari tahun</label>
                                                <select class="form-select tomselected tahun-dari" name="dari_tahun[]" placeholder="Pilih dari tahun">

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Sampai tahun</label>
                                                <select class="form-select tomselected tahun-sampai" name="sampai_tahun[]" placeholder="Pilih sampai tahun">

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan</label>
                                                <input type="text" class="form-control" placeholder="Masukkan jabatan" name="jabatan[]">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Paklaring</label>
                                                <input type="text" class="form-control" placeholder="Masukkan paklaring" name="paklaring[]">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    let rowContent = $(content);
                    rowContent.find('select.tahun-sampai').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih sampai tahun'));
                    rowContent.find('select.tahun-dari').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih dari tahun'));
                    rowContent.find('.delete-row-data').on('click', Helper.deleteRowData).css('cursor','pointer');
                    Angga.setValueSelect2AjaxRemote(rowContent.find('select.tahun-dari'),{id:e.dari_tahun,text:e.dari_tahun});
                    Angga.setValueSelect2AjaxRemote(rowContent.find('select.tahun-sampai'),{id:e.sampai_tahun,text:e.sampai_tahun});
                    rowContent.find('input[name="jabatan[]"]').val(e.jabatan);
                    rowContent.find('input[name="paklaring[]').val(e.paklaring);
                    row.push(rowContent);
                });
                return row;
            }

            static addRowBiayaPendidikanAnak(data){
                let row = [];
                data.forEach((e,i)=>{
                    let content = `
                        <div class="col-md-12 mb-3">
                            <div class="card position-relative">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-row-data">
                                    <i class="ti ti-minus text-white"></i>
                                </span>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Anak ke</label>
                                                <input type="text" class="form-control integer-mask form-step-8" placeholder="Masukkan anak ke" name="anak_ke[]">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jenjang pendidikan</label>
                                                <select class="form-select tomselected form-step-8 jenjang-pendidikan" name="idjenjangpendidikan[]" placeholder="Pilih jenjang pendidikan">

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Jenis biaya pendidikan</label>
                                                <input type="text" class="form-control form-step-8" placeholder="Masukkan jenis biaya pendidikan" name="jenis_biaya_pendidikan[]">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Besaran dispensasi</label>
                                                <input type="text" class="form-control form-step-8 money-mask" placeholder="Masukkan besaran dispensasi" name="besaran_dispensasi[]">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    let rowContent = $(content);
                    rowContent.find('.delete-row-data').on('click', Helper.deleteRowData).css('cursor','pointer');
                    rowContent.find('select.jenjang-pendidikan').select2(Angga.generalAjaxSelect2('{{ route('select2.pendidikan.data') }}','Pilih dari pendidikan'));
                    Inputmask('numeric', {
                        radixPoint: ",",
                        allowMinus: false,
                        regex: "[0-9]*",
                        groupSeparator: ".",
                        rightAlign: false,
                        digits: 2, min: 0,
                        alias: 'numeric',
                        onBeforeMask: function (value, opts) {
                            return value;
                        }
                    }).mask(rowContent.find('.money-mask'));

                    var selectorinteger = rowContent[0].getElementsByClassName("integer-mask");
                    var iminteger = new Inputmask({
                        regex: "^[0-9]*$"
                    });
                    iminteger.mask(selectorinteger);

                    rowContent.find('input[name="anak_ke[]"]').val(e.anak_ke);
                    rowContent.find('input[name="jenis_biaya_pendidikan[]"]').val(e.jenis_biaya_pendidikan);
                    rowContent.find('input[name="besaran_dispensasi[]"]').val(e.besaran_dispensasi);
                    Angga.setValueSelect2AjaxRemote(rowContent.find('select.jenjang-pendidikan'),{id:e.idjenjangpendidikan,text:e.jenjangpendidikan});
                    row.push(rowContent);
                });
                return row;
            }

            static addRowSertifikat(data){
                let row = [];
                data.forEach((e,i)=>{
                    let content = `
                        <div class="col-md-12 mb-3">
                            <div class="card position-relative">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-row-data">
                                    <i class="ti ti-minus text-white"></i>
                                </span>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Nomor sertifikat</label>
                                                <input type="text" class="form-control form-step-5" placeholder="Input nomor sertifikat" name="nomor_sertifikat[]" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Jenis sertifikat</label>
                                                <select class="form-select tomselected form-step-5 jenis-sertifikat" name="idjenissertifikat[]" required placeholder="Pilih jenis sertifikat">

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Lembaga penyelenggara</label>
                                                <input type="text" class="form-control form-step-5" placeholder="Input lembaga penyelenggara" name="lembaga_penyelenggara[]" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Tahun</label>
                                                <select class="form-select tomselected form-step-5 tahun" name="tahun[]" required placeholder="Pilih tahun">

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Biaya</label>
                                                <input type="text" class="form-control form-step-5 money-mask" placeholder="Input biaya" name="biaya[]" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Jenis biaya</label>
                                                <select class="form-select tomselected form-step-5 biaya" name="idjenisbiaya[]" required placeholder="Pilih biaya">

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    let rowContent = $(content);
                    rowContent.find('select.jenis-sertifikat').select2(Angga.generalAjaxSelect2('{{ route('select2.jenis-sertifikat.data') }}','Pilih jenis sertifikat'));
                    rowContent.find('select.tahun').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih tahun'));
                    rowContent.find('select.biaya').select2(Angga.generalAjaxSelect2('{{ route('select2.biaya.data') }}','Pilih jenis biaya'));
                    rowContent.find('.delete-row-data').on('click', Helper.deleteRowData).css('cursor','pointer');
                    Inputmask('numeric', {
                        radixPoint: ",",
                        allowMinus: false,
                        regex: "[0-9]*",
                        groupSeparator: ".",
                        rightAlign: false,
                        digits: 2, min: 0,
                        alias: 'numeric',
                        onBeforeMask: function (value, opts) {
                            return value;
                        }
                    }).mask(rowContent.find('.money-mask'));

                    // set the data
                    Angga.setValueSelect2AjaxRemote(rowContent.find('select.jenis-sertifikat'),{id:e.idjenissertifikat,text:e.jenissertifikat});
                    Angga.setValueSelect2AjaxRemote(rowContent.find('select.tahun'),{id:e.tahun,text:e.tahun});
                    Angga.setValueSelect2AjaxRemote(rowContent.find('select.biaya'),{id:e.idjenisbiaya,text:e.jenisbiaya});
                    rowContent.find('.money-mask').val(e.biaya);
                    rowContent.find('input[name="nomor_sertifikat[]"]').val(e.nomor_sertifikat);
                    rowContent.find('input[name="lembaga_penyelenggara[]"]').val(e.lembaga_penyelenggara);
                    row.push(rowContent);
                });
                return row;
            }

            static addRowKeluarga(data){
                let row = [];
                data.forEach((e,i)=>{
                    let content = `
                        <div class="col-md-12 mb-3">
                            <div class="card position-relative">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-row-data">
                                    <i class="ti ti-minus text-white"></i>
                                </span>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Nama</label>
                                                <input type="text" class="form-control form-step-2" placeholder="Input nama lengkap" name="namakeluarga[]" value="${e.nama}" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Hubungan</label>
                                                <select class="form-select tomselected form-step-2" name="hubungankeluarga[]" required>
                                                    <option value="Suami" ${e.hubung == "Suami" ? `checked` : ``}>Suami</option>
                                                    <option value="Istri" ${e.hubung == "Istri" ? `checked` : ``}>Istri</option>
                                                    <option value="Anak" ${e.hubung == "Anak" ? `checked` : ``}>Anak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Tempat lahir</label>
                                                <input type="text" class="form-control form-step-2" placeholder="Tempat lahir" name="tempatlahirkeluarga[]" required value="${e.tempatlahir}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Tanggal lahir</label>
                                                <input type="text" class="form-control flat-picker form-step-2" placeholder="Tanggal lahir" name="tgllahirkeluarga[]" required value="${e.tanggallahir}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">No. telepon</label>
                                                <input type="text" class="form-control integer-mask form-step-2" placeholder="No. telepon" name="telpkeluarga[]" value="${e.telp}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Alamat<span class="form-label-description"></label>
                                                <textarea class="form-control form-step-2" rows="6" placeholder="Alamat" name="alamatkeluarga[]" required value="${e.alamat}">${e.alamat}</textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    let rowContent = $(content);
                    rowContent.find('.delete-row-data').on('click', Helper.deleteRowData).css('cursor','pointer');
                    flatpickr(rowContent.find('.flat-picker'),{
                        disableMobile: "true",
                        dateFormat: "j F Y",
                    });
                    var selectorinteger = rowContent.find(".integer-mask")[0];
                    var iminteger = new Inputmask({
                        regex: "^[0-9]*$"
                    });
                    iminteger.mask(selectorinteger);
                    row.push(rowContent);
                });
                return row;
            }

            closeModal(){
                Helper.reset();
                $('.previewFileOnNewTab').hide();
            }

            previewFileOnNewTab(e){
                const input = $(e.currentTarget).prev().find('input')[0];
                const file = input.files[0];
                const fileURL = URL.createObjectURL(file);
                window.open(fileURL, "_blank");
            }

            fileData(e) {
                const input = $(e.currentTarget);
                const only = input.attr('only');
                const name = e.currentTarget.name;
                const previewButton = $(e.currentTarget).parent().next();
                const file = e.target.files[0];

                // Reset tombol preview
                previewButton.hide();

                if (file) {
                    const fileName = file.name;

                    // ✅ Check ukuran file
                    const maxSize = 1 * 1024 * 1024; // 1 MB dalam byte
                    if (file.size > maxSize) {
                        Swal.fire('Informasi', 'Ukuran file maksimal 1 MB!', 'info');
                        input.val(""); // Reset input
                        return;
                    }

                    // ✅ Lanjutkan pengecekan format
                    const reader = new FileReader();
                    reader.onload = e => {
                        if (e.target.result) {
                            // Validasi format berdasarkan allowedTypes
                            if (!Index.allowedTypes.some(type => e.target.result.startsWith(`data:${type}`))) {
                                Swal.fire('Informasi', 'Format file tidak didukung!', 'info');
                                input.val("");
                                return;
                            }
                        }

                        // Validasi 'only' jika ada
                        if (only != undefined && !e.target.result.startsWith(`data:${only}`)) {
                            Swal.fire('Informasi', 'Format file tidak didukung!', 'info');
                            input.val("");
                            return;
                        }

                        previewButton.text(fileName);
                        previewButton.show();
                    };

                    reader.readAsDataURL(file);
                }
            }

            toggleLoadMore(e) {
                const items = $(e.currentTarget).parents('.card-body:first').find('.show-more');
                $.each(items,(index,el)=>{
                    el.classList.toggle('d-none')
                });

                const btn = event.target;
                btn.textContent = btn.textContent.includes('lebih') ? 'Sembunyikan' : 'Tampilkan lebih banyak';
            }

            change(e){
				$('#container-crop').parent().show();
                $('#wrapper-image-karyawan').hide();
				if (e.target.files.length) {
					// start file reader
					const reader = new FileReader();
					reader.onload = e => {
						if (e.target.result) {
							// create new image
							Index.CRP_Main.replace(e.target.result);

						}
					};
					reader.readAsDataURL(e.target.files[0]);
				}
			}

            simpanUploadKaryawan(){
                let formData = new FormData();
                Index.CRP_Main.getCroppedCanvas().toBlob((blob) => {
                    formData.append("gambar",blob);
                    formData.append("idpegawai","{{ $pegawai->nopeg }}")
                });

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
                            url : "{{ route('karyawan.edit.upload') }}",
                            method : "POST",
                            data : formData,
                            processData:false,
                            contentType:false,
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
                                    window.location.href = "{{ url('karyawan/edit/index') }}"+"/"+"{{ $pegawai->nopeg }}";
                                });
                            },
                            error : function(error){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }

            static getMenuJstree(){
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url : "{{ route('jstree.struktur-organisasi.data') }}",
                        method : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend : function(){
                            Swal.fire({
                                title: 'Mendapatkan data!',
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
                            resolve(result);
                        },
                        error : function(error){
                            Swal.close();
                            reject(error.responseJSON.message ?? error.responseJSON);
                        }
                    });
                });

            }

            static validate(form){
                let allow = true;
                let scroll = true;
                $.each(form[0].elements, function(i,e){
                    $(e).removeClass('is-invalid');
                    if(e.nodeName == 'INPUT' && e.type == 'text' || e.nodeName == 'TEXTAREA'){
                        if(($(e).val() == '') && $(e).attr('required')){
                            $(e).next().text($(e).attr('placeholder')+' belum disii!');
                            $(e).addClass('is-invalid');
                            allow = false;
                            if(scroll) Index.MD_EditDataKeluarga.scrollTop($(e).position().top);
                            scroll = false;
                        };
                    }else if(e.nodeName == 'SELECT'){
                        if(($(e).val() == '' || $(e).val() == undefined) && $(e).attr('required')){
                            $(e).parent().find('.invalid-feedback').text($(e).attr('placeholder')+' belum disii!');
                            $(e).addClass('is-invalid');
                            allow = false;
                            if(scroll) Index.MD_EditDataKeluarga.scrollTop($(e).position().top);
                            scroll = false;
                        };
                    }else if(e.type == 'hidden'){
                        // console.log(e);
                        if(($(e).val() == '') && $(e).attr('required')){
                            $(e).parent().find('.invalid-feedback').text($(e).next().attr('placeholder')+' belum disii!');
                            $(e).next().addClass('is-invalid');
                            allow = false;
                            if(scroll) Index.MD_EditDataKeluarga.scrollTop($(e).next().position().top);
                            scroll = false;
                        };
                    }
                });

                return allow;
            }

            showCanvas(){
                Index.MD_EditDataPekerjaan.modal('hide');
                Index.OFFCNVS_Main.show();
            }

            static deleteRowData(e){
                const eJquery = $(e.currentTarget);
                eJquery.parents('.card:first').parent().remove();
            }

            simpanDataPersonal(){
                const data = Index.FRM_EditDataPersonal.serializeObject();
                if(Helper.validate(Index.FRM_EditDataPersonal)){
                    Helper.store(data);
                }
            }

            simpanDataKeluarga(){
                const data = Index.FRM_EditDataKeluarga.serializeObject();
                if(Helper.validate(Index.FRM_EditDataKeluarga)){
                    Helper.store(data);
                }
            }

            simpanDataPekerjaan(){
                const data = Index.FRM_EditDataPekerjaan.serializeObject();
                if(Helper.validate(Index.FRM_EditDataPekerjaan)){
                    Helper.store(data);
                }
            }

            simpanDataPendidikan(){
                const data = Index.FRM_EditDataPendidikan.serializeObject();
                if(Helper.validate(Index.FRM_EditDataPendidikan)){
                    Helper.store(data);
                }
            }

            simpanDataSertifikat(){
                let data = Index.FRM_EditDataSertifikat.serializeObject();
                const organisasi = Index.FRM_EditDataSertifikat.find("input[name='organisasi']").val();
                data = $.extend(data,{organisasi});
                if(Helper.validate(Index.FRM_EditDataSertifikat)){
                    Helper.store(data);
                }
            }

            simpanDataKompetensi(){
                const data = Index.FRM_EditDataKompetensi.serializeObject();
                if(Helper.validate(Index.FRM_EditDataKompetensi)){
                    Helper.store(data);
                }
            }

            simpanDataPengalamanKerja(){
                const data = Index.FRM_EditDataPengalamanKerja.serializeObject();
                if(Helper.validate(Index.FRM_EditDataPengalamanKerja)){
                    Helper.store(data);
                }
            }

            simpanDataFasilitas(){
                const data = Index.FRM_EditDataFasilitas.serializeObject();
                if(Helper.validate(Index.FRM_EditDataFasilitas)){
                    Helper.store(data);
                }
            }

            editDataPersonal(){
                // Helper.reset();
                Index.MD_EditDataPersonal.find('input[name="nopeg"]').val("{{ $pegawai->nopeg }}");
                Index.MD_EditDataPersonal.find('input[name="nokk"]').val("{{ $pegawai->nokk }}");
                Index.MD_EditDataPersonal.find('input[name="nama"]').val("{{ $pegawai->nama }}");
                Index.MD_EditDataPersonal.find('input[name="tempatlahir"]').val("{{ $pegawai->tempatlahir }}");
                Index.MD_EditDataPersonal.find('input[name="noidentitas"]').val("{{ $pegawai->noidentitas }}");
                Index.MD_EditDataPersonal.find('input[name="tgl_lahir"]').val(flatpickr.formatDate(new Date("{{ $pegawai->tgl_lahir }}"), "j F Y"));
                Index.FRM_EditDataPersonal.find('input[value="{{ $pegawai->jns_kel }}"][name="jns_kel"]').prop('checked',true);
                Angga.setValueSelect2AjaxRemote(Index.S2_StatusNikah,{id:"{{ $pegawai->idstatusnikah }}" , text : "{{ $pegawai->status_nikah }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_GolDarah,{id:"{{ $pegawai->gol_darah }}" , text : "{{ $pegawai->gol_darah }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Agama,{id:"{{ $pegawai->idagama }}" , text : "{{ $pegawai->agama }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Kewarganegaraan,{id:"{{ $pegawai->kewarganegaraan }}" , text : "{{ $pegawai->kewarganegaraan }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Negara,{id:"{{ $pegawai->idwarganegara }}" , text : "{{ $pegawai->negara }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_TipeKartuIdentitas,{id:"{{ $pegawai->idkartuidentitas }}" , text : "{{ $pegawai->kartu_identitas }}"});
                Index.MD_EditDataPersonal.modal('show');
            }

            editDataKeluarga(){
                // Helper.reset();
                Index.FRM_EditDataKeluarga.find('input[name="nokk"]').val("{{ $pegawai->nokk }}")
                Index.FRM_EditDataKeluarga.find('input[name="nama_kepala_keluarga"]').val("{{ $pegawai->nama_kepala_keluarga }}")
                Index.FRM_EditDataKeluarga.find('input[name="nama_keluarga_darurat"]').val("{{ $pegawai->nama_keluarga_darurat }}")
                Index.FRM_EditDataKeluarga.find('input[name="telp_keluarga_darurat"]').val("{{ $pegawai->telp_keluarga_darurat }}")
                Index.MD_EditDataKeluarga.modal('show');
            }

            editDataPekerjaan(){
                // Helper.reset();
                Index.FRM_EditDataPekerjaan.find('input[name="nopeg"]').val("{{ $pegawai->nopeg }}");
                Index.FRM_EditDataPekerjaan.find('select[name="idstatuspegawai"]').val("{{ $pegawai->idstatuspegawai }}");
                Index.FRM_EditDataPekerjaan.find('input[name="tgl_masuk"]').val(flatpickr.formatDate(new Date("{{ $pegawai->tgl_masuk }}"), "j F Y"));
                Index.FRM_EditDataPekerjaan.find('input[name="tgl_berakhir_kontrak"]').val(flatpickr.formatDate(new Date("{{ $pegawai->tgl_berakhir_kontrak }}"), "j F Y"));
                Index.FRM_EditDataPekerjaan.find('input[name="masa_bakti"]').val("{{ $pegawai->masa_bakti }}");
                Index.FRM_EditDataPekerjaan.find('input[name="organisasi"]').val("{{ $pegawai->organisasi }}");
                Index.FRM_EditDataPekerjaan.find('input[name="organisasi"]').prev().val("{{ $pegawai->kodeorg }}");
                Index.FRM_EditDataPekerjaan.find('textarea[name="tugas_tambahan"]').val("{{ $pegawai->tugas_tambahan }}");

                Angga.setValueSelect2AjaxRemote(Index.S2_Fungsional,{id:"{{ $pegawai->kodejabfung }}" , text : "{{ $pegawai->jabatan_fungsional }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Struktural,{id:"{{ $pegawai->kodestruktural }}" , text : "{{ $pegawai->jabatan_struktural }}"});

                Index.MD_EditDataPekerjaan.modal('show');
            }

            editDataPendidikan(){
                // Helper.reset();
                Index.MD_EditDataPendidikan.find('input[name="prodi"]').val("{{ $pegawai->prodi }}");
                Index.MD_EditDataPendidikan.find('input[name="gelar"]').val("{{ $pegawai->gelar }}");
                Index.MD_EditDataPendidikan.find('input[name="namasekolah"]').val("{{ $pegawai->namasekolah }}");
                Angga.setValueSelect2AjaxRemote(Index.S2_PendidikanTerakhir,{id:"{{ $pegawai->kodependidikan }}" , text : "{{ $pegawai->pendidikan }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_TahunLulus,{id:"{{ $pegawai->tahun_lulus }}" , text : "{{ $pegawai->tahun_lulus }}"});
                Index.MD_EditDataPendidikan.modal('show');
            }

            editDataSertifikat(){
                // Helper.reset();
                let str = "{{ $pegawai->cert }}".replace(/&quot;/g, '"');
                // Ubah jadi objek
                let data = JSON.parse(str == "" ? "[]":str);
                Index.MD_EditDataSertifikat.find('#wrapper-sertifikat').html(Helper.addRowSertifikat(data));
                Index.MD_EditDataSertifikat.modal('show');
            }

            editDataKompetensi(){
                // Helper.reset();
                Index.FRM_EditDataKompetensi.find('input[name="kompetensi_hard_skill"]').val("{{ $pegawai->kompetensi_hard_skill }}");
                Index.FRM_EditDataKompetensi.find('input[name="kompetensi_soft_skill"]').val("{{ $pegawai->kompetensi_soft_skill }}");
                Index.MD_EditDataKompetensi.modal('show');
            }

            editDataPengalamanKerja(){
                // Helper.reset();
                let str = "{{ $pegawai->data_pengalaman_kerja }}".replace(/&quot;/g, '"');
                // Ubah jadi objek
                let data = JSON.parse(str == "" ? "[]":str);
                Index.MD_EditDataPengalamanKerja.find('#wrapper-pengalaman-kerja').html(Helper.addRowPengalamanKerja(data));
                Index.MD_EditDataPengalamanKerja.modal('show');
            }

            editDataFasilitas(){
                // Helper.reset();
                let str = "{{ $pegawai->data_biaya_pendidikan_anak }}".replace(/&quot;/g, '"');
                // Ubah jadi objek
                let data = JSON.parse(str == "" ? "[]":str);
                Index.MD_EditDataFasilitas.find('#wrapper-fasilitas').html(Helper.addRowBiayaPendidikanAnak(data));

                const tahunkendaraan = "{{ $pegawai->tahun_kendaraan }}";
                Angga.setValueSelect2AjaxRemote(Index.S2_TahunKendaraan,{id:tahunkendaraan,text:tahunkendaraan});

                Index.FRM_EditDataFasilitas.find('input[name="biaya_tempat_tinggal_pertahun"]').val("{{ $pegawai->biaya_tempat_tinggal_pertahun }}");
                Index.FRM_EditDataFasilitas.find('input[name="jumlah_beras_kg"]').val("{{ $pegawai->jumlah_beras_kg }}")
                Index.FRM_EditDataFasilitas.find('input[name="merk_kendaraan"]').val("{{ $pegawai->merk_kendaraan }}")
                Index.FRM_EditDataFasilitas.find('input[name="nama_lembaga_beasiswa_pendidikan"]').val("{{ $pegawai->nama_lembaga_beasiswa_pendidikan }}")
                Index.FRM_EditDataFasilitas.find('input[name="biaya_beasiswa_per_semester"]').val("{{ $pegawai->biaya_beasiswa_per_semester }}")
                Index.MD_EditDataFasilitas.modal('show');
            }

            static reset(){
                Index.FRM_EditDataPersonal[0].reset();
                Index.FRM_EditDataKeluarga[0].reset();
                Index.FRM_EditDataPekerjaan[0].reset();
                Index.FRM_EditDataPendidikan[0].reset();
                Index.FRM_EditDataSertifikat[0].reset();
                Index.FRM_EditDataKompetensi[0].reset();
                Index.FRM_EditDataPengalamanKerja[0].reset();
                Index.FRM_EditDataFasilitas[0].reset();
            }

            static store(data){
                data = $.extend(data,{nopeg_lama : "{{ $pegawai->nopeg }}"});
                let formData = new FormData();
                formData.append('_method', 'PATCH');
                $.each(data, (i,e)=>{
                    if(Array.isArray(e)) {
                        e.forEach((ee,ii)=>{
                            formData.append(i+"[]",ee);
                        });
                    }else{
                        formData.append(i,e);
                    }
                });
                formData.append('organisasi',Index.FRM_EditDataPekerjaan.find("input[name='organisasi']").val());

                // data personal
                formData.append("foto_npwp",Index.FRM_EditDataPersonal.find('input[name="foto_npwp"]')[0].files[0]);
                formData.append("foto_bpjs_kesehatan",Index.FRM_EditDataPersonal.find('input[name="foto_bpjs_kesehatan"]')[0].files[0]);
                formData.append("foto_bpjs_ketenagakerjaan",Index.FRM_EditDataPersonal.find('input[name="foto_bpjs_ketenagakerjaan"]')[0].files[0]);

                // pekerjaan
                formData.append("dok_surat_perjanjian_kerja",Index.FRM_EditDataPekerjaan.find('input[name="dok_surat_perjanjian_kerja"]')[0].files[0]);
                formData.append("dok_pakta_integritas",Index.FRM_EditDataPekerjaan.find('input[name="dok_pakta_integritas"]')[0].files[0]);
                formData.append("dok_hasil_test",Index.FRM_EditDataPekerjaan.find('input[name="dok_hasil_test"]')[0].files[0]);
                formData.append("dok_hasil_interview",Index.FRM_EditDataPekerjaan.find('input[name="dok_hasil_interview"]')[0].files[0]);

                //pendidikan
                formData.append("dok_ijazah",Index.FRM_EditDataPendidikan.find('input[name="dok_ijazah"]')[0].files[0]);
                formData.append("dok_transkrip_nilai",Index.FRM_EditDataPendidikan.find('input[name="dok_transkrip_nilai"]')[0].files[0]);
                console.log(formData,'formdata');
                Swal.fire({
                    title : 'Konfirmasi',
                    text : 'Apakah anda yakin ingin mengubah data?',
                    icon : 'question',
                    showCancelButton : true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText : 'Ya'
                }).then((result)=>{
                    if(result.isConfirmed){
                        $.ajax({
                            url : "{{ route('karyawan.edit.store') }}",
                            method : "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data : formData,
                            processData:false,
                            contentType:false,
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
                                Helper.reset();
                                Swal.fire({
                                    title : 'Berhasil',
                                    text : result.message,
                                    icon : 'success',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                }).then(()=>{
                                    window.location.reload();
                                });
                            },
                            error : function(error){
                                Swal.fire('Gagal',error.responseJSON.message,'error');
                            }
                        });
                    }
                });
            }

            selectedOrg(node,selected,event){
                if(selected.node.original.id == '0'){
                    Swal.fire('Informasi','Tidak boleh memilih yayasan','info');
                }else{
                    Index.FRM_EditDataPekerjaan.find('input[name="organisasi"]').val(selected.node.original.text).prev().val(selected.node.original.id);
                    Index.OFFCNVS_Main.hide();
                    Index.MD_EditDataPekerjaan.modal('show');
                    // Angga.setValueSelect2AjaxRemote(Index.S2_Fungsional,{text : '', id:''});
                    // Angga.setValueSelect2AjaxRemote(Index.S2_Struktural,{text : '', id:''});
                }
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static BTN_EditDataPersonal;
            static BTN_EditDataKeluarga;
            static BTN_EditDataPekerjaan;
            static BTN_EditDataPendidikan;
            static BTN_EditDataSertifikat;
            static BTN_EditDataKompetensi;
            static BTN_EditDataPengalamanKerja;
            static BTN_EditDataFasilitas;

            static BTN_SimpanDataPersonal;
            static BTN_SimpanDataKeluarga;
            static BTN_SimpanDataPekerjaan;
            static BTN_SimpanDataPendidikan;
            static BTN_SimpanDataSertifikat;
            static BTN_SimpanDataKompetensi;
            static BTN_SimpanDataPengalamanKerja;
            static BTN_SimpanDataFasilitas;

            static BTN_PreviewFile;
            static BTN_SearchOrg;
            static BTN_SimpanUploadKaryawan;
            static BTN_LoadMore;
            static BTN_CloseModal;

            static BTN_TambahKeluarga;
            static BTN_TambahSertifikat;
            static BTN_TambahFasilitas;

            static MD_EditDataPersonal;
            static MD_EditDataKeluarga;
            static MD_EditDataPekerjaan;
            static MD_EditDataPendidikan;
            static MD_EditDataSertifikat;
            static MD_EditDataKompetensi;
            static MD_EditDataPengalamanKerja;
            static MD_EditDataFasilitas;

            static FRM_EditDataPersonal;
            static FRM_EditDataPekerjaan;
            static FRM_EditDataPendidikan;
            static FRM_EditDataKeluarga;
            static FRM_EditDataSertifikat;
            static FRM_EditDataKompetensi;
            static FRM_EditDataPengalamanKerja;
            static FRM_EditDataFasilitas;

            static S2_StatusNikah;
            static S2_GolDarah;
            static S2_Agama;
            static S2_Kewarganegaraan;
            static S2_Negara;
            static S2_TipeKartuIdentitas;
            static S2_PendidikanTerakhir;
            static S2_TahunLulus;
            static S2_Pegawai;
            static S2_Fungsional;
            static S2_Struktural;
            static S2_TahunKendaraan;

            static JSTREE_Main;
            static DATA_Menu;
            static FILE_DATA;
            static allowedTypes;

            constructor() {
                super();

                Index.BTN_CloseModal = $('.modal-btn-close');
                Index.BTN_TambahSertifikat = $('#tambah-sertifikat');
                Index.BTN_TambahKeluarga = $("#tambah-keluarga");
                Index.BTN_TambahFasilitas = $('#tambah-data-fasilitas');

                Index.BTN_TambahPengalamanKerja = $('#tambah-pengalaman-kerja');
                Index.allowedTypes = [
                    'image/', // Semua jenis gambar (JPEG, PNG, GIF, dll.)
                    'application/pdf', // PDF
                    'application/msword', // Word format lama (doc)
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // Word format baru (docx)
                ];
                Index.BTN_PreviewFile = $('.previewFileOnNewTab');
                Index.FILE_DATA = $('input.file-data');
                Index.DATA_Menu = [];
                Index.BTN_LoadMore = $('.loadMore');

                Index.BTN_EditDataPersonal = $('#edit-data-personal').css('cursor','pointer');
                Index.BTN_EditDataKeluarga = $('#edit-data-keluarga').css('cursor','pointer');
                Index.BTN_EditDataPekerjaan = $('#edit-data-pekerjaan').css('cursor','pointer');
                Index.BTN_EditDataPendidikan = $('#edit-data-pendidikan').css('cursor','pointer');
                Index.BTN_EditDataSertifikat = $("#edit-data-sertifikat").css('cursor','pointer');
                Index.BTN_EditDataKompetensi = $("#edit-data-kompetensi").css('cursor','pointer');
                Index.BTN_EditDataPengalamanKerja = $('#edit-data-pengalaman-kerja').css('cursor','pointer');
                Index.BTN_EditDataFasilitas = $('#edit-data-fasilitas').css('cursor','pointer');

                Index.BTN_SimpanDataPersonal = $('#simpan-informasi-pribadi');
                Index.BTN_SimpanDataKeluarga = $('#simpan-data-keluarga');
                Index.BTN_SimpanDataPekerjaan = $('#simpan-data-pekerjaan');
                Index.BTN_SimpanDataPendidikan = $('#simpan-data-pendidikan');
                Index.BTN_SimpanDataSertifikat = $('#simpan-data-sertifikat');
                Index.BTN_SimpanUploadKaryawan = $('#simpan-image-karyawan');
                Index.BTN_SimpanDataKompetensi = $('#simpan-data-kompetensi');
                Index.BTN_SimpanDataPengalamanKerja = $('#simpan-data-pengalaman-kerja');
                Index.BTN_SimpanDataFasilitas = $('#simpan-data-fasilitas');

                Index.MD_EditDataPersonal = $('#modal-edit-data-pribadi');
                Index.MD_EditDataKeluarga = $('#modal-edit-data-keluarga');
                Index.MD_EditDataPekerjaan = $('#modal-edit-data-pekerjaan');
                Index.MD_EditDataPendidikan = $('#modal-edit-data-pendidikan');
                Index.MD_EditDataSertifikat = $('#modal-edit-data-sertifikat');
                Index.MD_EditDataKompetensi = $('#modal-edit-data-kompetensi');
                Index.MD_EditDataPengalamanKerja = $('#modal-edit-data-pengalaman-kerja')
                Index.MD_EditDataFasilitas = $('#modal-edit-data-fasilitas');

                Index.FRM_EditDataPersonal = Index.MD_EditDataPersonal.find('#form-edit-data-personal');
                Index.FRM_EditDataPekerjaan = $('#form-edit-data-pekerjaan');
                Index.FRM_EditDataSertifikat = $('#form-edit-data-sertifikat');
                Index.FRM_EditDataPendidikan = $('#form-edit-data-pendidikan');
                Index.FRM_EditDataKeluarga = $('#form-edit-keluarga');
                Index.FRM_EditDataKompetensi = $('#form-edit-data-kompetensi');
                Index.FRM_EditDataPengalamanKerja = $('#form-edit-data-pengalaman-kerja');
                Index.FRM_EditDataFasilitas = $('#form-edit-data-fasilitas');

                Index.INPUT_image = $('input#foto-profile');
                Index.CRP_Main = new Cropper($('.cropped')[0],{
					dragMode: 'move',
					aspectRatio: 1 / 1,
					restore: false,
					guides: false,
					center: false,
					highlight: false,
					cropBoxMovable: true,
					cropBoxResizable: false,
					toggleDragModeOnDblclick: false,
					minCropBoxWidth: 150,
					minCropBoxHeight: 150,
				});

                Index.JSTREE_Main = $("#organisasi").jstree({
                    "core" : {
                    "check_callback" : true
                    }
                });
                Index.JSTREE_Main = $.jstree.reference(Index.JSTREE_Main);

                Index.S2_StatusNikah = Index.FRM_EditDataPersonal.find('select[name="idstatusnikah"]').select2({
                    placeholder : 'Pilih status pernikahan',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPersonal.find('.modal-content')
                });
                Index.S2_GolDarah = Index.FRM_EditDataPersonal.find('select[name="gol_darah"]').select2({
                    placeholder : 'Pilih golongan darah',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPersonal.find('.modal-content')
                });
                Index.S2_Agama = Index.FRM_EditDataPersonal.find('select[name="agama"]').select2({
                    placeholder : 'Pilih agama',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPersonal.find('.modal-content')
                });
                Index.S2_Kewarganegaraan = Index.FRM_EditDataPersonal.find('select[name="kewarganegaraan"]').select2({
                    placeholder : 'Pilih kewarganegaraan',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPersonal.find('.modal-content')
                });
                Index.S2_Negara = Index.FRM_EditDataPersonal.find('select[name="idwarganegara"]').select2({
                    placeholder : 'Pilih negara',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPersonal.find('.modal-content')
                });
                Index.S2_TipeKartuIdentitas = Index.FRM_EditDataPersonal.find('select[name="idkartuidentitas"]').select2({
                    placeholder : 'Pilih tipe kartu identitas',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPersonal.find('.modal-content')
                });
                Index.S2_PendidikanTerakhir = Index.FRM_EditDataPendidikan.find('select[name="kodependidikan"]').select2({
                    placeholder : 'Pilih pendidikan',
                    theme : 'bootstrap-5',
                    dropdownParent : Index.MD_EditDataPendidikan.find('.modal-content')
                });
                Index.S2_TahunKendaraan = Index.FRM_EditDataFasilitas.find('select[name="tahun_kendaraan"]').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih tahun kendaraan'));
                Index.S2_TahunLulus = Index.FRM_EditDataPendidikan.find('select[name="tahun_lulus"]').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih tahun lulus'));
                Index.S2_Fungsional = Index.FRM_EditDataPekerjaan.find('select[name="kodejabfung"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.fungsional.data') }}','Pilih jabatan fungsional'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_EditDataPekerjaan.find('input[name="organisasi"]').prev().val();
                                    const $request = $.ajax(params);
                                    $request.then(success);
                                    $request.fail(failure);
                                    return $request;
                                }
                            }
                        }
                    )
                );

                Index.S2_Struktural = Index.FRM_EditDataPekerjaan.find('select[name="kodestruktural"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.struktural.data') }}','Pilih jabatan struktural'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_EditDataPekerjaan.find('input[name="organisasi"]').prev().val();
                                    const $request = $.ajax(params);
                                    $request.then(success);
                                    $request.fail(failure);
                                    return $request;
                                }
                            }
                        }
                    )
                );


                Index.BTN_SearchOrg = $('#search-organisasi');

                flatpickr('.flat-picker',{
                    disableMobile: "true",
                    dateFormat: "j F Y",
                });
                flatpickr('.flat-picker-years',{
                    disableMobile: "true",
                    dateFormat: "Y",
                    plugins: [
                        new monthSelectPlugin({
                        shorthand: false, //defaults to false
                        dateFormat: "Y", //defaults to "F Y"
                        altFormat: "Y", //defaults to "F Y"
                        })
                    ]
                });
                Index.OFFCNVS_Main = new bootstrap.Offcanvas(document.getElementById('canvas-main'));
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
                    // resolve(true);
                    Helper.getMenuJstree().then((result)=>{
                        Index.DATA_Menu = result;
                        resolve(true);
                    }).catch((error)=>{
                        console.log(error);
                    });
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
                Index.BTN_EditDataPersonal.on('click', this.editDataPersonal);
                Index.BTN_EditDataKeluarga.on('click', this.editDataKeluarga);
                Index.BTN_EditDataPekerjaan.on('click', this.editDataPekerjaan);
                Index.BTN_EditDataPendidikan.on('click', this.editDataPendidikan);
                Index.BTN_EditDataSertifikat.on('click', this.editDataSertifikat);
                Index.BTN_EditDataKompetensi.on('click', this.editDataKompetensi);
                Index.BTN_EditDataPengalamanKerja.on('click', this.editDataPengalamanKerja);
                Index.BTN_EditDataFasilitas.on('click',this.editDataFasilitas);

                Index.BTN_SimpanDataPersonal.on('click', this.simpanDataPersonal);
                Index.BTN_SimpanDataKeluarga.on('click', this.simpanDataKeluarga);
                Index.BTN_SimpanDataPekerjaan.on('click', this.simpanDataPekerjaan);
                Index.BTN_SimpanDataSertifikat.on('click', this.simpanDataSertifikat);
                Index.BTN_SimpanDataPendidikan.on('click', this.simpanDataPendidikan);
                Index.BTN_SimpanDataKompetensi.on('click', this.simpanDataKompetensi);
                Index.BTN_SimpanDataPengalamanKerja.on('click', this.simpanDataPengalamanKerja);
                Index.BTN_SimpanDataFasilitas.on('click', this.simpanDataFasilitas);

                Index.JSTREE_Main.element.on('select_node.jstree', this.selectedOrg);
                Index.BTN_SearchOrg.on('click', this.showCanvas);
                Index.INPUT_image.on('change', this.change);
                Index.BTN_SimpanUploadKaryawan.on('click', this.simpanUploadKaryawan);
                Index.BTN_LoadMore.on('click', this.toggleLoadMore);
                Index.FILE_DATA.on('change', this.fileData);
                Index.BTN_PreviewFile.on('click', this.previewFileOnNewTab);
                Index.BTN_CloseModal.on('click', this.closeModal);

                Index.BTN_TambahKeluarga.on('click', this.tambahKeluarga);
                Index.BTN_TambahSertifikat.on('click', this.tambahSertifikat);
                Index.BTN_TambahPengalamanKerja.on('click', this.tambahPengalamanKerja);
                Index.BTN_TambahFasilitas.on('click', this.tambahFasilitas);
                return this;
            }

            fireEvent() {
                return this;
            }

            loadDefaultValue() {
                Index.DATA_Menu.data.forEach(function(e,i){
                    Index.JSTREE_Main.create_node(e.parent,{text:e.text,id:e.id});
                });
                return this;
            }

            loadFinish() {
                Helper.reset();
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

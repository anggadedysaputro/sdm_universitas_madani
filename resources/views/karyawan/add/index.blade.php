@extends('app')
@section('title')
    Tambah karyawan
@endsection
@section('breadcrumb')
    <x-bread-crumbs breadcrumbtitle="karyawan.add.index"/>
@endsection
@section('page-title')
    Tambah karywan
@endsection
@section('action-list')
    <a href="{{ route('karyawan.index') }}" class="btn btn-primary"><i class="ti ti-users-group"></i> &nbsp;Data karyawan</a>
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
            <div class="col-md-12">
                <div class="d-flex flex-column">
                    <form action="#" id="form-karyawan">
                        <div id="smartwizard">
                            <ul class="nav">
                                <li class="nav-item">
                                <a class="nav-link" href="#step-1">
                                    <div class="num">1</div>
                                    DATA PERSONAL
                                </a>
                                </li>
                                <li class="nav-item">
                                <a class="nav-link" href="#step-2">
                                    <span class="num">2</span>
                                    DATA KELUARGA
                                </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-3">
                                    <span class="num">3</span>
                                    DATA PEKERJAAN
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-4">
                                    <span class="num">4</span>
                                    DATA PENDIDIKAN
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-5">
                                    <span class="num">5</span>
                                    DATA SERTIFIKAT
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-6">
                                    <span class="num">6</span>
                                    DATA KOMPETENSI
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-7">
                                    <span class="num">7</span>
                                    DATA PENGALAMAN KERJA
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-8">
                                    <span class="num">8</span>
                                    DATA FASILITAS
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                    <div class="d-flex flex-column gap-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label required">Foto Diri</label>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-2">
                                                            <img class="cropped_foto_diri" style="width:150px; height:150px;">
                                                        </div>
                                                    </div>
                                                    <input type="file" name="foto_diri" class="form-control file-data-personal" id="basic-default-foto" placeholder="Foto" accept="image/*">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Foto NPWP</label>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-3">
                                                            <img class="cropped_npwp" style="width:150px; height:150px;">
                                                        </div>
                                                    </div>
                                                    <input type="file" name="foto_npwp" class="form-control file-data-personal" id="basic-default-foto" placeholder="Foto" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Foto BPJS kesehatan</label>
                                                    <div class="d-flex justify-content-center" >
                                                        <div class="p-3">
                                                            <img class="cropped_bpjs_kesehatan" style="width:150px; height:150px;">
                                                        </div>
                                                    </div>
                                                    <input type="file" name="foto_bpjs_kesehatan" class="form-control file-data-personal" id="basic-default-foto" placeholder="Foto" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Foto BPJS Ketenagakerjaan</label>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="p-3">
                                                            <img class="cropped_bpjs_ketenagakerjaan" style="width:150px; height:150px;">
                                                        </div>
                                                    </div>
                                                    <input type="file" name="foto_bpjs_ketenagakerjaan" class="form-control file-data-personal" id="basic-default-foto" placeholder="Foto" accept="image/*">
                                                </div>
                                            </div> --}}
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label required">Nama lengkap</label>
                                                            <input type="text" class="form-control form-step-1" placeholder="Input nama lengkap" name="nama" required>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama panggilan</label>
                                                            <input type="text" class="form-control form-step-1" placeholder="Input nama panggilan" name="nama_panggilan">
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
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label required">Tanggal lahir</label>
                                                            <input type="text" class="form-control flat-picker form-step-1" placeholder="Tempat lahir" name="tgl_lahir" required>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label required">Jenis kelamin</label>
                                                        <div class="row">
                                                            <div class="col-6 col-sm-4">
                                                                <label class="form-check form-check-inline">
                                                                    <input type="radio" value="L" class="form-check-input form-step-1" name="jns_kel" required checked>
                                                                    <span class="form-check-label">Laki laki</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-6 col-sm-4">
                                                                <label class="form-check form-check-inline">
                                                                    <input type="radio" value="P" class="form-check-input form-step-1" name="jns_kel" required>
                                                                    <span class="form-check-label">Perempuan</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label required">Status perkawinan</label>
                                                            <select class="form-select tomselected form-step-1" name="idstatusnikah" required placeholder="Status perkawinan">
                                                                <option value="">Pilih status perkawinan</option>
                                                                @foreach ($statusnikah as $value)
                                                                    <option value="{{ $value->idstatusnikah }}">{{ $value->status }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <div>
                                                        <label class="form-label">Foto NPWP</label>
                                                        <input type="file" name="foto_npwp" class="file-data form-control" id="basic-default-foto" placeholder="Foto" accept="image/*">
                                                    </div>
                                                    <a href="#" class="previewFileOnNewTab mb-3"></a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Foto BPJS Kesehatan</label>
                                                    <input type="file" name="foto_bpjs_kesehatan" class="file-data form-control" id="basic-default-foto" placeholder="Foto" accept="image/*" only="image/">
                                                </div>
                                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Foto BPJS Ketenagakerjaan</label>
                                                    <input type="file" name="foto_bpjs_ketenagakerjaan" class="file-data form-control" id="basic-default-foto" placeholder="Foto" accept="image/*" only="image/">
                                                </div>
                                                <a href="#" class="previewFileOnNewTab mb-3"></a>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Golongan darah</label>
                                                    <select class="form-select tomselected form-step-1" name="gol_darah" required placeholder="Golongan darah">
                                                        <option value="">Pilih golongan darah</option>
                                                        @foreach ($golongan_darah as $value)
                                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Agama</label>
                                                    <select class="form-select tomselected form-step-1" name="agama" required placeholder="Agama">
                                                        <option value="">Pilih agama</option>
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
                                                                <select class="form-select tomselected form-step-1" name="kewarganegaraan" required placeholder="Kewarganegaraan">
                                                                    <option value="">Pilih kewarganegaraan</option>
                                                                    <option value="WNI" selected>WNI</option>
                                                                    <option value="WNA">WNA</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <select class="form-select tomselected form-step-1" name="idwarganegara" required placeholder="Negara">
                                                                    <option value="">Pilih negara</option>
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">Tipe kartu identitas</label>
                                                    <select class="form-select tomselected form-step-1" name="idkartuidentitas" required placeholder="Pilih Tipe kartu identitas">
                                                        <option value="">Pilih tipe kartu identitas</option>
                                                        @foreach ($kartuidentitas as $value)
                                                            <option value="{{ $value->id }}">{{ $value->keterangan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">ID kartu identitas</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="Masukkan ID kartu identitas" name="noidentitas" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Email</label>
                                                    <input type="text" class="form-control form-step-1 email-mask" placeholder="Masukkan email" name="email" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label required">No. HP</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="Masukkan No. HP" name="nohp" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No. telepon</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="Masukkan No. Telepon" name="telp">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">No. telepon darurat</label>
                                                    <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. telepon darurat" name="notelpdarurat">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Alamat kartu identitas <span class="form-label-description"></label>
                                                    <textarea class="form-control form-step-1" rows="6" placeholder="Masukkan alamat kartu identitas" name="alamat" required></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat domisili <span class="form-label-description"></label>
                                                    <textarea class="form-control form-step-1" rows="6" placeholder="Masukkan alamat domisili" name="alamat_domisili"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No. NPWP</label>
                                                    <input type="text" class="form-control" placeholder="Masukkan No. NPWP" name="npwp">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No. Rekening</label>
                                                    <input type="text" class="form-control" placeholder="Masukkan Nomor rekening bank" name="rekbank">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No KPJ BPJS ketenagakerjaan</label>
                                                    <input type="text" class="form-control" placeholder="Tempat lahir" name="no_bpjs_ketenagakerjaan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Efektif <i class="ti ti-info-circle-filled"></i></label>
                                                    <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" name="tgl_bpjs_ketenagakerjaan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">No BPJS kesehatan</label>
                                                    <input type="text" class="form-control" placeholder="Tempat lahir" name="no_bpjs_kesehatan">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Efektif <i class="ti ti-info-circle-filled"></i></label>
                                                    <input type="text" class="form-control flat-picker" placeholder="Tempat lahir" name="tgl_bpjs_kesehatan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
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
                                                <div class="row" id="wrapper-keluarga">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
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
                                </div>
                                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Jenjang pendidikan terakhir</label>
                                                <select class="form-select tomselected form-step-4" name="kodependidikan" required placeholder="Jenjang pendidikan terakhir"></select>
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
                                </div>
                                <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Daftar sertifikat <button class="btn btn-success btn-sm" type="button" id="tambah-sertifikat"><i class="ti ti-plus"></i></button></h3>
                                            <div class="row" id="wrapper-sertifikat">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
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
                                </div>
                                <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Pengalaman kerja <button class="btn btn-success btn-sm" type="button" id="tambah-pengalaman-kerja"><i class="ti ti-plus"></i></button></h3>
                                            <div class="row" id="wrapper-pengalaman-kerja">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-8" class="tab-pane" role="tabpanel" aria-labelledby="step-8">
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
                                                <input type="text" class="form-control decimal-mask" placeholder="Masukkan jumlah KG" name="jumlah_beras_kg">
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
                                        <div class="col-md-12">
                                            <h3>Biaya pendidikan anak <button class="btn btn-success btn-sm" type="button" id="tambah-biaya-pendidikan-anak"><i class="ti ti-plus"></i></button></h3>
                                            <div class="row" id="wrapper-biaya-pendidikan-anak">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-default me-1" id="kembali">Kembali</button>
                        <button class="btn btn-primary me-1" id="selanjutnya">Selanjutnya</button>
                        <button class="btn btn-success" id="simpan" style="display: none;">Simpan</button>
                    </div>
                </div>
            </div>
            <div class="col-md-2">

            </div>
        </div>

    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasEndLabel" id="canvas-main">
    <div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Daftar fungsional</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
                    rowContent.find('.delete-row-data').on('click', Helper.deleteRowData).css('cursor','pointer');
                    rowContent.find('select.jenis-sertifikat').select2(Angga.generalAjaxSelect2('{{ route('select2.jenis-sertifikat.data') }}','Pilih jenis sertifikat'));
                    rowContent.find('select.tahun').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih tahun'));
                    rowContent.find('select.biaya').select2(Angga.generalAjaxSelect2('{{ route('select2.biaya.data') }}','Pilih jenis biaya'));

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

                    row.push(rowContent);
                });
                return row;
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
                    rowContent.find('.delete-row-data').on('click', Helper.deleteRowData).css('cursor','pointer');
                    rowContent.find('select.tahun-sampai').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih sampai tahun'));
                    rowContent.find('select.tahun-dari').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih dari tahun'));
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
                                                    <option value="Ayah" ${e.hubung == "Ayah" ? `checked` : ``}>Ayah</option>
                                                    <option value="Ibu" ${e.hubung == "Ibu" ? `checked` : ``}>Ibu</option>
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

            static deleteRowData(e){
                const eJquery = $(e.currentTarget);
                eJquery.parents('.card:first').parent().remove();
            }

            tambahKeluarga(){
                const data = Helper.addRowKeluarga(
                    [
                        {"nama":"", "hubungan":"", "telp" : "", "alamat":"", "tempatlahir":"","tanggallahir":""},
                    ]
                );
                let wrapper = $('#wrapper-keluarga');
                wrapper.append(data);
                Index.WIZARD_Main.smartWizard("fixHeight");
            }

            tambahSertifikat(){
                const data = Helper.addRowSertifikat(
                    [
                        {"nomor_sertifikat":"", "jenis_sertifikat":"", "lembaga_penyelenggara" : "", "tahun":"", "biaya":"","jenis_biaya":""},
                    ]
                );
                let wrapper = $('#wrapper-sertifikat');
                wrapper.append(data);
                Index.WIZARD_Main.smartWizard("fixHeight");
            }

            tambahPengalamanKerja(){
                const data = Helper.addRowPengalamanKerja(
                    [
                        {tahun:""}
                    ]
                );
                let wrapper = $('#wrapper-pengalaman-kerja');
                wrapper.append(data);
                Index.WIZARD_Main.smartWizard("fixHeight");
            }

            tambahBiayaPendidikanAnak(){
                const data = Helper.addRowBiayaPendidikanAnak(
                    [
                        {anak_ke:""}
                    ]
                );
                let wrapper = $('#wrapper-biaya-pendidikan-anak');
                wrapper.append(data);
                Index.WIZARD_Main.smartWizard("fixHeight");
            }

            filePersonal(e){
                const name = e.currentTarget.name;

				if (e.target.files.length) {
                    // start file reader
					const reader = new FileReader();
					reader.onload = e => {
						if (e.target.result) {

                            if (!e.target.result.startsWith('data:image/')) {
                                Swal.fire('Informasi','Hanya boleh gambar','info');
                                return;
                            }
                            if(name == 'foto_diri'){
                                Index.CRP_FOTO_DIRI.replace(e.target.result);
                            }/* else if(name == 'foto_npwp'){
                                Index.CRP_FOTO_NPWP.replace(e.target.result);
                            }else if(name == 'foto_bpjs_kesehatan'){
                                Index.CRP_FOTO_BPJS_KESEHATAN.replace(e.target.result);
                            }else{
                                Index.CRP_FOTO_BPJS_KETENAGAKERJAAN.replace(e.target.result);
                            } */

						}
					};
					reader.readAsDataURL(e.target.files[0]);
				}
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
                        Index.WIZARD_Main.smartWizard("fixHeight");
                    };

                    reader.readAsDataURL(file);
                }
            }


            previewFileOnNewTab(e){
                const input = $(e.currentTarget).prev().find('input')[0];
                const file = input.files[0];
                const fileURL = URL.createObjectURL(file);
                window.open(fileURL, "_blank");
            }

            static assignLocalStorage() {
                localStorage.removeItem(Index.LCS_Formulir);
                localStorage.setItem(Index.LCS_Formulir, JSON.stringify(Index.FRM_Main.serializeObject()));
            }

            static validate(step){
                const elements = Index.FRM_Main.find('.'+step);
                let allow = true;
                let scroll = true;
                $.each(elements, function(i,e){
                    $(e).removeClass('is-invalid');
                    if(e.nodeName == 'INPUT' && e.type == 'text' || e.nodeName == 'TEXTAREA'){
                        if(($(e).val() == '') && $(e).attr('required')){
                            $(e).next().text($(e).attr('placeholder')+' belum disii!');
                            $(e).addClass('is-invalid');
                            allow = false;
                            if(scroll) $(window).scrollTop($(e).position().top);
                            scroll = false;
                        };
                    }else if(e.nodeName == 'SELECT'){
                        if(($(e).val() == '' || $(e).val() == undefined) && $(e).attr('required')){
                            $(e).parent().find('.invalid-feedback').text($(e).attr('placeholder')+' belum disii!');
                            $(e).addClass('is-invalid');
                            allow = false;
                            if(scroll) $(window).scrollTop($(e).position().top);
                            scroll = false;
                        };
                    }else if(e.type == 'hidden'){
                        // console.log(e);
                        if(($(e).val() == '') && $(e).attr('required')){
                            $(e).parent().find('.invalid-feedback').text($(e).next().attr('placeholder')+' belum disii!');
                            $(e).next().addClass('is-invalid');
                            allow = false;
                            if(scroll) $(window).scrollTop($(e).next().position().top);
                            scroll = false;
                        };
                    }
                });

                Index.WIZARD_Main.smartWizard("fixHeight");
                return allow;
            }

            static verify(){
                let stepInfo = Index.WIZARD_Main.smartWizard("getStepInfo");
                let next = false;
                Index.BTN_Simpan.hide();
                Index.BTN_Next.show();
                Index.FILE_DataPersonal.removeClass('is-invalid');

                if(stepInfo.currentStep == 0){
                    if(!Index.CRP_FOTO_DIRI.getCroppedCanvas()){
                        Swal.fire({title:"Informasi",text:"Foto diri belum dimasukkan!",icon:"info",returnFocus: false });

                        Index.FILE_DataPersonal.filter('[name="foto_diri"]').addClass('is-invalid');
                        window.scrollTo(0, 0);
                        return;
                    }
                    next = Helper.validate('form-step-1');
                }else if(stepInfo.currentStep == 1){
                    next = Helper.validate('form-step-2');
                }else if(stepInfo.currentStep == 2){
                    next = Helper.validate('form-step-3');
                }else if(stepInfo.currentStep == 3){
                    next = Helper.validate('form-step-4');
                }else if(stepInfo.currentStep == 4){
                    next = Helper.validate('form-step-5');
                }else if(stepInfo.currentStep == 5){
                    next = Helper.validate('form-step-6');
                }else if(stepInfo.currentStep == 6){
                    next = Helper.validate('form-step-7');
                    if(next){
                        Index.BTN_Next.hide();
                        Index.BTN_Simpan.show();
                    }
                }


                if(next) Index.WIZARD_Main.smartWizard('next');
            }

            next(){
                Helper.verify();
                Helper.assignLocalStorage();
            }
            simpan(){
                let data = Index.FRM_Main.serializeObject();
                let alamat = Index.FRM_Main.find('textarea[name="alamat"]').val();
                let organisasi = Index.FRM_Main.find("input[name='organisasi']").val();
                data = $.extend(data, {alamat,organisasi});
                let formData = new FormData();
                $.each(data, (i,e)=>{
                    if(Array.isArray(e)) {
                        e.forEach((ee,ii)=>{
                            formData.append(i+"[]",ee);
                        });
                    }else{
                        formData.append(i,e);
                    }
                });

                // biodata
                formData.append("foto_npwp",Index.FRM_Main.find('input[name="foto_npwp"]')[0].files[0]);
                formData.append("foto_bpjs_kesehatan",Index.FRM_Main.find('input[name="foto_bpjs_kesehatan"]')[0].files[0]);
                formData.append("foto_bpjs_ketenagakerjaan",Index.FRM_Main.find('input[name="foto_bpjs_ketenagakerjaan"]')[0].files[0]);

                // pekerjaan
                formData.append("dok_surat_perjanjian_kerja",Index.FRM_Main.find('input[name="dok_surat_perjanjian_kerja"]')[0].files[0]);
                formData.append("dok_pakta_integritas",Index.FRM_Main.find('input[name="dok_pakta_integritas"]')[0].files[0]);
                formData.append("dok_hasil_test",Index.FRM_Main.find('input[name="dok_hasil_test"]')[0].files[0]);
                formData.append("dok_hasil_interview",Index.FRM_Main.find('input[name="dok_hasil_interview"]')[0].files[0]);

                //pendidikan
                formData.append("dok_ijazah",Index.FRM_Main.find('input[name="dok_ijazah"]')[0].files[0]);
                formData.append("dok_transkrip_nilai",Index.FRM_Main.find('input[name="dok_transkrip_nilai"]')[0].files[0]);


                Index.CRP_FOTO_DIRI.getCroppedCanvas().toBlob((blob) => {
                    formData.append("gambar",blob);
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
                                url : "{{ route('karyawan.add.store') }}",
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
                                        window.location.href = "{{ route('karyawan.index') }}";
                                    });
                                },
                                error : function(error){
                                    Swal.fire('Gagal',error.responseJSON.message,'error');
                                }
                            });
                        }
                    });
                });
            }
            previous(){
                Index.BTN_Next.show();
                Index.BTN_Simpan.hide();
                Index.WIZARD_Main.smartWizard('prev');
            }
            showCanvas(){
                Index.OFFCNVS_Main.show();
            }
            selectedOrg(node,selected,event){
                if(selected.node.original.id == '0'){
                    Swal.fire('Informasi','Tidak boleh memilih yayasan','info');
                }else{
                    Index.FRM_Main.find('input[name="organisasi"]').val(selected.node.original.text).prev().val(selected.node.original.id);
                    Index.OFFCNVS_Main.hide();
                    // Angga.setValueSelect2AjaxRemote(Index.S2_JabatanFungsional,{text : '', id:''});
                    // Angga.setValueSelect2AjaxRemote(Index.S2_JabatanStruktural,{text : '', id:''});
                }
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
        }

        export default class Index extends Helper{
            // deklarasi variabel
            OBJ_Foto;
            static WIZARD_Main;
            static BTN_Next;
            static BTN_Previous;
            static BTN_Simpan;
            static BTN_SearchOrg;
            static FRM_Main;
            static LCS_Formulir;
            static S2_JabatanStruktural;
            static S2_JabatanFungsional;
            static JSTREE_Main;
            static DATA_Menu;
            static OFFCNVS_Main;
            static CRP_FOTO_DIRI;
            static CRP_FOTO_NPWP;
            static CRP_FOTO_BPJS_KESEHATAN;
            static CRP_FOTO_BPJS_KETENAGAKERJAAN;
            static FILE_DataPersonal;
            static FILE_DATA;
            static BTN_TambahKeluarga;
            static BTN_TambahSertifikat;
            static BTN_TambahPengalamanKerja;
            static BTN_PreviewPekerjaanFile;
            static BTN_TambahBiayaPendidikanAnak;
            static allowedTypes;

            constructor() {
                super();
                Index.BTN_PreviewPekerjaanFile = $('.previewFileOnNewTab');
                Index.allowedTypes = [
                    'image/', // Semua jenis gambar (JPEG, PNG, GIF, dll.)
                    'application/pdf', // PDF
                    'application/msword', // Word format lama (doc)
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // Word format baru (docx)
                ];

                this.OBJ_Foto = {
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
				};

                Index.JSTREE_Main = $("#organisasi").jstree({
                    "core" : {
                    "check_callback" : true
                    }
                });

                Index.BTN_TambahKeluarga = $("#tambah-keluarga");
                Index.BTN_TambahSertifikat = $('#tambah-sertifikat');
                Index.BTN_TambahPengalamanKerja = $('#tambah-pengalaman-kerja');
                Index.BTN_TambahBiayaPendidikanAnak = $('#tambah-biaya-pendidikan-anak');
                Index.FILE_DataPersonal = $('input.file-data-personal');
                Index.FILE_DATA = $('input.file-data');

                Index.CRP_FOTO_DIRI = new Cropper($('.cropped_foto_diri')[0],this.OBJ_Foto);
                // Index.CRP_FOTO_NPWP = new Cropper($('.cropped_npwp')[0],this.OBJ_Foto);
                // Index.CRP_FOTO_BPJS_KESEHATAN = new Cropper($('.cropped_bpjs_kesehatan')[0],this.OBJ_Foto);
                // Index.CRP_FOTO_BPJS_KETENAGAKERJAAN = new Cropper($('.cropped_bpjs_ketenagakerjaan')[0],this.OBJ_Foto);

                Index.JSTREE_Main = $.jstree.reference(Index.JSTREE_Main);
                Index.OFFCNVS_Main = new bootstrap.Offcanvas(document.getElementById('canvas-main'));

                Index.LCS_Formulir = 'formulir_sdm_icbb_';
                Index.WIZARD_Main = $("#smartwizard").smartWizard({
                    theme: 'dots',
                    toolbar: {
                        position: 'none', // none|top|bottom|both
                        showNextButton: true, // show/hide a Next button
                        showPreviousButton: true, // show/hide a Previous button
                        extraHtml: '' // Extra html to show on toolbar
                    },
                    enableUrlHash : false,
                    keyboard: {
                        keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                    },
                });

                Index.BTN_Next = $('#selanjutnya');
                Index.BTN_Previous = $('#kembali');
                Index.BTN_Simpan = $('#simpan');

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
                Index.FRM_Main = $('#form-karyawan');
                Index.S2_JabatanFungsional = Index.FRM_Main.find('select[name="kodejabfung"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.fungsional.data') }}','Pilih jabatan fungsional'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_Main.find('input[name="organisasi"]').prev().val();
                                    const $request = $.ajax(params);
                                    $request.then(success);
                                    $request.fail(failure);
                                    return $request;
                                }
                            }
                        }
                    )
                );
                Index.S2_JabatanStruktural = Index.FRM_Main.find('select[name="kodestruktural"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.struktural.data') }}','Pilih jabatan struktural'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_Main.find('input[name="organisasi"]').prev().val();
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
                Index.FRM_Main.find('select[name="tahun_kendaraan"]').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih tahun kendaraan'))
                Index.FRM_Main.find('select[name="tahun_lulus"]').select2(Angga.generalAjaxSelect2('{{ route('select2.tahun.data') }}','Pilih tahun lulus'))
                Index.FRM_Main.find('select[name="kodependidikan"]').select2(Angga.generalAjaxSelect2('{{ route('select2.pendidikan.data') }}','Pilih jenjang pendidikan'))

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
                // console.log(Index.BTN_Next);
                Index.BTN_Next.on('click', this.next);
                Index.BTN_Previous.on('click', this.previous);
                Index.BTN_SearchOrg.on('click', this.showCanvas);
                Index.JSTREE_Main.element.on('select_node.jstree', this.selectedOrg);
                Index.BTN_Simpan.on('click', this.simpan);
                Index.FILE_DataPersonal.on('change', this.filePersonal);
                Index.FILE_DATA.on('change', this.fileData);
                Index.BTN_TambahKeluarga.on('click', this.tambahKeluarga);
                Index.BTN_TambahSertifikat.on('click', this.tambahSertifikat);
                Index.BTN_TambahPengalamanKerja.on('click', this.tambahPengalamanKerja);
                Index.BTN_TambahBiayaPendidikanAnak.on('click', this.tambahBiayaPendidikanAnak);
                Index.BTN_PreviewPekerjaanFile.on('click', this.previewFileOnNewTab);
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
                // $('#smartwizard').SmartWizard();
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

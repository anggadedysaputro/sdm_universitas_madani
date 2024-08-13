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
                                <input type="file" class="form-control" id="basic-default-foto" placeholder="Foto" accept="image/*">
                                <button class="btn btn-success flex-fill" id="simpan-image-karyawan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <h3>Informasi pribadi</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-informasi-pribadi"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        NIPY
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->nopeg }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->nama }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tempat lahir
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->tempatlahir }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tanggal lahir
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->tanggal_lahir }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jenis kelamin
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->jenis_kelamin }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Golongan darah
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->gol_darah }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Agama
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->agama }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Status nikah
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->status_nikah }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Kewarganegaraan
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->kewarganegaraan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Negara
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->negara }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nomor kartu keluarga
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->nokk }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h3>Keluarga</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-keluarga"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            @foreach ($keluarga as $key => $value)
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        {{ $value->hubungan }}
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $value->nama }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Kontak</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-kontak"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tipe kartu identitas
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->kartu_identitas }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nomor kartu identitas
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->noidentitas }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Alamat
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->alamat }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        No. HP
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->nohp }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        No. telepon
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->telp }}
                                    </div>
                                </div>
                            </div>

                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        No. telepon darurat
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->notelpdarurat }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Email
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Pendidikan terkahir</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-pendidikanterakhir"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jenjang pendidikan terakhir
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->pendidikan }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tahun lulus
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->tahun_lulus }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama institusi pendidikan
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->namasekolah }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Program studi
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->prodi }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h3>Kepegawaian</h3>
                            <span>
                                <i class="ti ti-dots-vertical" id="edit-kepegawaian"></i>
                            </span>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable border-bottom">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Status pegawai
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->status_pegawai }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Tanggal bergabung
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->tanggal_masuk }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jabatan fungsional
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->jabatan_fungsional }}
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-5">
                                        Jabatan struktural
                                    </div>
                                    <div class="col-md-2">:</div>
                                    <div class="col-md-5">
                                        {{ $pegawai->jabatan_struktural }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal informasi pribadi --}}
    <div class="modal modal-blur fade" id="modal-edit-informasi-pribadi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit informasi pribadi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-informasi-pribadi">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">NIPY</label>
                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="NIPY" name="nopeg" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">No kartu keluarga</label>
                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="Nomor kartu keluarga" name="nokk" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama lengkap</label>
                                <input type="text" class="form-control form-step-1" placeholder="Input nama lengkap" name="nama" required>
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
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-informasi-pribadi">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal kontak --}}
    <div class="modal modal-blur fade" id="modal-edit-kontak" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit informasi pribadi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-kontak">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tipe kartu identitas</label>
                                <select type="text" class="form-select tomselected form-step-1" name="idkartuidentitas" required>
                                    @foreach ($kartuidentitas as $value)
                                        <option value="{{ $value->id }}">{{ $value->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">ID kartu identitas</label>
                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="Input ID kartu identitas" name="noidentitas" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Email</label>
                                <input type="text" class="form-control form-step-1 email-mask" placeholder="Email" name="email" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">No. HP</label>
                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. HP" name="nohp" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">No. telepon</label>
                                <input type="text" class="form-control form-step-1 integer-mask" placeholder="No. Telepon" name="telp" required>
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
                                <textarea class="form-control form-step-1" rows="6" placeholder="Alamat kartu identitas" name="alamat" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-kontak">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal pendidikanterakhir --}}
    <div class="modal modal-blur fade" id="modal-edit-pendidikanterakhir" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit pendidikan terakhir</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-pendidikanterakhir">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Jenjang pendidikan terakhir</label>
                                <select type="text" class="form-select tomselected form-step-1" name="kodependidikan" required>
                                    @foreach ($pendidikan as $value)
                                        <option value="{{ $value->kodependidikan }}">{{ $value->keterangan }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tahun lulus</label>
                                <input type="text" class="form-control form-step-1 flat-picker-years" placeholder="Tahun lulus" name="tahun_lulus" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Nama institusi pendidikan</label>
                                <input type="text" class="form-control form-step-1" placeholder="Nama institusi pendidikan" name="namasekolah" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Program studi</label>
                                <input type="text" class="form-control form-step-1" placeholder="Program studi" name="prodi">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-pendidikanterakhir">Simpan</button>
            </div>
          </div>
        </div>
    </div>

    {{-- modal kepegawaian --}}
    <div class="modal modal-blur fade" id="modal-edit-kepegawaian" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit kepegawaian</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-kepegawaian">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Status karyawan</label>
                                <select type="text" class="form-select tomselected form-step-2" name="idstatuspegawai" required>
                                    @foreach ($statuspegawai as $value)
                                        <option value="{{ $value->idstatuspegawai }}">{{ $value->keterangan }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Tanggal bergabung</label>
                                <input type="text" class="form-control flat-picker form-step-2" placeholder="Tanggal bergabung" name="tgl_masuk" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Pilih organisasi</label>
                                <div class="row g-2">
                                  <div class="col">
                                    <input type="hidden">
                                    <input type="text" class="form-control" placeholder="Klik tombol cari.." disabled name="organisasi">
                                  </div>
                                  <div class="col-auto">
                                    <button type="button" class="btn btn-icon" aria-label="Button" id="search-organisasi">
                                      <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                                    </button>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jabatan struktural</label>
                                <select type="text" class="form-select tomselected" name="kodestruktural">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jabatan fungsional</label>
                                <select type="text" class="form-select tomselected" name="kodejabfung">
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-kepegawaian">Simpan</button>
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

    {{-- modal keluarga --}}
    <div class="modal modal-blur fade" id="modal-edit-keluarga" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit keluarga</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit-keluarga">
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
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="simpan-keluarga">Simpan</button>
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
                let valid = true;
                $.each(form[0].elements, function(i,e){
                    $(e).removeClass('is-invalid');
                    if(e.nodeName == 'INPUT' && e.type == 'text' && e.name != 'organisasi'){
                        if($(e).val() == ''){
                            $(e).addClass('is-invalid').next().text($(e).attr('placeholder')+' belum diisi!');
                            valid = false;
                        }
                    }
                });

                return valid;
            }

            showCanvas(){
                Index.MD_EditKepegawaian.modal('hide');
                Index.OFFCNVS_Main.show();
            }

            deleteKeluarga(e){
                const eJquery = $(e.currentTarget);
                eJquery.parents('.card:first').remove();
            }

            simpanKeluarga(){
                const data = Index.FRM_EditKeluarga.serializeObject();
                if(Helper.validate(Index.FRM_EditKeluarga)){
                    Helper.store(data);
                }
            }

            simpanInformasiPribadi(){
                const data = Index.FRM_EditInformasiPribadi.serializeObject();
                if(Helper.validate(Index.FRM_EditInformasiPribadi)){
                    Helper.store(data);
                }
            }

            simpanKepegawaian(){
                const data = Index.FRM_Kepegawaian.serializeObject();
                if(Helper.validate(Index.FRM_Kepegawaian)){
                    Helper.store(data);
                }
            }

            simpanPendidikanTerakhir(){
                const data = Index.FRM_PendidikanTerakhir.serializeObject();
                if(Helper.validate(Index.FRM_PendidikanTerakhir)){
                    Helper.store(data);
                }
            }

            simpanKontak(){
                const data = Index.FRM_Kontak.serializeObject();
                if(Helper.validate(Index.FRM_Kontak)){
                    Helper.store(data);
                }
            }

            editPendidikanTerakhir(){
                Index.MD_PendidikanTerakhir.find('input[name="prodi"]').val("{{ $pegawai->prodi }}");
                Index.MD_PendidikanTerakhir.find('input[name="namasekolah"]').val("{{ $pegawai->namasekolah }}");
                Index.MD_PendidikanTerakhir.find('input[name="tahun_lulus"]').val(flatpickr.formatDate(new Date("{{ $pegawai->tahun_lulus }}"), "Y"));
                Angga.setValueSelect2AjaxRemote(Index.S2_Pendidikan,{id:"{{ $pegawai->kodependidikan }}" , text : "{{ $pegawai->pendidikan }}"});
                Index.MD_PendidikanTerakhir.modal('show');
            }

            editKeluarga(){
                Index.MD_EditKeluarga.modal('show');
            }

            editInformasiPribadi(){
                Index.MD_EditInformasiPribadi.find('input[name="nopeg"]').val("{{ $pegawai->nopeg }}");
                Index.MD_EditInformasiPribadi.find('input[name="nokk"]').val("{{ $pegawai->nokk }}");
                Index.MD_EditInformasiPribadi.find('input[name="nama"]').val("{{ $pegawai->nama }}");
                Index.MD_EditInformasiPribadi.find('input[name="tempatlahir"]').val("{{ $pegawai->tempatlahir }}");
                Index.MD_EditInformasiPribadi.find('input[name="tgl_lahir"]').val(flatpickr.formatDate(new Date("{{ $pegawai->tgl_lahir }}"), "j F Y"));
                Index.FRM_EditInformasiPribadi.find('input[value="{{ $pegawai->jns_kel }}"][name="jns_kel"]').prop('checked',true);
                Angga.setValueSelect2AjaxRemote(Index.S2_StatusNikah,{id:"{{ $pegawai->idstatusnikah }}" , text : "{{ $pegawai->status_nikah }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_GolDarah,{id:"{{ $pegawai->gol_darah }}" , text : "{{ $pegawai->gol_darah }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Agama,{id:"{{ $pegawai->idagama }}" , text : "{{ $pegawai->agama }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Kewarganegaraan,{id:"{{ $pegawai->kewarganegaraan }}" , text : "{{ $pegawai->kewarganegaraan }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Negara,{id:"{{ $pegawai->idwarganegara }}" , text : "{{ $pegawai->negara }}"});
                Index.MD_EditInformasiPribadi.modal('show');
            }

            editKontak(){
                Index.MD_EditKontak.find('input[name="noidentitas"]').val("{{ $pegawai->noidentitas }}");
                Index.MD_EditKontak.find('textarea[name="alamat"]').val("{{ $pegawai->alamat }}");
                Index.MD_EditKontak.find('input[name="email"]').val("{{ $pegawai->email }}");
                Index.MD_EditKontak.find('input[name="nohp"]').val("{{ $pegawai->nohp }}");
                Index.MD_EditKontak.find('input[name="telp"]').val("{{ $pegawai->telp }}");
                Index.MD_EditKontak.find('input[name="notelpdarurat"]').val("{{ $pegawai->notelpdarurat }}");
                Angga.setValueSelect2AjaxRemote(Index.S2_TipeKartuIdentitas,{id:"{{ $pegawai->idkartuidentitas }}" , text : "{{ $pegawai->kartu_identitas }}"});
                Index.MD_EditKontak.modal('show');
            }

            editKepegawaian(){
                Index.MD_EditKepegawaian.find('input[name="tgl_masuk"]').val(flatpickr.formatDate(new Date("{{ $pegawai->tgl_masuk }}"), "j F Y"));
                Angga.setValueSelect2AjaxRemote(Index.S2_Pegawai,{id:"{{ $pegawai->idstatuspegawai }}" , text : "{{ $pegawai->status_pegawai }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Fungsional,{id:"{{ $pegawai->kodejabfung }}" , text : "{{ $pegawai->jabatan_fungsional }}"});
                Angga.setValueSelect2AjaxRemote(Index.S2_Struktural,{id:"{{ $pegawai->kodestruktural }}" , text : "{{ $pegawai->jabatan_struktural }}"});
                Index.MD_EditKepegawaian.modal('show');
            }

            static store(data){
                data = $.extend(data,{nopeg_lama : "{{ $pegawai->nopeg }}"});
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
                            method : "PATCH",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data,
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
                    Index.FRM_Kepegawaian.find('input[name="organisasi"]').val(selected.node.original.text).prev().val(selected.node.original.id);
                    Index.OFFCNVS_Main.hide();
                    Index.MD_EditKepegawaian.modal('show');
                    Angga.setValueSelect2AjaxRemote(Index.S2_Fungsional,{text : '', id:''});
                    Angga.setValueSelect2AjaxRemote(Index.S2_Struktural,{text : '', id:''});
                }
            }
        }

        export default class Index extends Helper{
            // deklarasi variabel
            static BTN_EditInformasiPribadi;
            static BTN_EditKontak;
            static BTN_EditPendidikanTerakhir;
            static BTN_EditKepegawaian;
            static BTN_SimpanInformasiPribadi;
            static BTN_SimpanKontak;
            static BTN_SimpanPendidikanTerakhir;
            static BTN_SimpanPendidikanTerakhir;
            static BTN_SimpanKepegawaian;
            static BTN_EditKeluarga;
            static BTN_SimpanKeluarga;
            static MD_EditInformasiPribadi;
            static MD_EditKontak;
            static MD_PendidikanTerakhir;
            static MD_EditKepegawaian;
            static MD_EditKeluarga;
            static FRM_EditInformasiPribadi;
            static FRM_Kontak;
            static FRM_PendidikanTerakhir;
            static FRM_Kepegawaian;
            static FRM_EditKeluarga;
            static S2_StatusNikah;
            static S2_GolDarah;
            static S2_Agama;
            static S2_Kewarganegaraan;
            static S2_Negara;
            static S2_TipeKartuIdentitas;
            static S2_Pendidikan;
            static S2_Pegawai;
            static S2_Fungsional;
            static S2_Struktural;
            static BTN_SearchOrg;
            static JSTREE_Main;
            static DATA_Menu;
            static BTN_SimpanUploadKaryawan;
            static BTN_DeleteKeluarga;

            constructor() {
                super();
                Index.DATA_Menu = [];
                Index.BTN_DeleteKeluarga = $('.delete-keluarga');
                Index.BTN_EditInformasiPribadi = $('#edit-informasi-pribadi').css('cursor','pointer');
                Index.BTN_EditKeluarga = $('#edit-keluarga').css('cursor','pointer');
                Index.BTN_EditKontak = $('#edit-kontak').css('cursor','pointer');
                Index.BTN_EditPendidikanTerakhir = $('#edit-pendidikanterakhir').css('cursor','pointer');
                Index.BTN_EditKepegawaian = $("#edit-kepegawaian").css('cursor','pointer');
                Index.BTN_SimpanInformasiPribadi = $('#simpan-informasi-pribadi');
                Index.BTN_SimpanKontak = $('#simpan-kontak');
                Index.BTN_SimpanPendidikanTerakhir = $('#simpan-pendidikanterakhir');
                Index.BTN_SimpanKepegawaian = $('#simpan-kepegawaian');
                Index.BTN_SimpanKeluarga = $('#simpan-keluarga');
                Index.MD_EditInformasiPribadi = $('#modal-edit-informasi-pribadi');
                Index.MD_EditKeluarga = $('#modal-edit-keluarga');
                Index.MD_EditKontak = $('#modal-edit-kontak');
                Index.MD_PendidikanTerakhir = $('#modal-edit-pendidikanterakhir');
                Index.MD_EditKepegawaian = $('#modal-edit-kepegawaian');
                Index.FRM_EditInformasiPribadi = Index.MD_EditInformasiPribadi.find('#form-edit-informasi-pribadi');
                Index.FRM_Kontak = $('#form-edit-kontak');
                Index.FRM_Kepegawaian = $('#form-edit-kepegawaian');
                Index.FRM_PendidikanTerakhir = $('#form-edit-pendidikanterakhir');
                Index.FRM_EditKeluarga = $('#form-edit-keluarga');
                Index.BTN_SimpanUploadKaryawan = $('#simpan-image-karyawan');

                Index.INPUT_image = $('input[type="file"]');
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

                Index.S2_StatusNikah = Index.FRM_EditInformasiPribadi.find('select[name="idstatusnikah"]').select2({
                    placeholder : 'Pilih status pernikahan',
                    theme : 'bootstrap-5'
                });
                Index.S2_GolDarah = Index.FRM_EditInformasiPribadi.find('select[name="gol_darah"]').select2({
                    placeholder : 'Pilih golongan darah',
                    theme : 'bootstrap-5'
                });
                Index.S2_Agama = Index.FRM_EditInformasiPribadi.find('select[name="agama"]').select2({
                    placeholder : 'Pilih agama',
                    theme : 'bootstrap-5'
                });
                Index.S2_Kewarganegaraan = Index.FRM_EditInformasiPribadi.find('select[name="kewarganegaraan"]').select2({
                    placeholder : 'Pilih kewarganegaraan',
                    theme : 'bootstrap-5'
                });
                Index.S2_Negara = Index.FRM_EditInformasiPribadi.find('select[name="idwarganegara"]').select2({
                    placeholder : 'Pilih negara',
                    theme : 'bootstrap-5'
                });
                Index.S2_TipeKartuIdentitas = Index.FRM_Kontak.find('select[name="idkartuidentitas"]').select2({
                    placeholder : 'Pilih tipe kartu identitas',
                    theme : 'bootstrap-5'
                });
                Index.S2_Pendidikan = Index.FRM_PendidikanTerakhir.find('select[name="kodependidikan"]').select2({
                    placeholder : 'Pilih pendidikan',
                    theme : 'bootstrap-5'
                });
                Index.S2_Pegawai = Index.FRM_Kepegawaian.find('select[name="idstatuspegawai"]').select2({
                    placeholder : 'Pilih status pegawai',
                    theme : 'bootstrap-5'
                });
                Index.S2_Fungsional = Index.FRM_Kepegawaian.find('select[name="kodejabfung"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.fungsional.data') }}','Pilih jabatan fungsional'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_Kepegawaian.find('input[name="organisasi"]').prev().val();
                                    const $request = $.ajax(params);
                                    $request.then(success);
                                    $request.fail(failure);
                                    return $request;
                                }
                            }
                        }
                    )
                );

                Index.S2_Struktural = Index.FRM_Kepegawaian.find('select[name="kodestruktural"]').select2(
                    $.extend(
                        true,
                        Angga.generalAjaxSelect2('{{ route('select2.jabatan.struktural.data') }}','Pilih jabatan struktural'),
                        {
                            ajax : {
                                transport: function (params, success, failure) {
                                    params.data['organisasi'] = Index.FRM_Kepegawaian.find('input[name="organisasi"]').prev().val();
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
                Index.BTN_EditKeluarga.on('click', this.editKeluarga);
                Index.BTN_EditInformasiPribadi.on('click', this.editInformasiPribadi);
                Index.BTN_EditKontak.on('click', this.editKontak);
                Index.BTN_SimpanInformasiPribadi.on('click', this.simpanInformasiPribadi);
                Index.BTN_EditPendidikanTerakhir.on('click', this.editPendidikanTerakhir);
                Index.BTN_SimpanKontak.on('click', this.simpanKontak);
                Index.BTN_SimpanPendidikanTerakhir.on('click', this.simpanPendidikanTerakhir);
                Index.BTN_EditKepegawaian.on('click', this.editKepegawaian);
                Index.JSTREE_Main.element.on('select_node.jstree', this.selectedOrg);
                Index.BTN_SearchOrg.on('click', this.showCanvas);
                Index.BTN_SimpanKepegawaian.on('click', this.simpanKepegawaian);
                Index.INPUT_image.on('change', this.change);
                Index.BTN_SimpanUploadKaryawan.on('click', this.simpanUploadKaryawan);
                Index.BTN_SimpanKeluarga.on('click', this.simpanKeluarga);
                Index.BTN_DeleteKeluarga.on('click', this.deleteKeluarga).css('cursor','pointer');
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

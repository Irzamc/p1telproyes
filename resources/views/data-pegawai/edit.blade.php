<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Data Anda</h1>
        <form action="{{ route('data-pegawai.update', ['nik' => $dataPegawai->nik]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $dataPegawai->nama_lengkap) }}" required>
            </div>

            @foreach (['nik_tg', 'nama_posisi', 'klasifikasi_posisi', 'lokasi_kerja', 'unit_kerja', 'psa', 'level_eksis', 'tempat_lahir', 'agama', 'sex', 'gol_darah', 'pendidikan_terakhir', 'aktif_or_pensiun', 'nomor_ktp', 'alamat', 'rt_rw', 'des_kel', 'kec', 'kab_kot', 'prov', 'kode_pos', 'no_hp', 'email_telpro', 'other_email', 'status_karyawan', 'no_sk_kartap', 'kode_divisi', 'nama_divisi', 'nama_kelompok_usia', 'kode_kelompok_usia', 'nama_employee_group', 'kota_kerja_now', 'unit_kerja_now', 'no_kontrak', 'formasi_jabatan', 'status_nikah', 'tang_kel', 'no_kk', 'nama_suami_or_istri', 'nomor_hp_pasangan', 'nama_ayah_kandung', 'nama_ibu_kandung', 'no_bpjs_kes', 'no_bpjs_ket', 'no_telkomedika', 'npwp', 'nama_bank', 'no_rekening', 'nama_rekening'] as $field)
                <div class="mb-3">
                    <label for="{{ $field }}" class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $dataPegawai->{$field}) }}">
                </div>
            @endforeach

            @foreach (['tanggal_level', 'tanggal_lahir', 'tanggal_mulai_kerja', 'tanggal_kartap', 'tanggal_promut', 'tgl_posisi', 'mli_kontrak', 'end_kontrak', 'tanggal_nikah', 'tgl_lahir_anak_1', 'tgl_lahir_anak_2', 'tgl_lahir_anak_3'] as $dateField)
                <div class="mb-3">
                    <label for="{{ $dateField }}" class="form-label">{{ ucwords(str_replace('_', ' ', $dateField)) }}</label>
                    <input type="date" class="form-control" id="{{ $dateField }}" name="{{ $dateField }}" value="{{ old($dateField, $dataPegawai->{$dateField}) }}">
                </div>
            @endforeach

            @foreach (['nama_anak_1', 'nama_anak_2', 'nama_anak_3'] as $anakField)
                <div class="mb-3">
                    <label for="{{ $anakField }}" class="form-label">{{ ucwords(str_replace('_', ' ', $anakField)) }}</label>
                    <input type="text" class="form-control" id="{{ $anakField }}" name="{{ $anakField }}" value="{{ old($anakField, $dataPegawai->{$anakField}) }}">
                </div>
            @endforeach

            @foreach (['lamp_ktp', 'lamp_sk_kartap', 'lamp_sk_promut', 'lamp_kontrak', 'lamp_buku_nikah', 'lamp_kk', 'lamp_ktp_pasangan', 'lamp_akta_1', 'lamp_akta_2', 'lamp_akta_3', 'lamp_bpjs_kes', 'lamp_bpjs_tk', 'lamp_kartu_npwp', 'lamp_buku_rekening', 'avatar_karyawan'] as $fileField)
                <div class="mb-3">
                    <label for="{{ $fileField }}" class="form-label">{{ ucwords(str_replace('_', ' ', $fileField)) }}</label>
                    <input type="file" class="form-control" id="{{ $fileField }}" name="{{ $fileField }}">
                </div>
            @endforeach


            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('beranda') }}" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>
</body>
</html>
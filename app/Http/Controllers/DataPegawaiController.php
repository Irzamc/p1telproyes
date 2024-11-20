<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPegawai;
use Illuminate\Support\Facades\Auth;

class DataPegawaiController extends Controller
{
    // Menampilkan data pegawai
    public function index()
    {
        $user = Auth::user();

        // Jika role admin, tampilkan semua data pegawai
        if ($user->role === 'admin') {
            $dataPegawais = DataPegawai::all();
        } else {
            // Jika role user, tampilkan hanya data miliknya
            $dataPegawais = DataPegawai::where('nik', $user->nik)->get();
        }

        return view('data-pegawai.index', compact('dataPegawais'));
    }

    // Menampilkan form edit data pegawai
    public function edit($nik)
    {
        $user = Auth::user();
        $dataPegawai = DataPegawai::where('nik', $nik)->first();

        // Pastikan hanya admin atau pemilik data yang bisa mengakses
        if ($user->role !== 'admin' && $dataPegawai->nik !== $user->nik) {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        return view('data-pegawai.edit', compact('dataPegawai'));
    }

    // Update data pegawai
    public function update(Request $request, $nik)
    {
        $user = Auth::user();
        $dataPegawai = DataPegawai::where('nik', $nik)->first();

        // Pastikan hanya admin atau pemilik data yang bisa mengakses
        if ($user->role !== 'admin' && $dataPegawai->nik !== $user->nik) {
            return redirect()->route('data-pegawai.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        $request->validate([    
            'nik_tg' => 'nullable|string|max:20',
            'nama_posisi' => 'nullable|string|max:255',
            'klasifikasi_posisi' => 'nullable|string|max:255',
            'lokasi_kerja' => 'nullable|string|max:255',
            'unit_kerja' => 'nullable|string|max:255',
            'psa' => 'nullable|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'level_eksis' => 'nullable|string|max:255',
            'tanggal_level' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'sex' => 'nullable|string|max:10',
            'gol_darah' => 'nullable|string|max:5',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'aktif_or_pensiun' => 'nullable|string|max:255',
            'nomor_ktp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'rt_rw' => 'nullable|string|max:50',
            'des_kel' => 'nullable|string|max:255',
            'kec' => 'nullable|string|max:255',
            'kab_kot' => 'nullable|string|max:255',
            'prov' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:15',
            'email_telpro' => 'nullable|email|max:255',
            'other_email' => 'nullable|email|max:255',
            'tanggal_mulai_kerja' => 'nullable|date',
            'status_karyawan' => 'nullable|string|max:255',
            'no_sk_kartap' => 'nullable|string|max:50',
            'tanggal_kartap' => 'nullable|date',
            'no_sk_promut' => 'nullable|string|max:50',
            'tanggal_promut' => 'nullable|date',
            'kode_divisi' => 'nullable|string|max:50',
            'nama_divisi' => 'nullable|string|max:255',
            'tgl_posisi' => 'nullable|date',
            'nama_kelompok_usia' => 'nullable|string|max:255',
            'kode_kelompok_usia' => 'nullable|string|max:50',
            'nama_employee_group' => 'nullable|string|max:255',
            'kota_kerja_now' => 'nullable|string|max:255',
            'unit_kerja_now' => 'nullable|string|max:255',
            'no_kontrak' => 'nullable|string|max:50',
            'mli_kontrak' => 'nullable|date',
            'end_kontrak' => 'nullable|date',
            'formasi_jabatan' => 'nullable|string|max:255',
            'status_nikah' => 'nullable|string|max:255',
            'tanggal_nikah' => 'nullable|date',
            'tang_kel' => 'nullable|string|max:255',
            'no_kk' => 'nullable|string|max:20',
            'nama_suami_or_istri' => 'nullable|string|max:255',
            'nomor_hp_pasangan' => 'nullable|string|max:15',
            'nama_anak_1' => 'nullable|string|max:255',
            'tgl_lahir_anak_1' => 'nullable|date',
            'nama_anak_2' => 'nullable|string|max:255',
            'tgl_lahir_anak_2' => 'nullable|date',
            'nama_anak_3' => 'nullable|string|max:255',
            'tgl_lahir_anak_3' => 'nullable|date',
            'nama_ayah_kandung' => 'nullable|string|max:255',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'no_bpjs_kes' => 'nullable|string|max:20',
            'no_bpjs_ket' => 'nullable|string|max:20',
            'no_telkomedika' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:20',
            'nama_bank' => 'nullable|string|max:255',
            'no_rekening' => 'nullable|string|max:50',
            'nama_rekening' => 'nullable|string|max:255',
            'lamp_ktp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_sk_kartap' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_sk_promut' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_kontrak' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_buku_nikah' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_kk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_ktp_pasangan' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_akta_1' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_akta_2' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_akta_3' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_bpjs_kes' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_bpjs_tk' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_kartu_npwp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'lamp_buku_rekening' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'avatar_karyawan' => 'nullable|image|max:2048',
        ]); 

        // Update data pegawai
        $dataPegawai->update([
            'nik' => $request->nik,
            'nik_tg' => $request->nik_tg,
            'nama_posisi' => $request->nama_posisi,
            'klasifikasi_posisi' => $request->klasifikasi_posisi,
            'lokasi_kerja' => $request->lokasi_kerja,
            'unit_kerja' => $request->unit_kerja,
            'psa' => $request->psa,
            'nama_lengkap' => $request->nama_lengkap,
            'level_eksis' => $request->level_eksis,
            'tanggal_level' => $request->tanggal_level,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'sex' => $request->sex,
            'gol_darah' => $request->gol_darah,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'aktif_or_pensiun' => $request->aktif_or_pensiun,
            'nomor_ktp' => $request->nomor_ktp,
            'alamat' => $request->alamat,
            'rt_rw' => $request->rt_rw,
            'des_kel' => $request->des_kel,
            'kec' => $request->kec,
            'kab_kot' => $request->kab_kot,
            'prov' => $request->prov,
            'kode_pos' => $request->kode_pos,
            'no_hp' => $request->no_hp,
            'email_telpro' => $request->email_telpro,
            'other_email' => $request->other_email,
            'tanggal_mulai_kerja' => $request->tanggal_mulai_kerja,
            'status_karyawan' => $request->status_karyawan,
            'no_sk_kartap' => $request->no_sk_kartap,
            'tanggal_kartap' => $request->tanggal_kartap,
            'no_sk_promut' => $request->no_sk_promut,
            'tanggal_promut' => $request->tanggal_promut,
            'kode_divisi' => $request->kode_divisi,
            'nama_divisi' => $request->nama_divisi,
            'tgl_posisi' => $request->tgl_posisi,
            'nama_kelompok_usia' => $request->nama_kelompok_usia,
            'kode_kelompok_usia' => $request->kode_kelompok_usia,
            'nama_employee_group' => $request->nama_employee_group,
            'kota_kerja_now' => $request->kota_kerja_now,
            'unit_kerja_now' => $request->unit_kerja_now,
            'no_kontrak' => $request->no_kontrak,
            'mli_kontrak' => $request->mli_kontrak,
            'end_kontrak' => $request->end_kontrak,
            'formasi_jabatan' => $request->formasi_jabatan,
            'status_nikah' => $request->status_nikah,
            'tanggal_nikah' => $request->tanggal_nikah,
            'tang_kel' => $request->tang_kel,
            'no_kk' => $request->no_kk,
            'nama_suami_or_istri' => $request->nama_suami_or_istri,
            'nomor_hp_pasangan' => $request->nomor_hp_pasangan,
            'nama_anak_1' => $request->nama_anak_1,
            'tgl_lahir_anak_1' => $request->tgl_lahir_anak_1,
            'nama_anak_2' => $request->nama_anak_2,
            'tgl_lahir_anak_2' => $request->tgl_lahir_anak_2,
            'nama_anak_3' => $request->nama_anak_3,
            'tgl_lahir_anak_3' => $request->tgl_lahir_anak_3,
            'nama_ayah_kandung' => $request->nama_ayah_kandung,
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'no_bpjs_kes' => $request->no_bpjs_kes,
            'no_bpjs_ket' => $request->no_bpjs_ket,
            'no_telkomedika' => $request->no_telkomedika,
            'npwp' => $request->npwp,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'lamp_ktp' => $request->lamp_ktp,
            'lamp_sk_kartap' => $request->lamp_sk_kartap,
            'lamp_sk_promut' => $request->lamp_sk_promut,
            'lamp_kontrak' => $request->lamp_kontrak,
            'lamp_buku_nikah' => $request->lamp_buku_nikah,
            'lamp_kk' => $request->lamp_kk,
            'lamp_ktp_pasangan' => $request->lamp_ktp_pasangan,
            'lamp_akta_1' => $request->lamp_akta_1,
            'lamp_akta_2' => $request->lamp_akta_2,
            'lamp_akta_3' => $request->lamp_akta_3,
            'lamp_bpjs_kes' => $request->lamp_bpjs_kes,
            'lamp_bpjs_tk' => $request->lamp_bpjs_tk,
            'lamp_kartu_npwp' => $request->lamp_kartu_npwp,
            'lamp_buku_rekening' => $request->lamp_buku_rekening,
            'avatar_karyawan' => $request->avatar_karyawan,
        ]);

        if ($request->hasFile('lamp_ktp')) {
            $dataPegawai->lamp_ktp = $request->file('lamp_ktp')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_sk_kartap')) {
            $dataPegawai->lamp_sk_kartap = $request->file('lamp_sk_kartap')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_sk_promut')) {
            $dataPegawai->lamp_sk_promut = $request->file('lamp_sk_promut')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_kontrak')) {
            $dataPegawai->lamp_kontrak = $request->file('lamp_kontrak')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_buku_nikah')) {
            $dataPegawai->lamp_buku_nikah = $request->file('lamp_buku_nikah')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_kk')) {
            $dataPegawai->lamp_kk = $request->file('lamp_kk')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_ktp_pasangan')) {
            $dataPegawai->lamp_ktp_pasangan = $request->file('lamp_ktp_pasangan')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_akta_1')) {
            $dataPegawai->lamp_akta_1 = $request->file('lamp_akta_1')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_akta_2')) {
            $dataPegawai->lamp_akta_2 = $request->file('lamp_akta_2')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_akta_3')) {
            $dataPegawai->lamp_akta_3 = $request->file('lamp_akta_3')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_bpjs_kes')) {
            $dataPegawai->lamp_bpjs_kes = $request->file('lamp_bpjs_kes')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_bpjs_tk')) {
            $dataPegawai->lamp_bpjs_tk = $request->file('lamp_bpjs_tk')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_kartu_npwp')) {
            $dataPegawai->lamp_kartu_npwp = $request->file('lamp_kartu_npwp')->store('lampiran');
        }
        
        if ($request->hasFile('lamp_buku_rekening')) {
            $dataPegawai->lamp_buku_rekening = $request->file('lamp_buku_rekening')->store('lampiran');
        }

        $dataPegawai->save();

        return redirect()->route('data-pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }
}

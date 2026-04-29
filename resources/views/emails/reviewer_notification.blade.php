<div style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #2c3e50;">Permintaan Peninjauan Dokumen</h2>
    <p>Halo <strong>{{ $reviewer->nama_user }}</strong>,</p>
    
    <p>Anda telah ditunjuk sebagai Reviewer untuk dokumen baru di sistem DCMS. Berikut adalah detailnya:</p>
    
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; font-weight: bold;">Nomor Draft</td>
            <td>: {{ $dokumen->dr_no }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Judul Dokumen</td>
            <td>: {{ $dokumen->judul_dokumen }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tanggal Pengajuan</td>
            <td>: {{ date('d F Y') }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">Mohon segera melakukan peninjauan melalui tautan berikut:</p>
    <a href="{{ route('dokumenReview.show', $dokumen->id) }}" 
       style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: #fff; text-decoration: none; border-radius: 5px;">
       Lihat Dokumen
    </a>

    <p style="font-size: 0.8em; color: #7f8c8d; margin-top: 30px;">
        Ini adalah pesan otomatis dari Sistem DCMS PT. Tata Metal Lestari. Mohon tidak membalas email ini.
    </p>
</div>
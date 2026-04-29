@extends('layouts.main')

@section('content')
<section class="section">
  
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
         
            <h4 class="mb-0 text-primary">MASTERLIST NOMER DOKUMEN REVIEW</h4>
            <a href="{{ route('dokumenReview.index') }}" class="btn btn-secondary d-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card-body p-0">
            @php
              use Illuminate\Support\Str;

              $items = collect($dokumen->items() ?? []);

              // Kumpulkan opsi jenis dari nama_jenis ATAU nomor_dokumen (ambil prefix sebelum titik)
              $jenisOptions = $items
                  ->map(function($d){
                      $src = $d->nama_jenis ?? $d->nomor_dokumen ?? '';
                      return strtoupper(trim(strtok($src, '.')));
                  })
                  ->filter()
                  ->unique()
                  ->sort()
                  ->values();
                
              $jenis = strtoupper(request('jenis','')); 
            @endphp

            <div class="p-3 pb-1">
              <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                  <label class="form-label mb-1">Jenis Dokumen</label>
                  <select name="jenis" class="form-select form-select-sm">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisOptions as $j)
                      <option value="{{ $j }}" @selected($jenis===$j)>{{ $j }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                  <button class="btn btn-primary btn-sm">Terapkan</button>
                  <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
              </form>
            </div>
            <br>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0" id="masterListDRTable"> 
                    <thead class="table-success text-nowrap"> 
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th> 
                            <th class="text-center">No DR</th>
                            <th>No Dokumen yang diajukan</th> 
                            <th>No Revisi</th> 
                            <th>Status Penerbitan</th> 
                            <th>Tanggal Terbit</th>
                            <th style="min-width: 250px;">Nama Dokumen</th>
                            <th>Keterangan</th> 
                            <th style="min-width: 150px;">Divisi</th>
                            <th>Pembuat Dokumen</th> 
                            <th>File Dokumen Final</th> 
                            <th>Pengaju No DR</th>
                            <th>Reviewer</th> 
                            <th style="min-width: 150px;">Alasan Revisi</th> 
                            <th class="text-center">File Draft DR</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @php
                          $jenis = strtoupper(request('jenis',''));
                          $items = collect($dokumen->items() ?? []); 
                                          
                          $rows = $items->filter(function($d) use ($jenis) {
                            $src = $d->nama_jenis ?? $d->nomor_dokumen ?? '';
                            $j   = strtoupper(trim(strtok($src, '.')));
                            return $jenis === '' || $j === $jenis;
                          })->values();
                        @endphp
                        @forelse ($dokumen as $i => $d)
                        <tr>
                            <td class="text-center">{{ $dokumen->firstItem() + $i }}</td> 
                            <td class="font-weight-bold text-nowrap">{{ $d->dr_no }}</td> 
                            <td class="text-center">{{  $d->nomor_dokumen ?? '-'  }}
                            <td class="text-center">{{  $d->no_revisi ?? '-'  }}
                            <td>
                                 @if($d->status_review == 'terbit')

                                     <span class="badge bg-success">TERBIT</span>
                                 @elseif($d->status_review== 'review')

                                     <span class="badge bg-warning text-dark">REVIEW</span>
                                 @else

                                     <span class="badge bg-secondary">FM.IM.01.00</span>
                                 @endif
                             </td>
                                
                                <td>{{ optional($d->tanggal_terbit)?->format('d M Y') ?? '-' }}</td>
                                <td>{{ Str::limit($d->nama_dokumen, 40) }}</td> 
                                <td>{{ Str::limit($d->keterangan, 30) ?? '-' }}</td>
                                <td>{{ optional($d->divisi)->nama_divisi ?? '-' }}</td> 
                                <td>{{ optional($d->pembuat2)->nama_user ?? '-' }}</td> 
                                 <td>
                                      @php
                                        $finalFile = optional($d->files)->first(function($f){
                                            return strcasecmp(trim($f->type), 'final') === 0; 
                                        });
                                      @endphp

                                      @if($finalFile)
                                        <a href="{{ route('dokumenFile.stream', $finalFile->id) }}" target="_blank">
                                          {{ $finalFile->original_name ?? basename($finalFile->path) }}
                                        </a>
                                      @else
                                        -
                                      @endif
                                </td>
                                <td>{{ optional($d->pembuat)->nama_user ?? '-' }}</td> 
                                <td class="text-center">
                                  @php $rids = collect($d->reviewer_ids ?? [])->filter(); @endphp
                                                                
                                  @if($rids->isNotEmpty())
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rev{{ $d->id }}">
                                      {{ $rids->count() }} Reviewer
                                    </button>
                                
                                    {{-- Modal daftar reviewer --}}
                                    <div class="modal fade" id="rev{{ $d->id }}" tabindex="-1" aria-hidden="true">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h6 class="modal-title">Reviewer</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                          </div>
                                          <div class="modal-body p-0">
                                            <ul class="list-group list-group-flush">
                                              @foreach($rids as $rid)
                                                <li class="list-group-item">
                                                  {{ $userMap[$rid] ?? ('User#'.$rid) }}
                                                </li>
                                              @endforeach
                                            </ul>
                                          </div>
                                          <div class="modal-footer">
                                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  @else
                                    -
                                  @endif
                                </td>

                                <td>{{ Str::limit($d->alasan_revisi, 30) ?? '-' }}</td>
                                
                                <td class="text-center text-nowrap">
                                    @if ($d->status_review == 'terbit')
                                        <a href="{{ route('dokumenReview.draftDetail', $d) }}" class="btn btn-sm btn-info" title="Lihat Dokumen Final">
                                            <i class="fas fa-file-pdf"></i> Draf DR
                                        </a>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted py-4">
                                <i class="fas fa-box-open me-2"></i> Tidak ada data untuk jenis ini.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer clearfix">
            {{ $dokumen->links('pagination::bootstrap-5') }} 
        </div>
    </div>
</section>
@endsection
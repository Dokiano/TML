@extends('layouts.main')

@section('content')
<section class="section">
 @php
  $divisiName = $divisi->nama_divisi;
  $forcedCkr = [
        'SALES DAN MARKETING','ACCOUNTING','PROCUREMENT','PPIC DAN DELIVERY','EKSPOR DAN IMPOR','TREASURY','INVOICING','MANUFACTURING','LAB','ENGINEERING','BUSSINESS ANALYST','IT'
    ];
  $lokasi = null;
   if (Str::contains($divisiName, ' CKR')) {
        $lokasi = 'ckr';
    } elseif (Str::contains($divisiName, ' SDG')) {
        $lokasi = 'sdg';
    } elseif (Str::contains($divisiName, $forcedCkr)) {
        $lokasi = 'ckr'; 
    }
@endphp

  @php
    $uniqueJenisDokumen = collect($dokumens ?? [])
      ->pluck('nama_jenis') 
      ->unique() 
      ->sort() 
      ->values();
  @endphp
 <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">
        Dokumen Divisi: <span class="fw-bold">{{ strtoupper($divisi->nama_divisi) }}</span>
    </h5>

    <div class="d-flex gap-2">
        <a href="{{ route('dok.dashboard') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        @if ($lokasi ?? false)
            <a href="{{ route('dok.draft.master.divisi', ['lokasi' => $lokasi, 'id' => $divisi->id]) }}"
               class="btn btn-sm btn-warning">
                <i class="fas fa-file me-1"></i> Draft
            </a>
        @endif
    </div>
</div>


  <div class="card mb-3">
    <div class="card-header border-bottom-0 pt-3 pb-2 d-flex gap-2">
      <a href="{{ route('dokumen.pengajuan') }}" class="btn btn-success d-inline-flex align-items-center shadow-sm"
         style="font-size: .875rem; padding: .375rem .75rem;">
        <i class="fas fa-plus me-2" style="font-size: 1rem;"></i> Buat Dokumen
      </a>
      <div class="flex-grow-1" style="max-width: 300px;">
        <select id="jenisDokumenFilter" class="form-select form-select-sm shadow-sm">
          <option value="ALL">Semua Jenis Dokumen</option>
          @foreach($uniqueJenisDokumen as $jenis)
            <option value="{{ strtolower($jenis) }}">{{ $jenis }}</option>
          @endforeach
        </select>
      </div>  
    </div>
  </div>

  @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'manager']))
  <div class="document-section-container" data-prefix="msp">
    {{-- MSP Section --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
      <h5 class="fw-bold mb-0">MSP</h5>
    </div>
    <div class="card mb-4 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
          <table class="table table-hover mb-0" style="min-width: 1200px;">
            <thead class="table-light">
              <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th style="min-width: 150px;">No Dokumen</th>
                <th style="min-width: 80px;">Revisi</th>
                <th style="min-width: 250px;">Nama Dokumen</th>
                <th style="min-width: 150px;">Keterangan</th>
                <th style="min-width: 150px;">File</th>
                <th style="min-width: 120px;">Tanggal Terbit</th>
                <th class="text-center" style="min-width: 150px;">Aksi</th>
              </tr>
            </thead>
            <tbody id="mspTbody">
              @php
                $mspExceptions = ['QP.QA'];

                $list = collect($dokumens ?? [])->filter(function($d) use ($mspExceptions){
                  $prefix = strtoupper(Str::before($d->nama_jenis ?? '', '.'));
                  
                  $isException = collect($mspExceptions)->contains(function($exc) use ($d) {
                    return str_starts_with($d->nama_jenis ?? '', $exc);
                  });
                
                  return $prefix === 'MSP' || $isException;
                })->sortBy('nomor_dokumen')->values();
              @endphp
              @forelse ($list as $i => $d)
                <tr class="document-row" data-jenis="{{ strtolower($d->nama_jenis ?? '') }}" data-parent-jenis="{{ strtolower(Str::before($d->nama_jenis ?? '', '.')) }}">
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $d->nomor_dokumen ?? '-' }}</td>
                  <td>{{ $d->no_revisi ?? '-' }}</td>
                  <td>{{ $d->nama_dokumen ?? '-' }}</td>
                  <td>{{ $d->keterangan ?? '-' }}</td>
                  <td>
                    @if(!empty($d->file_final_dr))
                      <a href="{{ route('dokumenReview.streamFileFinal', $d->id) }}" target="_blank" class="text-decoration-none">
                        <i class="fas fa-file-pdf text-danger me-1"></i>
                        {{ Str::limit(basename($d->file_final_dr), 20) }}
                      </a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>{{ optional($d->tanggal_terbit)?->format('d M Y') ?? '-' }}</td>
                  <td class="text-center">
                    <a href="{{ route('dokumen.pengajuan.revisi', $d->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-edit"></i> 
                    </a>
                      <form action="{{ route('dokumenReview.destroy', $d->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Hapus dokumen ini beserta semua data terkait? Tindakan ini tidak bisa dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                          <i class="fas fa-trash-alt"></i> 
                        </button>
                      </form>
                  </td>
                </tr>
              @empty
                <tr class="default-empty-row">
                  <td colspan="9" class="text-center text-muted py-4">Belum ada dokumen untuk jenis ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  <div class="document-section-container" data-prefix="gl">
    {{-- GL Section --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
      <h5 class="fw-bold mb-0">GL</h5>
    </div>
    <div class="card mb-4 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
          <table class="table table-hover mb-0" style="min-width: 1200px;">
            <thead class="table-light">
              <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th style="min-width: 150px;">No Dokumen</th>
                <th style="min-width: 80px;">Revisi</th>
                <th style="min-width: 250px;">Nama Dokumen</th>
                <th style="min-width: 150px;">Keterangan</th>
                <th style="min-width: 150px;">File</th>
                <th style="min-width: 120px;">Tanggal Terbit</th>
                <th class="text-center" style="min-width: 150px;">Aksi</th>
              </tr>
            </thead>
            <tbody id="glTbody">
              @php
                $list = collect($dokumens ?? [])->filter(function($d){
                  $prefix = strtoupper(Str::before($d->nama_jenis ?? '', '')); 
                  return $prefix === 'GL';
                })->sortBy('nomor_dokumen')->values();
              @endphp
              @forelse ($list as $i => $d)
                <tr class="document-row" data-jenis="{{ strtolower($d->nama_jenis ?? '') }}" data-parent-jenis="{{ strtolower(Str::before($d->nama_jenis ?? '', '.')) }}">
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $d->nomor_dokumen ?? '-' }}</td>
                  <td>{{ $d->no_revisi ?? '-' }}</td>
                  <td>{{ $d->nama_dokumen ?? '-' }}</td>
                  <td>{{ $d->keterangan ?? '-' }}</td>
                  <td>
                    @if(!empty($d->file_final_dr))
                      <a href="{{ route('dokumenReview.streamFileFinal', $d->id) }}" target="_blank" class="text-decoration-none">
                        <i class="fas fa-file-pdf text-danger me-1"></i>
                        {{ Str::limit(basename($d->file_final_dr), 20) }}
                      </a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>{{ optional($d->tanggal_terbit)?->format('d M Y') ?? '-' }}</td>
                  <td class="text-center">
                    <a href="{{ route('dokumen.edit', $d->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="default-empty-row">
                  <td colspan="9" class="text-center text-muted py-4">Belum ada dokumen untuk jenis ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>  
  @endif

  <div class="document-section-container" data-prefix="ik">
    {{-- IK Section --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
      <h5 class="fw-bold mb-0">IK</h5>
    </div>
    <div class="card mb-4 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
          <table class="table table-hover mb-0" style="min-width: 1200px;">
            <thead class="table-light">
              <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th style="min-width: 150px;">No Dokumen</th>
                <th style="min-width: 80px;">Revisi</th>
                <th style="min-width: 250px;">Nama Dokumen</th>
                <th style="min-width: 150px;">Keterangan</th>
                <th style="min-width: 150px;">File</th>
                <th style="min-width: 120px;">Tanggal Terbit</th>
                <th class="text-center" style="min-width: 150px;">Aksi</th>
              </tr>
            </thead>
            <tbody class="ikTbody">
              @php
                $list = collect($dokumens ?? [])->filter(function($d){
                  $prefix = strtoupper(Str::before($d->nama_jenis ?? '', '.'));
                  return $prefix === 'IK';
                })->sortBy('nomor_dokumen')->values();
              @endphp
              @forelse ($list as $i => $d)
                <tr class="document-row" data-jenis="{{ strtolower($d->nama_jenis ?? '') }}" data-parent-jenis="{{ strtolower(Str::before($d->nama_jenis ?? '', '.')) }}">
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $d->nomor_dokumen ?? '-' }}</td>
                  <td>{{ $d->no_revisi ?? '-' }}</td>
                  <td>{{ $d->nama_dokumen ?? '-' }}</td>
                  <td>{{ $d->keterangan ?? '-' }}</td>
                  <td>
                    @if(!empty($d->file_final_dr))
                      <a href="{{ route('dokumenReview.streamFileFinal', $d->id) }}" target="_blank" class="text-decoration-none">
                        <i class="fas fa-file-pdf text-danger me-1"></i>
                        {{ Str::limit(basename($d->file_final_dr), 20) }}
                      </a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>{{ optional($d->tanggal_terbit)?->format('d M Y') ?? '-' }}</td>
                  <td class="text-center">
                    <a href="{{ route('dokumen.edit', $d->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="default-empty-row">
                  <td colspan="9" class="text-center text-muted py-4">Belum ada dokumen untuk jenis ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="document-section-container" data-prefix="fm">
    {{-- FM Section --}}
    <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
      <h5 class="fw-bold mb-0">FM</h5>
    </div>
    <div class="card mb-4 shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
          <table class="table table-hover mb-0" style="min-width: 1200px;">
            <thead class="table-light">
              <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th style="min-width: 150px;">No Dokumen</th>
                <th style="min-width: 80px;">Revisi</th>
                <th style="min-width: 250px;">Nama Dokumen</th>
                <th style="min-width: 150px;">Keterangan</th>
                <th style="min-width: 150px;">File</th>
                <th style="min-width: 120px;">Tanggal Terbit</th>
                <th class="text-center" style="min-width: 150px;">Aksi</th>
              </tr>
            </thead>
            <tbody class="fmTbody">
              @php
                $list = collect($dokumens ?? [])->filter(function($d){
                  $prefix = strtoupper(Str::before($d->nama_jenis ?? '', '.')); 
                  return $prefix === 'FM';
                })->sortBy('nomor_dokumen')->values();
              @endphp
              @forelse ($list as $i => $d)
                <tr class="document-row" data-jenis="{{ strtolower($d->nama_jenis ?? '') }}" data-parent-jenis="{{ strtolower(Str::before($d->nama_jenis ?? '', '.')) }}">
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $d->nomor_dokumen ?? '-' }}</td>
                  <td>{{ $d->no_revisi ?? '-' }}</td>
                  <td>{{ $d->nama_dokumen ?? '-' }}</td>
                  <td>{{ $d->keterangan ?? '-' }}</td>
                  <td>
                    @if(!empty($d->file_final_dr))
                      <a href="{{ route('dokumenReview.streamFileFinal', $d->id) }}" target="_blank" class="text-decoration-none">
                        <i class="fas fa-file-pdf text-danger me-1"></i>
                        {{ Str::limit(basename($d->file_final_dr), 20) }}
                      </a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>{{ optional($d->tanggal_terbit)?->format('d M Y') ?? '-' }}</td>
                  <td class="text-center">
                    <a href="{{ route('dokumen.edit', $d->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                  </td>
                </tr>
              @empty
                <tr class="default-empty-row">
                  <td colspan="9" class="text-center text-muted py-4">Belum ada dokumen untuk jenis ini.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>  
</section>
@push('scripts')
<script>
  document.querySelectorAll('.btn-hapus-tampilan').forEach(button => {
    button.addEventListener('click', function() {
      const dokumenId = this.getAttribute('data-id');
      const row = this.closest('tr');
      const tbody = row.closest('tbody');
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    const filterDropdown = document.getElementById('jenisDokumenFilter');
    const allDocumentRows = document.querySelectorAll('.document-row');
    const allSections = document.querySelectorAll('.document-section-container');
    const tableBodies = document.querySelectorAll('tbody');

    function applyJenisDokumenFilter() {
      const selectedJenis = filterDropdown.value;
      const selectedPrefix = (selectedJenis !== 'ALL') ? selectedJenis.split('.')[0] : 'ALL'; 
      const visibleRowsCount = {}; 
      
      tableBodies.forEach(tbody => {
        if(tbody.id) {
            visibleRowsCount[tbody.id] = 0;
        }
      });
      allDocumentRows.forEach(row => {
        const rowJenis = row.getAttribute('data-jenis');
        let parentTbody = row.closest('tbody'); 
        let parentTbodyId = parentTbody ? parentTbody.id : null;
        
        const isVisible = (selectedJenis === 'ALL' || selectedJenis === rowJenis);
        
        row.style.display = isVisible ? '' : 'none';

        if (isVisible && parentTbodyId) {
          visibleRowsCount[parentTbodyId]++;
        }
      });
      
      allSections.forEach(section => {
          const sectionPrefix = section.getAttribute('data-prefix');
          const isSectionVisible = (selectedPrefix === 'ALL' || selectedPrefix === sectionPrefix);
          section.style.display = isSectionVisible ? '' : 'none';
      });

      tableBodies.forEach(tbody => {
        if (!tbody.id) return; 

        const defaultEmptyRow = tbody.querySelector('.default-empty-row');
        let tempNoResults = tbody.querySelector('.temp-no-results');

        if (defaultEmptyRow) {
            defaultEmptyRow.style.display = 'none';
        }
        
        if (visibleRowsCount[tbody.id] === 0) {
            if (tbody.closest('.document-section-container').style.display === '') {
                if (!tempNoResults) {
                    tempNoResults = document.createElement('tr');
                    tempNoResults.classList.add('temp-no-results');
                    tempNoResults.innerHTML = '<td colspan="9" class="text-center text-muted py-4">Tidak ada dokumen yang cocok dengan filter ini.</td>';
                    tbody.appendChild(tempNoResults);
                }
                tempNoResults.style.display = ''; 
            }
        } else {
            if (tempNoResults) {
                tempNoResults.remove();
            }
        }
        
        if (selectedJenis === 'ALL' && defaultEmptyRow) {
            if (visibleRowsCount[tbody.id] === 0) {
                 defaultEmptyRow.style.display = '';
            }
            if (tempNoResults) {
                tempNoResults.remove();
            }
        }
      });
    }

    filterDropdown.addEventListener('change', applyJenisDokumenFilter);
    applyJenisDokumenFilter(); 
  });
</script>
@endpush
@endsection
@extends('layouts.main')

@section('content')
<h5 class="mb-3">{{ $d->nomor_dokumen }} {{ $d->nama_dokumen }}</h5>

<div class="row g-3">
  <div class="col-lg-8">
    {{-- Kontainer PDF --}}
    <div id="pdf-wrap" class="mb-2" style="border:1px solid #ddd;border-radius:8px;background:#fff;">
      <div id="pdf-root" style="position:relative;width:100%;height:auto;">
        <canvas id="pdf-canvas" style="display:block;"></canvas>
        <div id="anno-layer" style="position:absolute;left:0;top:0;pointer-events:none;"></div>
      </div>
    </div>

    {{-- Toolbar --}}
    <div class="d-flex flex-wrap gap-2 mt-2">
      <button class="btn btn-sm btn-outline-primary" data-tool="point">📍 Pin</button>
      <button class="btn btn-sm btn-outline-secondary" id="prev">‹ Prev</button>
      <button class="btn btn-sm btn-outline-secondary" id="next">Next ›</button>
      <button class="btn btn-sm btn-outline-secondary" id="zoomIn">Zoom +</button>
      <button class="btn btn-sm btn-outline-secondary" id="zoomOut">Zoom −</button>
      <button class="btn btn-sm btn-outline-secondary" id="zoomReset">100%</button>
      <button class="btn btn-sm btn-outline-secondary" id="zoomFit">Fit Lebar</button>
      <span class="ms-2 align-self-center text-muted small" id="pageLabel"></span>
      <span class="ms-1 align-self-center text-muted small" id="zoomNow"></span>
    </div>
  </div>

  <div class="col-lg-4">
    {{-- PANEL KOMENTAR --}}
    <div class="card h-100">
      <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <span>Komentar Halaman <strong id="pageNow"></strong></span>
      </div>
      <div class="card-body p-0" style="overflow-y:auto;max-height:520px;">
        <ul id="comment-list" class="list-group list-group-flush small"></ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="d-flex justify-content-between">
      <a href="{{ route('dokumenReview.draftDetail', $d) }}" class="btn btn-warning btn-sm">
        Tanda Tangan Review
      </a>
      <a href="{{ route('dokumenReview.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
  </div>
</div>

{{-- ===== MODAL ANOTASI PIN ===== --}}
<div class="modal fade" id="modalPin" tabindex="-1" aria-labelledby="modalPinLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title" id="modalPinLabel">📍 Tambah Komentar Pin</h6>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        {{-- Komentar teks --}}
        <div class="mb-3">
          <label class="form-label fw-semibold small">Komentar <span class="text-muted fw-normal">(wajib)</span></label>
          <textarea id="pinComment" class="form-control form-control-sm" rows="3"
                    placeholder="Tuliskan komentar atau deskripsi letak kesalahan..."></textarea>
        </div>

        {{-- Upload gambar --}}
        <div class="mb-2">
          <label class="form-label fw-semibold small">
            Lampiran Gambar
            <span class="text-muted fw-normal">(opsional, maks. 5 gambar, masing-masing ≤ 4 MB)</span>
          </label>
          <input type="file" id="pinImages" class="form-control form-control-sm"
                 accept="image/jpeg,image/png,image/webp" multiple>
        </div>

        {{-- Preview gambar sebelum upload --}}
        <div id="pinImagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>

      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-sm btn-primary" id="btnSimpanPin">
          <span id="btnSimpanPinSpinner" class="spinner-border spinner-border-sm d-none me-1"></span>
          Simpan
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ===== MODAL DETAIL KOMENTAR (edit komentar + gambar) ===== --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
 
      <div class="modal-header py-2">
        <h6 class="modal-title">Detail Komentar</h6>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
      </div>
 
      <div class="modal-body">
 
        {{-- Info author --}}
        <p class="fw-semibold mb-2 small text-muted" id="detailAuthor"></p>
 
        {{-- ── MODE LIHAT ── --}}
        <div id="detailViewMode">
          <p class="mb-3" id="detailText"></p>
        </div>
 
        {{-- ── MODE EDIT ── (hidden default) --}}
        <div id="detailEditMode" class="d-none">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Komentar</label>
            <textarea id="editComment" class="form-control form-control-sm" rows="4"
                      placeholder="Tulis komentar..."></textarea>
          </div>
 
          {{-- Tambah gambar baru --}}
          <div class="mb-2">
            <label class="form-label fw-semibold small">
              Tambah Gambar
              <span class="text-muted fw-normal">(opsional, maks. 5, masing-masing ≤ 4 MB)</span>
            </label>
            <input type="file" id="editNewImages" class="form-control form-control-sm"
                   accept="image/jpeg,image/png,image/webp" multiple>
          </div>
          <div id="editNewImagePreview" class="d-flex flex-wrap gap-2 mt-1 mb-3"></div>
        </div>
 
        {{-- ── GAMBAR TERLAMPIR ── --}}
        <div id="detailImages" class="d-flex flex-wrap gap-2"></div>
 
      </div>
 
      <div class="modal-footer py-2 d-flex justify-content-between">
 
        {{-- Tombol Edit / Batal Edit (kiri) --}}
        <div>
          {{-- Tombol Edit — hanya muncul jika user boleh edit --}}
          <button type="button" class="btn btn-sm btn-outline-warning d-none" id="btnStartEdit">
            <i class="bx bx-edit me-1"></i> Edit
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="btnCancelEdit">
            Batal
          </button>
        </div>
 
        {{-- Tombol Simpan / Tutup (kanan) --}}
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-sm btn-primary d-none" id="btnSimpanEdit">
            <span id="spinnerEdit" class="spinner-border spinner-border-sm d-none me-1"></span>
            Simpan
          </button>
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
 
      </div>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<style>
  #anno-layer { box-sizing:border-box; }
  #anno-layer .ann { position:absolute; box-sizing:border-box; }
  .ann-point {
    width:18px; height:18px; background:#dc3545; border:2px solid #fff;
    border-radius:50%; box-shadow:0 0 0 2px rgba(220,53,69,.4);
    transform:translate(-50%,-50%); cursor:pointer; pointer-events:auto;
    transition: box-shadow .15s;
  }
  .ann-point:hover { box-shadow:0 0 0 5px rgba(220,53,69,.3); }
  .ann-point.has-image::after {
    content:'🖼';font-size:9px;position:absolute;
    top:-8px;right:-8px;background:#fff;border-radius:50%;
    width:14px;height:14px;display:flex;align-items:center;justify-content:center;
    box-shadow:0 0 0 1px #dc3545;
  }
  .comment-img-thumb {
    width:80px; height:60px; object-fit:cover;
    border-radius:6px; border:1px solid #dee2e6;
    cursor:pointer; transition:opacity .15s;
  }
  .comment-img-thumb:hover { opacity:.8; }
  [data-tool].active { box-shadow: inset 0 0 0 2px #0d6efd; }
</style>

<!-- PDF.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
  window.pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ===== Konstanta dari Laravel =====
  const PDF_URL         = @json(route('dokumenReview.pdf', $d->id));
  const CSRF            = '{{ csrf_token() }}';
  const CURRENT_USER_ID = @json(auth()->id());
  const IS_ADMIN        = @json((auth()->user()->role ?? '') === 'admin');
  const DR_ID           = @json($d->id);
  const ANNO_INDEX_URL  = @json(route('annotations.index', $d->id));
  const ANNO_STORE_URL  = @json(route('annotations.store', $d->id));
  const ANNO_BASE_URL   = '{{ url("/dokumen-review/{$d->id}/annotations") }}';

  // ===== Elemen DOM =====
  const canvas      = document.getElementById('pdf-canvas');
  const ctx         = canvas.getContext('2d');
  const annoLayer   = document.getElementById('anno-layer');
  const pageLabel   = document.getElementById('pageLabel');
  const zoomNow     = document.getElementById('zoomNow');
  const pageNow     = document.getElementById('pageNow');
  const commentList = document.getElementById('comment-list');

  // Modal Pin
  const modalPinEl      = document.getElementById('modalPin');
  const modalPin        = new bootstrap.Modal(modalPinEl);
  modalPinEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
      btn.addEventListener('click', function() {
          modalPin.hide();
      });
  });
  const pinComment      = document.getElementById('pinComment');
  const pinImages       = document.getElementById('pinImages');
  const pinImagePreview = document.getElementById('pinImagePreview');
  const btnSimpanPin    = document.getElementById('btnSimpanPin');
  const spinnerPin      = document.getElementById('btnSimpanPinSpinner');

  // Modal Detail
  const modalDetailEl = document.getElementById('modalDetail');
  const modalDetail   = new bootstrap.Modal(modalDetailEl);
  modalDetailEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
      btn.addEventListener('click', function() {
          modalDetail.hide();
      });
  });
    
  // ===== State =====
  let pdfDoc=null, pageNum=1, scale=1.0, fitToWidth=true, lastViewport=null;
  let pendingPoint = null; // {x, y} koordinat klik saat modal belum tersimpan
  const MIN_SCALE=0.5, MAX_SCALE=4, STEP=0.2;
  
  // ===== Util =====
  function clamp(v,a,b){ return Math.max(a,Math.min(b,v)); }
  function updateZoomLabel(){ if(zoomNow) zoomNow.textContent = Math.round(scale*100)+'%'; }
  function escapeHtml(s){ return (s||'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
  function setLoading(on){ spinnerPin.classList.toggle('d-none',!on); btnSimpanPin.disabled=on; }

  // ===== Preview gambar sebelum upload =====
  pinImages.addEventListener('change', ()=>{
    pinImagePreview.innerHTML = '';
    const files = Array.from(pinImages.files).slice(0, 5);
    files.forEach(f=>{
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'comment-img-thumb';
        img.title = f.name;
        pinImagePreview.appendChild(img);
      };
      reader.readAsDataURL(f);
    });
  });

  // Reset modal saat ditutup
  modalPinEl.addEventListener('hidden.bs.modal', ()=>{
    pinComment.value    = '';
    pinImages.value     = '';
    pinImagePreview.innerHTML = '';
    pendingPoint        = null;
  });

  // ===== Simpan Pin (teks + gambar) =====
  btnSimpanPin.addEventListener('click', async ()=>{
    const comment = pinComment.value.trim();
    if (!comment){ pinComment.focus(); return; }
    if (!pendingPoint) return;

    setLoading(true);
    try {
      // 1. Simpan anotasi teks dulu → dapat ID
      const base = lastViewport ? { baseW:lastViewport.width, baseH:lastViewport.height } : {};
      const res  = await fetch(ANNO_STORE_URL, {
        method:'POST',
        headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF },
        credentials:'same-origin',
        body: JSON.stringify({
          page: pageNum,
          type: 'point',
          rect: { x:pendingPoint.x, y:pendingPoint.y, width:0, height:0 },
          data: { ...base, comment }
        })
      });
      if (!res.ok) throw new Error('Gagal simpan anotasi');
      const ann = await res.json();

      // 2. Upload gambar jika ada
      const files = Array.from(pinImages.files).slice(0,5);
      if (files.length > 0){
        const fd = new FormData();
        files.forEach(f => fd.append('images[]', f));
        const imgRes = await fetch(`${ANNO_BASE_URL}/${ann.id}/images`, {
          method:'POST',
          headers:{ 'X-CSRF-TOKEN': CSRF },
          credentials:'same-origin',
          body: fd
        });
        if (!imgRes.ok) console.warn('Gambar gagal diupload, anotasi tetap tersimpan');
      }

      modalPin.hide();
      renderPage(pageNum);

    } catch(e){
      console.error(e);
      alert('Gagal menyimpan komentar. Silakan coba lagi.');
    } finally {
      setLoading(false);
    }
  });

  // ===== Render overlay anotasi di atas canvas =====
  async function renderOverlay(viewport){
    if (!annoLayer) return;
    annoLayer.style.width  = canvas.style.width;
    annoLayer.style.height = canvas.style.height;
    annoLayer.innerHTML    = '';

    const res  = await fetch(ANNO_INDEX_URL, { credentials:'same-origin' });
    const all  = await res.json();
    const items = all.filter(a => a.page === pageNum);

    items.forEach(a=>{
      const baseW = a?.data?.baseW || viewport.width;
      const baseH = a?.data?.baseH || viewport.height;
      const sx = viewport.width/baseW, sy = viewport.height/baseH;

      if (a.type === 'point'){
        const el = document.createElement('div');
        el.className  = 'ann ann-point';
        el.style.left = (a.rect.x * sx) + 'px';
        el.style.top  = (a.rect.y * sy) + 'px';
        el.dataset.annId = String(a.id);

        // tandai jika punya gambar
        if (a.images && a.images.length > 0) el.classList.add('has-image');

        // klik pin → buka detail
        el.addEventListener('click', ()=> openDetail(a));
        annoLayer.appendChild(el);
      }
    });

    renderCommentList(items);
    if (pageNow) pageNow.textContent = String(pageNum);
  }

  // ===== Panel komentar kanan =====
  function renderCommentList(items){
    commentList.innerHTML = '';

    // tampilkan semua pin, termasuk yang tanpa teks
    items.filter(a => a.type === 'point').forEach(a=>{
      const author  = a?.data?.author_name || ('User #' + a.user_id);
      const comment = a?.data?.comment || '(tanpa komentar)';
      const imgCount = a.images ? a.images.length : 0;

      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
          <div class="me-2 flex-grow-1">
            <div class="fw-semibold text-danger small">📍 ${escapeHtml(author)}</div>
            <div class="mt-1">${escapeHtml(comment)}</div>
            ${imgCount > 0 ? `<div class="mt-1 text-muted small">🖼 ${imgCount} gambar terlampir</div>` : ''}
          </div>
          <div class="d-flex flex-column gap-1 ms-1">
            <button class="btn btn-link btn-sm p-0" data-act="focus" data-id="${a.id}">Lihat</button>
            <button class="btn btn-link btn-sm p-0 text-primary" data-act="detail" data-id="${a.id}">Detail</button>
            ${(IS_ADMIN || a.user_id === CURRENT_USER_ID)
              ? `<button class="btn btn-link btn-sm p-0 text-danger" data-act="del" data-id="${a.id}">Hapus</button>`
              : ''}
          </div>
        </div>`;
      commentList.appendChild(li);
    });

    // binding tombol
    commentList.querySelectorAll('[data-act="focus"]').forEach(b=>{
      b.addEventListener('click', ()=> focusAnnotation(b.dataset.id));
    });
    commentList.querySelectorAll('[data-act="detail"]').forEach(b=>{
      b.addEventListener('click', ()=>{
        const ann = currentItems.find(a => String(a.id) === b.dataset.id);
        if (ann) openDetail(ann);
      });
    });
    commentList.querySelectorAll('[data-act="del"]').forEach(b=>{
      b.addEventListener('click', ()=> deleteAnnotation(b.dataset.id));
    });
  }

  // simpan items di scope luar agar bisa diakses tombol detail
  let currentItems = [];
  const _origRenderCommentList = renderCommentList;

  

let detailCurrentAnn  = null;   // anotasi yang sedang dibuka
let detailCurrentImgs = [];     // gambar yang sudah ada di server
let detailImgsToDelete = [];    // id gambar yang akan dihapus
 
// Elemen modal detail (tambahkan setelah deklarasi modalDetail yang sudah ada)
const btnStartEdit  = document.getElementById('btnStartEdit');
const btnCancelEdit = document.getElementById('btnCancelEdit');
const btnSimpanEdit = document.getElementById('btnSimpanEdit');
const spinnerEdit   = document.getElementById('spinnerEdit');
const editComment   = document.getElementById('editComment');
const editNewImages = document.getElementById('editNewImages');
const editNewImagePreview = document.getElementById('editNewImagePreview');
  async function openDetail(ann) {
    detailCurrentAnn   = ann;
    detailImgsToDelete = [];

    // Reset ke mode lihat
    setEditMode(false);

    // Isi author & teks
    document.getElementById('detailAuthor').textContent =
      (ann?.data?.author_name || 'User #' + ann.user_id) + ' — Hal. ' + ann.page;
    document.getElementById('detailText').textContent =
      ann?.data?.comment || '(tanpa komentar)';
    editComment.value = ann?.data?.comment || '';

    // Tampilkan tombol Edit hanya jika user boleh (pembuat atau admin)
    const bolehEdit = IS_ADMIN || ann.user_id === CURRENT_USER_ID;
    btnStartEdit.classList.toggle('d-none', !bolehEdit);

    // Reset gambar
    const detailImages = document.getElementById('detailImages');
    detailImages.innerHTML = '<span class="text-muted small">Memuat gambar...</span>';
    editNewImages.value = '';
    editNewImagePreview.innerHTML = '';

    modalDetail.show();

    // Fetch gambar dari server
    try {
      const res  = await fetch(`${ANNO_BASE_URL}/${ann.id}/images`, { credentials: 'same-origin' });
      detailCurrentImgs = await res.json();
      renderDetailImages(detailCurrentImgs, false); // false = mode lihat
    } catch (e) {
      detailImages.innerHTML = '<span class="text-danger small">Gagal memuat gambar.</span>';
    }
  }

  // ===== Render gambar di modal detail =====
  function renderDetailImages(imgs, editMode) {
    const container = document.getElementById('detailImages');
    container.innerHTML = '';

    if (imgs.length === 0) {
      container.innerHTML = '<span class="text-muted small">Tidak ada gambar terlampir.</span>';
      return;
    }

    imgs.forEach(img => {
      const wrapper = document.createElement('div');
      wrapper.style.cssText = 'position:relative; display:inline-block;';

      const el = document.createElement('img');
      el.src       = img.url;
      el.className = 'comment-img-thumb';
      el.title     = img.original_name || '';
      el.style.cssText = 'width:120px; height:90px;';
      el.addEventListener('click', () => window.open(img.url, '_blank'));

      wrapper.appendChild(el);

      // Tombol hapus gambar — hanya tampil di mode edit
      if (editMode) {
        const del = document.createElement('button');
        del.type      = 'button';
        del.innerHTML = '&times;';
        del.title     = 'Hapus gambar ini';
        del.style.cssText =
          'position:absolute; top:-6px; right:-6px; width:20px; height:20px; ' +
          'border-radius:50%; border:none; background:#dc3545; color:#fff; ' +
          'font-size:12px; line-height:1; cursor:pointer; display:flex; ' +
          'align-items:center; justify-content:center; padding:0;';

        del.addEventListener('click', (e) => {
          e.stopPropagation();
          // Tandai untuk dihapus, sembunyikan dari tampilan
          detailImgsToDelete.push(img.id);
          wrapper.remove();
        });

        wrapper.appendChild(del);
      }

      container.appendChild(wrapper);
    });
  }

  // ===== Toggle mode edit/lihat =====
  function setEditMode(on) {
    document.getElementById('detailViewMode').classList.toggle('d-none', on);
    document.getElementById('detailEditMode').classList.toggle('d-none', !on);
    btnStartEdit.classList.toggle('d-none',  on);
    btnCancelEdit.classList.toggle('d-none', !on);
    btnSimpanEdit.classList.toggle('d-none', !on);

    // Re-render gambar dengan/tanpa tombol hapus
    renderDetailImages(
      detailCurrentImgs.filter(img => !detailImgsToDelete.includes(img.id)),
      on
    );

    if (!on) {
      // Reset ke kondisi awal saat batal edit
      detailImgsToDelete = [];
      editNewImages.value = '';
      editNewImagePreview.innerHTML = '';
      renderDetailImages(detailCurrentImgs, false);
    }
  }

  // ===== Tombol Edit diklik =====
  btnStartEdit.addEventListener('click', () => setEditMode(true));

  // ===== Tombol Batal diklik =====
  btnCancelEdit.addEventListener('click', () => setEditMode(false));

  // ===== Preview gambar baru sebelum upload =====
  editNewImages.addEventListener('change', () => {
    editNewImagePreview.innerHTML = '';
    Array.from(editNewImages.files).slice(0, 5).forEach(f => {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement('img');
        img.src       = e.target.result;
        img.className = 'comment-img-thumb';
        img.title     = f.name;
        img.style.cssText = 'width:80px; height:60px;';
        editNewImagePreview.appendChild(img);
      };
      reader.readAsDataURL(f);
    });
  });

  // ===== Tombol Simpan diklik =====
  btnSimpanEdit.addEventListener('click', async () => {
    if (!detailCurrentAnn) return;

    const newComment = editComment.value.trim();
    if (!newComment) { editComment.focus(); return; }

    // Disable tombol
    btnSimpanEdit.disabled = true;
    spinnerEdit.classList.remove('d-none');

    try {
      // 1. Update teks komentar via PATCH
      const updateRes = await fetch(`${ANNO_BASE_URL}/${detailCurrentAnn.id}`, {
        method : 'PUT',
        headers: {
          'Content-Type' : 'application/json',
          'X-CSRF-TOKEN' : CSRF,
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          data: {
            ...detailCurrentAnn.data,
            comment: newComment,
          }
        })
      });
      if (!updateRes.ok) throw new Error('Gagal update komentar');
      const updated = await updateRes.json();

      // Update data lokal
      detailCurrentAnn.data = updated.data;
      document.getElementById('detailText').textContent = newComment;

      // 2. Hapus gambar yang ditandai
      await Promise.all(detailImgsToDelete.map(imgId =>
        fetch(`${ANNO_BASE_URL}/${detailCurrentAnn.id}/images/${imgId}`, {
          method : 'DELETE',
          headers: { 'X-CSRF-TOKEN': CSRF },
          credentials: 'same-origin',
        })
      ));

      // 3. Upload gambar baru jika ada
      const newFiles = Array.from(editNewImages.files).slice(0, 5);
      if (newFiles.length > 0) {
        const fd = new FormData();
        newFiles.forEach(f => fd.append('images[]', f));
        const imgRes = await fetch(`${ANNO_BASE_URL}/${detailCurrentAnn.id}/images`, {
          method : 'POST',
          headers: { 'X-CSRF-TOKEN': CSRF },
          credentials: 'same-origin',
          body: fd,
        });
        if (!imgRes.ok) console.warn('Beberapa gambar gagal diupload');
      }

      // 4. Refresh daftar gambar terbaru dari server
      const refreshRes = await fetch(`${ANNO_BASE_URL}/${detailCurrentAnn.id}/images`, { credentials: 'same-origin' });
      detailCurrentImgs  = await refreshRes.json();
      detailImgsToDelete = [];

      // Kembali ke mode lihat dengan data terbaru
      setEditMode(false);

      // Refresh panel komentar di halaman
      renderPage(pageNum);

    } catch (err) {
      console.error(err);
      alert('Gagal menyimpan perubahan. Silakan coba lagi.');
    } finally {
      btnSimpanEdit.disabled = false;
      spinnerEdit.classList.add('d-none');
    }
  });

  // Reset state saat modal ditutup
  modalDetailEl.addEventListener('hidden.bs.modal', () => {
    detailCurrentAnn   = null;
    detailCurrentImgs  = [];
    detailImgsToDelete = [];
    setEditMode(false);
  });


  function focusAnnotation(id){
    const el = document.querySelector(`#anno-layer [data-ann-id="${id}"]`);
    if (!el) return;
    el.scrollIntoView({ behavior:'smooth', block:'center' });
    el.animate(
      [{ boxShadow:'0 0 0 0 rgba(220,53,69,0)' },{ boxShadow:'0 0 0 10px rgba(220,53,69,.5)' }],
      { duration:600, iterations:2, direction:'alternate' }
    );
  }

  async function deleteAnnotation(id){
    if (!confirm('Hapus anotasi dan seluruh gambar lampirannya?')) return;
    const r = await fetch(`${ANNO_BASE_URL}/${id}`, {
      method:'DELETE',
      headers:{ 'X-CSRF-TOKEN': CSRF },
      credentials:'same-origin'
    });
    if (r.ok) renderPage(pageNum); else alert('Gagal menghapus anotasi');
  }

  // ===== Render halaman PDF =====
  function renderPage(num){
    pdfDoc.getPage(num).then(page=>{
      if (fitToWidth){
        const container = document.getElementById('pdf-wrap');
        const unscaled  = page.getViewport({ scale:1 });
        scale = (container.clientWidth - 2) / unscaled.width;
      }
      const viewport = page.getViewport({ scale });
      lastViewport   = viewport;

      const dpr = window.devicePixelRatio || 1;
      canvas.width  = Math.floor(viewport.width  * dpr);
      canvas.height = Math.floor(viewport.height * dpr);
      canvas.style.width  = Math.floor(viewport.width)  + 'px';
      canvas.style.height = Math.floor(viewport.height) + 'px';
      ctx.setTransform(dpr,0,0,dpr,0,0);

      return page.render({ canvasContext:ctx, viewport }).promise;
    }).then(async ()=>{
      pageLabel.textContent = `Hal ${pageNum} / ${pdfDoc.numPages}`;
      updateZoomLabel();

      // fetch annotations + images sekaligus untuk panel komentar
      const res  = await fetch(ANNO_INDEX_URL, { credentials:'same-origin' });
      const all  = await res.json();
      currentItems = all.filter(a => a.page === pageNum);

      // ambil jumlah gambar tiap anotasi agar panel bisa tampilkan badge
      await Promise.all(currentItems.map(async a=>{
        try {
          const r2 = await fetch(`${ANNO_BASE_URL}/${a.id}/images`, { credentials:'same-origin' });
          a.images = await r2.json();
        } catch { a.images = []; }
      }));

      await renderOverlay(lastViewport);
    }).catch(err=>console.error('Gagal render page:', err));
  }

  // Resize re-render
  let resizeTimer=null;
  window.addEventListener('resize', ()=>{
    if (!fitToWidth || !pdfDoc) return;
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(()=>renderPage(pageNum), 150);
  });

  // ===== Tool aktif =====
  let currentTool = null;
  document.querySelectorAll('[data-tool]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      currentTool = btn.dataset.tool;
      document.querySelectorAll('[data-tool]').forEach(x=>x.classList.remove('active'));
      btn.classList.add('active');
    });
  });

  function canvasXY(evt){
    const r = canvas.getBoundingClientRect();
    return { x: evt.clientX - r.left, y: evt.clientY - r.top };
  }

  // ===== Klik canvas → buka modal Pin =====
  canvas.addEventListener('click', (evt)=>{
    if (currentTool !== 'point') return;
    const p = canvasXY(evt);
    pendingPoint = p;
    pinComment.value = '';
    pinImages.value  = '';
    pinImagePreview.innerHTML = '';
    modalPin.show();
    // fokus textarea setelah modal tampil
    modalPinEl.addEventListener('shown.bs.modal', ()=> pinComment.focus(), { once:true });
  });

  // ===== Navigasi & Zoom =====
  document.getElementById('prev').onclick = ()=>{ if(pageNum>1){ pageNum--; renderPage(pageNum); } };
  document.getElementById('next').onclick = ()=>{ if(pdfDoc && pageNum<pdfDoc.numPages){ pageNum++; renderPage(pageNum); } };

  function setScale(s){ fitToWidth=false; scale=clamp(s,MIN_SCALE,MAX_SCALE); renderPage(pageNum); updateZoomLabel(); }
  document.getElementById('zoomIn').onclick    = ()=> setScale(scale+STEP);
  document.getElementById('zoomOut').onclick   = ()=> setScale(scale-STEP);
  document.getElementById('zoomReset').onclick = ()=> setScale(1.0);
  document.getElementById('zoomFit').onclick   = ()=>{ fitToWidth=true; renderPage(pageNum); };
  updateZoomLabel();

  // ===== Load PDF =====
  pdfjsLib.getDocument(PDF_URL).promise
    .then(pdf=>{ pdfDoc=pdf; renderPage(pageNum); })
    .catch(err=>console.error('Gagal load PDF:', err));
});
</script>
@endpush
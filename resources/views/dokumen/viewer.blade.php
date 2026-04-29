@extends('layouts.main')

@section('content')
<h5 class="mb-3">Preview (read-only): {{ $file->original_name }}</h5>

<div id="wrap" style="border:1px solid #ddd;border-radius:8px;background:#fff;">
  <div id="root" style="position:relative;">
    <canvas id="pdf-canvas" style="display:block;"></canvas>
  </div>
</div>

<div class="d-flex gap-2 mt-2">
  <button id="prev" class="btn btn-sm btn-outline-secondary">Prev</button>
  <button id="next" class="btn btn-sm btn-outline-secondary">Next</button>

  <button id="zoomIn" class="btn btn-sm btn-outline-secondary">Zoom +</button>
  <button id="zoomOut" class="btn btn-sm btn-outline-secondary">Zoom −</button>
  <button id="zoomReset" class="btn btn-sm btn-outline-secondary">100%</button>
  <button id="zoomFit" class="btn btn-sm btn-outline-secondary">Fit Lebar</button>

  <span class="ms-2" id="pageLabel"></span>
  <span class="ms-2" id="zoomNow"></span>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
  window.pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const PDF_URL = @json(route('dokumenFiles.preview', $file->id));

  const canvas    = document.getElementById('pdf-canvas');
  const ctx       = canvas.getContext('2d');
  const pageLabel = document.getElementById('pageLabel');
  const zoomNow   = document.getElementById('zoomNow');

  let pdfDoc = null, pageNum = 1, scale = 1, fit = true;

  function updZoom(){ if (zoomNow) zoomNow.textContent = Math.round(scale*100)+'%'; }

  function render(num){
    pdfjsLib.getDocument(PDF_URL).promise.then(pdf=>{
      if (!pdfDoc) pdfDoc = pdf;           // cache pertama
      return pdf.getPage(num);
    }).then(page=>{
      if (fit) {
        const unscaled = page.getViewport({ scale: 1 });
        const targetW  = document.getElementById('root').clientWidth - 4;
        scale = targetW / unscaled.width;
      }
      const viewport = page.getViewport({ scale });
      const dpr      = window.devicePixelRatio || 1;

      canvas.width  = Math.floor(viewport.width  * dpr);
      canvas.height = Math.floor(viewport.height * dpr);
      canvas.style.width  = Math.floor(viewport.width)  + 'px';
      canvas.style.height = Math.floor(viewport.height) + 'px';
      ctx.setTransform(dpr,0,0,dpr,0,0);

      return page.render({ canvasContext: ctx, viewport }).promise.then(()=>{
        pageLabel.textContent = `Hal ${num} / ${pdfDoc.numPages}`;
        updZoom();
      });
    }).catch(e=>console.error('Render gagal:', e));
  }

  // load pertama
  pdfjsLib.getDocument(PDF_URL).promise.then(pdf => { pdfDoc = pdf; render(pageNum); });

  // navigasi
  document.getElementById('prev').onclick = ()=>{ if (pageNum > 1) { pageNum--; render(pageNum); } };
  document.getElementById('next').onclick = ()=>{ if (pdfDoc && pageNum < pdfDoc.numPages) { pageNum++; render(pageNum); } };

  // zoom
  document.getElementById('zoomIn').onclick    = ()=>{ fit=false; scale+=0.2; render(pageNum); };
  document.getElementById('zoomOut').onclick   = ()=>{ fit=false; scale=Math.max(0.4, scale-0.2); render(pageNum); };
  document.getElementById('zoomReset').onclick = ()=>{ fit=false; scale=1; render(pageNum); };
  document.getElementById('zoomFit').onclick   = ()=>{ fit=true; render(pageNum); };

  window.addEventListener('resize', ()=>{ if (fit && pdfDoc) render(pageNum); });
});
</script>
@endpush

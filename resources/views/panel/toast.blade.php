<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-primary text-dark">
      {{-- <img src="..." class="rounded me-2" alt="..."> --}}
      <strong class="me-auto">{{ $title }}</strong>
      <small class=" text-dark"></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ $body}}
    </div>
  </div>
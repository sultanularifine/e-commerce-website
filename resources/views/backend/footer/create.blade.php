@extends('backend.layouts.app')
@section('title', 'Add Footer Item')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Add Footer Item</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="#">Settings</a></div>
        <div class="breadcrumb-item">Add Footer</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card-body card card-primary">
            <form action="{{ route('footer.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="form-group col-md-6">
                  <label><b>Type*</b></label>
                  <select name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="logo">Logo</option>
                    <option value="menu">Menu</option>
                    <option value="newsletter">Newsletter</option>
                    <option value="social">Social</option>
                    <option value="contact">Contact</option>
                    <option value="other">Other</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label><b>Name</b></label>
                  <input type="text" class="form-control" name="name" placeholder="Menu or Link Name">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><b>Value</b></label>
                  <input type="text" class="form-control" name="value" placeholder="URL, email, etc.">
                </div>

                <div class="form-group col-md-3">
                  <label><b>Order</b></label>
                  <input type="number" class="form-control" name="order" value="1">
                </div>

                <div class="form-group col-md-3">
                  <label><b>Status</b></label>
                  <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-6">
                  <label><b>Logo (optional)</b></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="logoFile" name="logo">
                    <label class="custom-file-label" for="logoFile">Choose logo</label>
                  </div>
                  <div class="mt-2">
                    <img id="logoPreview" src="" alt="" width="120" style="display:none;border:1px solid #ddd;padding:3px;border-radius:4px;">
                  </div>
                </div>
              </div>

              <div class="form-group mb-0">
                <label><b>Description (optional)</b></label>
                <textarea class="form-control summernote" name="description" data-height="150"></textarea>
              </div>

              <div class="card-left text-left my-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('footer.index') }}" class="btn btn-secondary">Cancel</a>
              </div>
            </form>

            @if ($errors->any())
            <div class="alert alert-danger mt-3">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/library/summernote/dist/summernote-bs4.min.js') }}"></script>
<script>
document.getElementById('logoFile').addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function(){
        const img = document.getElementById('logoPreview');
        img.src = reader.result;
        img.style.display = 'block';
    }
    reader.readAsDataURL(e.target.files[0]);
});
</script>
@endpush

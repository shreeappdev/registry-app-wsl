<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sub Domain Deactivate</h1>
    </div>

<form class="row needs-validation" method= "post" wire:submit.prevent="deletesubdomain" novalidate>
                       
    <div class="form-group row">
      <label for="inputSubdomain" class="col-sm-2 col-form-label">Subdomain</label>
      <div class="col-sm-10">
         {{-- Subdomain --}}
      </div>
    </div>
    <div class="form-group row">
        <label for="inputCname" class="col-sm-2 col-form-label">CNAME</label>
        <div class="col-sm-10">
         {{-- Subdomain --}}
        </div>
      </div>
      <div class="form-group row">
        <label for="inputIp" class="col-sm-2 col-form-label">IP</label>
        <div class="col-sm-10">
            {{-- IPS --}}
        </div>
    </div>

    <div class="form-group row">
        <label for="uploadFile" class="col-sm-2 col-form-label">Upload File (Max 1MB) </label>
        <div class="col-sm-10">
            <input type="file"  wire:model="file" class="form-control @error('file') is-invalid @enderror" >
            <div class="invalid-feedback">
                @error('file')
                    {{ $message }}
                @enderror
            </div>
       </div>
   </div>
  
    <div class="form-group row">
        <label for="submit" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <button type="button" class="btn btn-success">Submit</button>
        </div>
    </div>
</form>

</div>
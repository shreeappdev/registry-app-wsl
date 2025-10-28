<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Submit letter</h1>
    </div>

<form method= "POST" wire:submit.prevent="uploadletter">
    @csrf              
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
      <div class="col-sm-10">
        <select class="form-control @error('domainid') is-invalid @enderror" wire:model="domainid">
            <option value="">..select..</option>
            @foreach ($this->generatedLtr as $domain)
                <option value={{$domain->domainid }}> {{ $domain->dname_decoded_punycode }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            @error('domainid')
                {{ $message }}
            @enderror
        </div>
      </div>
    </div>
   <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Upload Annexure 1</label>
        <div class="col-sm-10">
            <input type="file"  wire:model="annex1" class="form-control-file @error('annex1') is-invalid @enderror" >
            <div class="invalid-feedback">
                @error('annex1')
                    {{ $message }}
                @enderror
            </div>
       </div>
   </div>
   <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Upload Annexure II</label>
    <div class="col-sm-10">

        <input type="file"  wire:model="annex2" class="form-control-file @error('annex2') is-invalid @enderror">
        <div class="invalid-feedback">
            @error('annex2')
                {{ $message }}
            @enderror
        </div>
    </div>
 </div>
    <div class="form-group row">
        <label for="submit" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>
    </div>
  </form>
</div>
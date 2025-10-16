<div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Get Subdomain Details</h1>
</div>

<form method="POST" wire:submit.prevent="getSubdomain">
    @csrf
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
        <div class="col-sm-10">
            <select class="form-control @error('domainid') is-invalid @enderror" wire:model="domainid" id="domainid" >
                <option value=> Select Domain </option>
                @foreach ($domains as $domain)
                    <option value={{ $domain->domainid }}> {{ $domain->domainname }}</option>
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
        <label for="submit" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
</form>
</div>
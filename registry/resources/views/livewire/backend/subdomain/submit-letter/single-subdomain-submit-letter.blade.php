<div>
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Register Single SubDomain</h1>
    </div> --}}
    <form class="row needs-validation" method= "post" wire:submit.prevent="uploadletter" novalidate>
         @csrf
        <div class="card">
            <div class="card-header bg-primary text-white shadow">
                Submit Letter Single Subdomain
            </div>
           
            <div class="card-body">
                <div class="form-group row g-3">
                    <div class="col-md-6">                        
                        <label for="inputDomain" class="form-label">Select Domain</label>
                        <select id="inputDomain" class="form-control @error('selectedDomainid') is-invalid @enderror " wire:model.live="selectedDomainid">
                            <option value="" selected>Choose...</option>
                            @foreach ($this->activeDomain as $domain)
                            <option value="{{ $domain->domainid }}">{{ $domain->domainname }}</option>
                            @endforeach
                        </select>  
                        <div class="invalid-feedback">
                            @error('selectedDomainid')
                                {{ $message }}
                            @enderror
                        </div>               
                    </div>
                    <div class="col-md-6">
                        <label for="inputSigngAuthrty" class="form-label">Select Subdomain</label>
                        <select id="inputSigngAuthrty" class="form-control @error('selectedSubdomain') is-invalid @enderror" wire:model.live="selectedSubdomain">
                            <option value="" selected>Choose...</option>
                            @if($subdomains)
                            @foreach ($subdomains as $domain)
                            <option value="{{ $domain->subdomainid }}">{{ $domain->subdomainname }}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            @error('selectedSubdomain')
                                {{ $message }}
                            @enderror
                        </div>  
                    </div>                 
                </div>
                <div class="form-group row g-3">                
                    <div class="col-md-6">
                        <label for="inputSigngAuthrty" class="form-label">Upload Letter</label>                     
                        <input type="file" id="inputname" class="form-control @error('letter') is-invalid @enderror" wire:model="letter">
                        <div class="invalid-feedback">
                            @error('letter')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark">Submit letter</button>       
        </div>
    </form>
</div>
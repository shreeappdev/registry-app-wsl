<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h4 class="h3 mb-0 text-gray-800">Register Single SubDomain</h4>
    </div>
    <form class="row needs-validation" method= "post" wire:submit.prevent="register" novalidate>
         @csrf
        <div class="card">
            <div class="card-header bg-primary text-white shadow">
                It allows to register Subdomains (fourth/fifth level) under an active 3rd level domain which is hosted in NIC Data Centre only( abc.xyz.gov.in is a fourth level domain under a 3rd level domain name xyz.gov.in / abc.def.xyz.gov.in is a fifth level domain under a 3rd level domain name xyz.gov.in).
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
                        <label for="inputSigngAuthrty" class="form-label">Select Signing Authority</label>
                        <select id="inputSigngAuthrty" class="form-control @error('selectedSigningAthority') is-invalid @enderror" wire:model.live="selectedSigningAthority">
                            <option value="" selected>Choose...</option>
                            @if(!empty($signingAuthority) && !empty($signingAuthority->orgContactDetails) )
                            <option value="{{ $signingAuthority->orgContactDetails->contactid }}">Organisational - {{ $signingAuthority->orgContactDetails->c_name }}, {{ $signingAuthority->orgContactDetails->designation }}</option>
                            <option value="{{ $signingAuthority->adminContactDetails->contactid }}">Administrative - {{ $signingAuthority->adminContactDetails->c_name }}, {{ $signingAuthority->adminContactDetails->designation }}</option>                            
                            @endif
                        </select>
                        <div class="invalid-feedback">
                            @error('selectedSigningAthority')
                                {{ $message }}
                            @enderror
                        </div>  
                    </div>
                  
                </div>
                <div class="form-group row g-3">                
                    <div class="col-md-6">
                        <label for="inputname" class="form-label">Subdomain Name</label>
                        <input type="text" id="inputname" class="form-control @error('subdomainName') is-invalid @enderror" wire:model="subdomainName" placeholder="Enter only Subdomain name ex- abc, abc.xy">
                         <div class="invalid-feedback">
                            @error('subdomainName')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                         <label for="inputSgnmthd" class="form-label " >Chooose Signing method</label>
                        <select id="inputSgnmthd" class="form-control @error('selectedsSigningMethod') is-invalid @enderror" wire:model.live="selectedsSigningMethod">
                            <option value="" selected>Choose...</option>
                            <option value="esign">Esign</option>
                            <option value="generateletter">Generate Letter for Ink Sign</option>
                            
                        </select>
                         <div class="invalid-feedback">
                            @error('selectedsSigningMethod')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row g-3">
                    <div class="col-md-6">
                        <label for="inputmapping" class="form-label">Mapping</label>
                            <select id="inputmapping" class="form-control @error('selectedMapping') is-invalid @enderror" wire:model.live="selectedMapping">
                                <option value="" selected>Choose...</option>
                                <option value="cname">CNAME</option>
                                <option value="ip">IP</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('selectedMapping')
                                    {{ $message }}
                                @enderror
                            </div>
                    </div>
                    @if($mappingType == 'cname')
                        <div class="col-md-6">
                            <label for="inputcname" class="form-label">CNAME</label>
                            <input type="text" id="inputcname" class="form-control @error('cName') is-invalid @enderror" wire:model="cName" placeholder="Enter enter cname">
                            <div class="invalid-feedback">
                                @error('cName')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>
                @if($mappingType == 'ip')
                <div class="form-group row g-3">
                    <div class="col-sm-6 "> 
                        <label for="inputCity" class="form-label">IP Address</label>
                            @foreach($ips as $index => $ip)
                                <div class="input-group mb-2">
                                    <input type="text" wire:model="ips.{{ $index }}" placeholder="IP Address" class="form-control @error('ips.'.$index) is-invalid @enderror" aria-label="IP of Nameserver">
                                    @if ($loop->first && count($ips) < 5)
                                        <span class="input-group-text"
                                            wire:click="addIp()"
                                            style="cursor:pointer;">
                                            <i class="fa fa-plus-circle" style="color:green; font-size:20px;"></i>
                                        </span>
                                    @endif

                                    <!-- Remove IP (if more than 1) -->
                                    @if ($index > 0)
                                        <span class="input-group-text"
                                            wire:click="removeIp({{ $index }})"
                                            style="cursor:pointer;">
                                            <i class="fa fa-minus-circle" style="color:red; font-size:20px;"></i>
                                        </span>
                                    @endif

                                    @error("ips.$index")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                            {{-- </div>
                        </div> --}}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark">Submit / Generate letter</button>       
        </div>

    </form>
</div>
@script
    <script>
        window.addEventListener('subDomainReg', (event) => {
            let data = event.detail[0];
            Swal.fire({
                position: 'center',
                width: 800,
                showConfirmButton: false,
                title: data.title,
                icon: data.icon,
                html: data.html,
                timer: null,
                allowOutsideClick: false,
                allowEscapeKey: false,
                footer: '<a class="btn btn-outline-primary btn-sm" href="/user/submitletter">Submit Letter</a>'

            }); // Show alert with the message
        });
    </script>
@endscript
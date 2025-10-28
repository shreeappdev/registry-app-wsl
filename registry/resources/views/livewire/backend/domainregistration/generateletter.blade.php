<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Generate letter</h1>
    </div>

     @if (session()->has('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
     @endif

     @if($isNewNodal)
        @include('livewire.backend.domainregistration.generateletter_nonnodal')
     @else
        <form method="POST" wire:submit.prevent='generateLetter'>
            @csrf

            {{-- @if (session()->has('failed'))
                <div class="alert alert-danger">
                    {{ session('failed') }}
                </div>
            @endif --}}
            @if ($currentStep == 1)
                <div class="form-group row">                 
                    <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>

                    <div class="col-sm-10">
                        <select class="form-control @error('domainid') is-invalid @enderror" wire:model.live="domainid"
                            id="domainid">
                            <option value="">Select Option</option>
                            @foreach ($domains as $domain)
                                <option value={{ $domain->domainid }}
                                    {{ old('domainid') == $domain->domainid || (session('submittedData')['domainid'] ?? '') == $domain->domainid ? 'selected' : '' }}>
                                    {{ $domain->dname_decoded_punycode }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            @error('domainid')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                @if($isLtrGenerated)
                <div class="form-group row">
                    
                    <div class="col-sm-10">
                        <ul>
                            <li>
                                <i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i> 
                                <a target="_blank" style="color:#774dd3" href="{{ $annex1 }}">
                                <strong> Download </strong> </a> last generated Authorization Letter (Anex-I)
                            </li>
                            <li>
                                <i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i>
                                <a target="_blank" style="color:#774dd3" href="{{ $annex2 }}"><strong> Download </strong> </a> last generated Forwarding Letter (Anex-II)
                            </li>
                        
                        </ul>
                   
                        <button type="button" 
                            class="btn btn-primary btn-sm px-2 py- shadow-sm fw-semibold"
                            wire:click="regenerateLetter()">
                            Regenerate Letter
                        </button>
                    </div>
                </div>
                @else
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Sign By</label>
                    <div class="invalid-feedback d-block">
                        @error('officertype')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="col-sm-10">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('officertype') is-invalid @enderror" type="radio" wire:model="officertype" id="radiobuttonNodal"
                                value="nodal" checked>
                            <label class="form-check-label" for="radiobuttonNodal">
                                Nodal Officer
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('officertype') is-invalid @enderror" type="radio" wire:model="officertype" id="radiobuttonNonNodal"
                                value="non-nodal">
                            <label class="form-check-label" for="radiobuttonNonNodal">
                                Non Nodal Officer
                            </label>
                        </div>

                        {{-- <div class="invalid-feedback d-block">
                            @error('officertype')
                                {{ $message }}
                            @enderror
                        </div> --}}

                    </div>
                </div>
                @endif
            @endif

            @if ($currentStep == 2 && !empty($nodalofficers))
                <div class="col-lg-12 mb-4">
                    <!-- Project Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body mx-5">
                            <div id="message"></div>

                        {{-- <div class="invalid-feedback">
                            @error('nodalofficerid')
                                {{ $message }}
                            @enderror
                        </div> --}}
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control me-2" placeholder="Search officers..." style="width: 250px;">
                                {{-- <button class="btn btn-outline-secondary">Search</button> --}}
                            </div>
                            @if($officertype == 'non-nodal')
                            <button class="btn btn-primary" wire:click="addNewNodal()" >Add New</button>
                                {{-- <a wire:navigate href="{{ route('generateletter_domainreg', ['letterType' => 'non-nodal', 'domainid' => $domainid]) }}" class="btn btn-primary">Add New</a> --}}
                            @endif
                        </div>
                            <table class="table table-bordered" id="nodalOfficer">
                                <thead  style="background-color: #f0f0f0; color: #333;">
                                    <tr>
                                        <th scope="col">Select officer</th>
                                        {{-- <th scope="col">#</th> --}}
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Ministry/Department/Organisation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($nodalofficers) > 0)
                                        @foreach ($nodalofficers as $nodal)
                                    
                                            <tr>
                                                <td class="align-middle text-center"><input id="nodalofficer_{{ $nodal->faid }}" type="radio" wire:model="nodalofficerid" value="{{ $nodal->faid }}" /></td>
                                                <td>{{ $nodal->name }}</td>
                                                <td>{{ $nodal->email }}</td>
                                                <td>
                                                    <ul>
                                                    @if(!empty($nodal->minDetails?->m_name))
                                                        <li><b>Min: </b>{{  $nodal->minDetails->m_name }}</li>
                                                    @endif
                                                    @if(!empty($nodal->deptDetails?->name))
                                                        <li><b>Dept: </b>{{  $nodal->deptDetails->name }}</li>
                                                    @endif

                                                    @if(!empty($nodal->orgDetails?->org_name))
                                                        <li><b>Org: </b>{{  $nodal->orgDetails->org_name }}</li>
                                                    @endif
                                                   </ul>
                                                </td>
                                               
                                            </tr>
                                        @endforeach
                                    @else                                
                                    <tr>
                                        <td colspan="4" class="text-center">No Officers found. Please select Non Nodal Officer.</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="invalid-feedback d-block">
                @error('nodalofficerid')
                    {{ $message }}
                @enderror
            </div>
            <div class="form-group row">
                <label for="submit" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($currentStep == 2)
                        <button type="button" class="btn btn-danger" wire:click="decreaseStep()">Back</button>
                        <button type="submit" class="btn btn-success pull-right" wire:click="generateLetter()">Generate Letter</button>
                    @endif
                    @if ($currentStep == 1 && !$isLtrGenerated)
                        <button type="button" class="btn btn-success" wire:click="increaseStep()">Next</button>
                    @endif
                    {{-- <button type="button" class="btn btn-danger" wire:click="decreaseStep()">Back</button> --}}
                </div>
            </div>

        </form>
     @endif
</div>
@script
    <script>
        window.addEventListener('regletterGenerated', (event) => {
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
                footer: '<a href="/user/dashboard">Back to Dashboard</a>'

            }); // Show alert with the message
        });
    </script>
@endscript

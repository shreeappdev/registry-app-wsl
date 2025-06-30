<form class="row needs-validation" method= "post" wire:submit.prevent="register" novalidate>
    @csrf
    @if ($currentStep == 1)
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
            <div class="col-sm-10">
                <select class="form-control @error('domainid') is-invalid @enderror" wire:model="domainid" id="domainid">
                    <option value="">Select Domain</option>
                    @foreach ($domains as $domain)
                        <option value={{ $domain->domainid }}
                            {{ old('domainid') == $domain->domainid || (session('submittedData')['domainid'] ?? '') == $domain->domainid ? 'selected' : '' }}>
                            {{ $domain->domainname }}</option>
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
            <label for="inputPassword" class="col-sm-4 col-form-label">Number of required domain</label>
            <div class="col-sm-10">

                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="reg_type" id="regType1"
                        value="1" checked>
                    <label class="form-check-label" for="regType1">
                        Single Subdomain
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="reg_type" id="regType2"
                        value="2">
                    <label class="form-check-label" for="regType2">
                        Multiple subdomain
                    </label>
                </div>
            </div>
            <div class="invalid-feedback">
                @error('reg_type')
                    {{ $message }}
                @enderror
            </div>
        </div>
       

        @if ($reg_type == 1)
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Action</label>
            <div class="col-sm-10">

                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="action" id="action1"
                        value="1">
                    <label class="form-check-label" for="action1">
                        Generate Letter
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="action" id="action2"
                        value="2">
                    <label class="form-check-label" for="action2">
                        Submit Request
                    </label>
                </div>
            </div>
            <div class="invalid-feedback">
                @error('action')
                    {{ $message }}
                @enderror
            </div>
        </div>
            <!--Sign type -->
        @endif
        @if($action == 2 && $reg_type == 1)
            @if (!empty($generatedSubdomainLetter))
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Sl No</th>
                            <th scope="col">Subdomain Name</th>
                            <th scope="col">Letter Generate Date</th>
                            <th scope="col">Sign the letter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1;@endphp


                        @foreach ($generatedSubdomainLetter as $domain)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $domain->domainname }}</td>
                                <td>{{ $domain->uploaddate }}</td>
                                <td>
                                    <a href="{{ route('single-domain', ['domainid' => $domain->domainname]) }}"><button class="btn btn-info btn-sm"> View</button></a>
                                    <a href="{{ route('single-domain', ['domainid' => $domain->domainname]) }}"><button class="btn btn-success btn-sm"> Esign</button></a>
                                   <button class="btn btn-warning btn-sm" wire:click="openModal({{ $domain->t_id}})"> Ink Sign</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif
        @endif
    @endif

    @if ($currentStep == 2)
         
            <div class="form-group row">
                <label for="inputCname" class="col-sm-2 col-form-label">Subdomain Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="subdomainname" value=""
                        placeholder="Enter Name.." id="inputSubdomainName">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Mapping</label>
                <div class="col-sm-10">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.live="mapping" id="mapping1" value=1>
                        <label class="form-check-label" for="mapping1">
                            IP
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.live="mapping" id="mapping2" value=2>
                        <label class="form-check-label" for="mapping2">
                            CNAME
                        </label>
                    </div>
                </div>
                <div class="invalid-feedback">
                    @error('action')
                        {{ $message }}
                    @enderror
                </div>
            </div>


            @if ($mapping == 2)
                <div class="form-group row">
                    <label for="inputCname" class="col-sm-2 col-form-label">CNAME</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="cname" value=""
                            placeholder="Enter CNAME" id="inputCname">
                    </div>
                </div>
            @elseif($mapping == 1)
                <div class="form-group row">
                    <label for="inputIp" class="col-sm-2 col-form-label">IP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-2" wire:model="ipAddress" value=""
                            placeholder="Enter IP..">
                        <input type="text" class="form-control mb-2" wire:model="ipAddress" value=""
                            placeholder="Enter IP..">
                        <input type="text" class="form-control mb-2" wire:model="ipAddress" value=""
                            placeholder="Enter IP..">
                        <input type="text" class="form-control mb-2" wire:model="ipAddress" value=""
                            placeholder="Enter IP..">
                        <input type="text" class="form-control mb-2" wire:model="ipAddress" value=""
                            placeholder="Enter IP..">
                    </div>
                </div>
          
            @endif

    @endif
    @if ($currentStep == 3)

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Signing Process</label>
            <div class="col-sm-10">

                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="signing_process"
                        id="signingProcess1" value=1 checked>
                    <label class="form-check-label" for="signingProcess1">
                        Ink Sign
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="signing_process"
                        id="signingProcess2" value=2>
                    <label class="form-check-label" for="signingProcess2">
                        Esign
                    </label>
                </div>
            </div>
            <div class="invalid-feedback">
                @error('signing_process')
                    {{ $message }}
                @enderror
            </div>
        </div>

        @if ($signing_process == 1)
            <div class="form-group row">
                <label for="submit" class="col-sm-2 col-form-label">Upload Letter</label>
                <div class="col-sm-10">
                    <input type="file" name="cancelletter"
                        class="form-control-file @error('subdomainregletter') is-invalid @enderror">
                    <div class="invalid-feedback">
                        @error('subdomainregletter')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        @elseif($signing_process == 2)
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Contact Type</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="contact_type" id="contactType1"
                            value="1" checked>
                        <label class="form-check-label" for="contactType1">
                            Organisational Contact
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model="contact_type" id="contactType2"
                            value="2">
                        <label class="form-check-label" for="contactType2">
                            Administrative Contact
                        </label>
                    </div>
                </div>
                <div class="invalid-feedback">
                    @error('contact_type')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        @endif

    @endif

    <div class="form-group row">
        <label for="submit" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            @if ($currentStep == 2 && $action == 1 && $reg_type == 1)
                <button type="button" class="btn btn-primary" wire:click="generateLetter()">Generate Letter</button>
            @endif

            @if ($currentStep ==1 && $action == 1 && $reg_type == 1)
                <button type="button" class="btn btn-primary" wire:click="increaseStep()">Next</button>
            @endif
            @if ($action == 2 && $reg_type == 1)
                <button type="button" class="btn btn-primary" wire:click="getGeneratedLetters()">Get
                    Subdomains</button>
            @endif
            @if ($currentStep == 1 && $reg_type == 2)
               <button type="button" class="btn btn-primary" wire:click="multipledomainRegister('{{$domainid}}')">Proceed</button>
            @endif
            
            @if ($currentStep > 1)
                <button type="button" class="btn btn-primary" wire:click="decreaseStep()">Back</button>
            @endif
        </div>
    </div>
</form>
    @if ($showModal)
        <div class="modal fade" id="uploadsubdomainLetter" tabindex="-1" aria-labelledby="uploadLetter" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Letter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  wire:submit.prevent="uploadRegLetter">
                            @csrf
                            <div class="form-group">
                            <label for="message-text" class="col-form-label">Upload Letter</label>
                                <input type="file" wire:model="subdomainletter"/>
                            </div>
                            <button type="submit">Submit</button>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    @endif
@script
    <script>

        /**alert after generating letter */
        
        window.addEventListener('formSubmitted', (event) => {
            let data = event.detail;
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
                footer: '<a href="/user/subdomain-registration">Back to Dashboard</a>'

            }); // Show alert with the message
        });

       
    </script>
@endscript

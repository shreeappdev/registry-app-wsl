<form wire:submit.prevent="generateLetter">
    <div id="form-rows">
        @foreach ($subdomainsRow as $index => $row)
            <div class="row mb-3">

                <div class="form-group row">
                    <label for="inputCname" class="col-sm-2 col-form-label">Subdomain Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="subdomainsRow.{{ $index }}.subdomainname" value="" placeholder="Enter Name.." id="inputSubdomainName">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Mapping</label>
                    <div class="col-sm-10">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="subdomainsRow.{{ $index }}.mapping" wire:click="onChangeMapping({{ $index }}, 'option1')"
                                {{ $row['mapping'] == 'option1' ? 'checked' : '' }} id="mapping1" value='option1'>
                            <label class="form-check-label" for="mapping1">
                                IP
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model="subdomainsRow.{{ $index }}.mapping"
                                id="mapping2" wire:click="onChangeMapping({{ $index }}, 'option2')"
                                {{ $row['mapping'] == 'option2' ? 'checked' : '' }} value='option2'>
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
                @if ($row['showIpDiv'])
             
                 {{-- @foreach ($mappedips as $index_ip=>$ipcname) --}}
                 @foreach ($row['ips'] as $index_ip=>$ipcname)
                            <div class="form-group row">
                                <label for="inputCname" class="col-sm-2 col-form-label">IP</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" wire:model="subdomainsRow.{{ $index }}.ips.{{ $index_ip }}" value="" placeholder="Enter IP" id="inputIP">
                                </div>
                           
                                @if(count($row['ips']) > 1)
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            wire:click="removeRowMappedIp({{$index}},{{ $index_ip }})">
                                            Remove Row
                                        </button>
                                </div>
                             @endif
                        </div>
                    @endforeach

                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-info btn-sm" wire:click="addRowMappedIp({{ $index }})">Add IP</button>
                        </div>
                   
                    </div>
                @endif
                @if ($row['showCnameDiv'])
                    <div class="form-group row">
                        <label for="inputCname" class="col-sm-2 col-form-label">CNAME</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" wire:model="subdomainsRow.{{ $index }}.cname" value="" placeholder="Enter CNAME" id="inputCname">
                        </div>
                    </div>
                @endif

                @if($row['showRemovebtn'])
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm"
                        wire:click="removeRow({{ $index }})">
                        Remove Row
                    </button>
                </div>
                @endif
            </div>
            <hr class="border-dark">
        @endforeach
    </div>
    @if(count($subdomainsRow) <=20 )
    <button type="button" class="btn btn-primary" wire:click="addSubdomainRow">Add Row</button>
    @endif
    <button type="submit" class="btn btn-success">Submit</button>
</form>
@script
    <script>

        /**alert after generating letter */
        
        window.addEventListener('multipleSubdomainLtrGenrete', (event) => {
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
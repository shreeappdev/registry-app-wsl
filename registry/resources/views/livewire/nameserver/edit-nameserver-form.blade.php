<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nameserver Update</h1>
    </div>
    <div class="card-body">
        <div class="card-body row g-3">

            <form wire:submit.prevent="updateNameserver">
    
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checknicNameserver"  wire:change="toggleDiv">
                    <label class="form-check-label" for="checknicNameserver">Nic Hosted Nameservers
                    </label>
                </div>
            </div>

            @if(!$isChecked)
          
            <div class="col-12" id="nonNicNameservers">

                @foreach($multipleip as $index => $entry)
                    <div class="row my-2 nameserverGroup"  data-id=0>
                        <div class="col">
                            <input type="text" wire:model="multipleip.{{ $index }}.nshostname" placeholder="Hostname for IP " class="form-control hostnameClass @error('multipleip.*') is-invalid @enderror"
                            placeholder="Nameserver 1" aria-label="Nameserver 1">
                        </div>
                        <div class="col mappedip-group">
                            <input type="text" wire:model="multipleip.{{ $index }}.ip" placeholder="IP Address for IP " class="form-control ipClass"
                            placeholder="IP of Nameserver" >
                        
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-outline-danger remove-button" wire:click="removeEntry({{ $index }})" >Remove</button>
                        </div>
                  </div>
                @endforeach

                    @error('multipleip.*')
                       <div class="alert alert-danger"> {{ $message }}  </div>
                    @enderror
                  
                   
                <div class="row my-2">
                    <div class="col">
                        <button type="button" id="addRow" wire:click="addEntry" class="btn btn-success btn-sm"> Add
                            Nameserver <i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            @endif
            <!--Nic nameservers-->

            @if($isChecked)
                <div class="col-12" id="nicNameservers" >

                    <input type="text" class="form-control my-2" placeholder="Nameserver 1" aria-label="Nameserver 1"  value="ns1.nic.in" disabled>
                    <input type="text" class="form-control my-2" placeholder="Nameserver 1" aria-label="Nameserver 2" value="ns2.nic.in" disabled>
                    <input type="text" class="form-control my-2" placeholder="Nameserver 1" aria-label="Nameserver 3" value="ns7.nic.in" disabled>
                    <input type="text" class="form-control my-2" placeholder="Nameserver 1" aria-label="Nameserver 4" value="ns10.nic.in" disabled>


                </div>
                @endif
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href=""><button type="button" class="btn btn-danger">Back</button></a>
                </div>
              </form>
        </div>
    </div>
</div>

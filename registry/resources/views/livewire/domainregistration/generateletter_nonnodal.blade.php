<div>

    <form method="POST" wire:submit.prevent='generateLetter'>
        @csrf                  
        <div class="card">
            <div class="card-header bg-primary text-white shadow">
                Generate Letter Non Nodal
            </div>
            <div class="card-body">

                <div class="form-group row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control @error('newNodalName') is-invalid @enderror" placeholder="Enter name" wire:model.live="newNodalName">
                        <div class="invalid-feedback">
                            @error('newNodalName')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" class="form-control  @error('newNodalEmail') is-invalid @enderror" placeholder="Please enter gov.in/nic.in email id" wire:model.live="newNodalEmail">
                        <div class="invalid-feedback"> 
                            @error('newNodalEmail')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-group row g-3">
                    <div class="col-md-6">
                        <label for="designation" class="form-label">Select Designation</label>
                        <select id="designation" class="form-control @error('selectedNewNodalDesg') is-invalid @enderror"
                                    wire:model.live="selectedNewNodalDesg">
                                    <option value="" selected>Choose...</option>
                                    @foreach ($newNodalDetails['designations'] as $key => $desg)
                                        <option value="{{ $desg->id }}">{{ $desg->designation }}</option>
                                    @endforeach

                                </select>
                        <div class="invalid-feedback">
                            @error('selectedNewNodalDesg')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    
                    @if(!empty($newNodalDetails['ministry']   ))
                     <div class="col-md-6">
                        <label for="inputCity" class="form-label">Ministry </label>
                        <input type="text" id="inputCity" class="form-control " placeholder="Enter Ministry" wire:model.live="ministry" value="{{ $newNodalDetails['ministry'] }}" readonly >
                        <div class="invalid-feedback"> </div>
                    </div>
                    @endif
                     @if(!empty($newNodalDetails['state']))
                     <div class="col-md-6">
                        <label for="inputCity" class="form-label">State </label>
                        <input type="text" id="inputCity" class="form-control " placeholder="Enter state" wire:model.live="ministry" value="{{ $newNodalDetails['state'] }}" readonly >
                        <div class="invalid-feedback"> </div>
                    </div>
                    @endif
                    
                </div>
                
                <div class="form-group row g-3">
                    @if(!empty($newNodalDetails['department']))
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Department </label>
                            <input type="text" id="inputCity" class="form-control " value="{{ $newNodalDetails['department'] }}" readonly>
                            <div class="invalid-feedback"> </div>
                        </div>
                    @endif
                    @if(!empty($newNodalDetails['organisation']))
                        <div class="col-md-6">
                            <label for="inputEmail" class="form-label">Organisation </label>
                            <input type="text" id="inputEmail" class="form-control " value="{{ $newNodalDetails['organisation'] }}" readonly>                               
                            <div class="invalid-feedback"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
                        
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark">submit</button>
        </div>
    </form>
</div>
@script
    {{-- <script>
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
    </script> --}}
@endscript

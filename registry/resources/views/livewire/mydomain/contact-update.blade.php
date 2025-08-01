

<form class="row needs-validation" method= "POST" wire:submit.prevent="update" novalidate>
    @csrf
    <div class="card">
        <div class="card-header bg-primary text-white shadow">
            Edit Contact Form
        </div>
          <div class="card-body row g-3">
         
                <div class="form-group col-md-6 my-2">
                    <label for="cname" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter name" id="cname" wire:model.live="name" >
                    <div class="invalid-feedback">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-6 my-2">
                    <label for="inputDesignation" class="form-label">Designation</label>
                    <input type="text" class="form-control @error('designation') is-invalid @enderror"
                        placeholder="Enter designation" id="inputDesignation" wire:model="designation">
              
                    <div class="invalid-feedback">
                        @error('designation')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
           
        
                <div class="form-group col-12 my-2">
                    <label for="inputAddress1" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address1') is-invalid @enderror" placeholder="Enter Address" id="inputAddress1"
                        placeholder="Enter Address" wire:model="address1">
                    <div class="invalid-feedback">
                        @error('address1')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            
                 <div class="form-group col-md-6 my-2">
                    <label for="inputCity" class="form-label">City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="inputCity" placeholder="Enter City"
                        wire:model="city">
                    <div class="invalid-feedback">
                        @error('city')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-4 my-2">
                    <label for="inputState" class="form-label">State</label>
                    <select id="inputState" class="form-control @error('state') is-invalid @enderror"  wire:model="state">
                        <option selected>Choose...</option>
                            @foreach($states as $state)
                                <option>{{$state->state_utname}}</option>
                            @endforeach
                    </select>

                    <div class="invalid-feedback">
                        @error('state')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-2 my-2">
                    <label for="orginputPincode" class="form-label">Pincode</label>
                    <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="orginputPincode" placeholder="Enter Pincode" wire:model="pincode" minlength=6>

                    <div class="invalid-feedback">
                        @error('pincode')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
           
         
                <div class="form-group row g-3">

                            
                            <label for="adminstdcode" class="form-label">Telephone</label>

                                <div class="col-md-2">
                                    <label for="countrydialcode" class="visually-hidden">Country Code</label>
                                    <input type="text" id="countrydialcode" class="form-control @error('countrydialcode') is-invalid @enderror" placeholder="{{ $selectedMinistry != 14 ? '+91':'Country Code'}}"  wire:model="countrydialcode" aria-describedby="countrydialcode" {{ $selectedMinistry != 14 ? 'disabled':''}}>

                                    <div class="invalid-feedback">
                                        @error('countrydialcode')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                              
                            <div class="col-md-2">
                                <label for="stdCode" class="visually-hidden">Std Code</label>
                                <input type="text"
                                    class="form-control @error('stdcode') is-invalid @enderror"
                                    placeholder="STD Code" wire:model="stdcode" aria-describedby="stdcode"
                                    maxlength=4 minlength=2>
                                <div class="invalid-feedback">
                                    @error('stdcode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="telpehoneno" class="visually-hidden">Number</label>
                                <input type="text"
                                    class="form-control @error('telpehoneno') is-invalid @enderror" maxlength=10
                                    minlength=4 aria-describedby="telpehoneno" wire:model="telpehoneno">

                                <div class="invalid-feedback">
                                    @error('telpehoneno')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
               
                <div class="col-md-6 my-2">
                    <label for="inputMobile" class="form-label">Mobile No</label>
                    <input type="text" class="form-control @error('mobileno') is-invalid @enderror" id="inputMobile" placeholder="Enter Mobile No" minlength=10 wire:model="mobileno">
                    <div class="invalid-feedback">
                        @error('mobileno')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
          
           
                <div class="col-md-6 my-2">
                    <label for="inputEmail" class="form-label">Email Id</label>
                    <input type="text" class="form-control @error('emailid') is-invalid @enderror" id="inputEmail" placeholder="Enter Email" wire:model="emailid">
                    <div class="invalid-feedback">
                        @error('emailid')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{route('single-domain',['domainid'=>$domainid])}}"><button type="button" class="btn btn-danger">Back</button></a>
                </div>
            
         </div>               
    </div>
</form>

@script
    <script>
        window.addEventListener('contactrequestsubmitted', (event) => {
            let data = event.detail;
            Swal.fire({
                position: 'center',
                width: 800,
                showConfirmButton: false,
                icon: data.icon,
                html: data.html,
                timer: null,
                allowOutsideClick: false,
                allowEscapeKey: false,
                footer: '<a href="/user/dashboard">Back to Dashboard</a>'

            }); // Show alert with the message
        });

        window.addEventListener('contactrequestFailed', (event) => {
            let data = event.detail;
            Swal.fire({
                position: 'center',
                width: 800,
                showConfirmButton: false,
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



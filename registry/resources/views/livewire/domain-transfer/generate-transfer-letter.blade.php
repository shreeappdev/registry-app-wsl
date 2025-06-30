<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Generate Letter</h1>
    </div>
    <form method="POST" wire:submit.prevent='generatetransferLetter'>
        @csrf
        @if (session()->has('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
    
          
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Select Language</label>
                <div class="col-sm-10">
                    <select class="form-control @error('language') is-invalid @enderror" wire:model.live="language"
                        id="language">
                        <option value="">Select Options</option>
                        @foreach ($languges as $lang)
                            <option value={{ $lang->lang_code}}>
                                {{ $lang->lang_name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('language')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Select No of Domain</label>
                <div class="col-sm-10">
                    <select class="form-control @error('no_of_domain') is-invalid @enderror" wire:model.live="no_of_domain"
                        id="NoofDomain">
                        <option value="0">select No of Domain</option>
                        @for ($n=1;$n<=10;$n++)
                            <option value={{ $n }}>{{ $n }}</option>
                        @endfor
                    </select>
                    <div class="invalid-feedback">
                        @error('no_of_domain')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
           
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Select No of Domain</label>
                <div class="col-sm-10">
                   
                        @for($field=1;$field<=$no_of_domain;$field++)
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" id="domainname" placeholder="Enter Domain Name" wire:model="domainname_transfer.{{$field}}">
                                    <span class="input-group-text">{{$extension}}</span>
                                    <div class="invalid-feedback">
                                         @error('domainname_transfer')
                                            {{ $message }}
                                         @enderror
                                    </div>
                            </div>
                        @endfor
                   
                </div>
            </div>
            


        <div class="form-group row">
            <label for="submit" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success pull-right">Generate Letter</button>
                <button type="button" class="btn btn-danger" wire:click="decreaseStep()">Back</button>
            </div>
        </div>

    </form>
</div>
@script
    <script>
        window.addEventListener('transferletterGenerated', (event) => {
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
                footer: '<a href="/user/dashboard">Back to Dashboard</a>'

            }); // Show alert with the message
        });
    </script>
@endscript

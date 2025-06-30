<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Generate Letter</h1>
    </div>
    <form method="POST" wire:submit.prevent='submittransferLetter'>
        @csrf
        @if (session()->has('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
          
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Select Generated Domains</label>
                <div class="col-sm-10">
                    <select class="form-control @error('requested_domains') is-invalid @enderror" wire:model.live="requested_domains"
                        id="requestedDomain">
                        <option value="">Select Option</option>
                        @foreach ($generatedLetters as $request)
                            <option value={{ $request->ltr_id}}>
                                {{ $lang->domains_to_be_delegated }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('requested_domains')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>           
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Upload Letter</label>
                <div class="col-sm-10">

                        <input type="file" wire:model="file"
                            class="form-control-file @error('file') is-invalid @enderror">
                        <div class="invalid-feedback">
                            @error('file')
                                {{ $message }}
                            @enderror
                        </div>
                
                   
                </div>
            </div>
            


        <div class="form-group row">
            <label for="submit" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-success pull-right">Submit Letter</button>
                <button type="button" class="btn btn-danger" wire:click="decreaseStep()">Back</button>
            </div>
        </div>

    </form>
</div>
@script
    <script>
        window.addEventListener('transferletterSubmitted', (event) => {
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

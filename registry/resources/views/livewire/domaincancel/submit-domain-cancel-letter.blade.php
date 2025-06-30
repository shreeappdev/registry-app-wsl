<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Submit Letter</h1>

    </div>

    <!-- Content Column -->
    <div class="col-lg-12 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-body mx-5">

            
                @if(session('formSubmitted'))
                    @if (session('success'))
                   
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Well done!</h4>
                            <p> {{ session('success') }}</p>
                            <hr>
                            <p class="mb-0">You may check your status <a href="{{route('domain_status')}}">Track Status</a></p>
                        </div>
                    
                    @endif
  
                    @if (session('error'))
                        <div style="color: red; padding: 10px; background-color: #f8d7da; border-radius: 5px;">
                            {{ session('error') }}
                        </div>
                    @endif
                @else  

                    <form wire:submit.prevent="submitCancelLetter">
                        @csrf
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('domainid') is-invalid @enderror" wire:model="domainid"
                                    id="domainid">
                                    <option value="">Select Domain</option>
                                    @foreach ($domains as $domain)
                                        <option value={{ $domain->domainid }}
                                            {{ old('domainid') == $domain->domainid || (session('submittedData')['domainid'] ?? '') == $domain->domainid ? 'selected' : '' }}>
                                            {{ $domain->domainname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="submit" class="col-sm-2 col-form-label">Remarks</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('remarks') is-invalid @enderror" wire:model="remarks">Please enter reason of deactivation</textarea>
                                <div class="invalid-feedback">
                                    @error('remarks')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="submit" class="col-sm-2 col-form-label">Upload Letter</label>
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
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
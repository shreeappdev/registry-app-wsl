<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $pageTitle }}</h1>
     
    </div>
    {{-- <a href="{{ url('storage/domaincancel.pdf') }}">Download Pdf</a> --}}
    <!-- Content Column -->
    <div class="col-lg-12 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-body mx-5">


                <form method="POST" action="" id="generateCancelletterPdfForm" wire:submit.prevent="generateCancelLetter">
                   @csrf
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
                      <div class="col-sm-10">
                      
                        <select class="form-control @error('domainid') is-invalid @enderror" wire:model="domainid"  id="domainid" >
                            <option value="0">Select Option</option>
                            @foreach ($domains as $domain)
                                <option value={{$domain->domainid }} {{ (old('domainid') == $domain->domainid || (session('submittedData')['domainid'] ?? '') == $domain->domainid) ? 'selected' : '' }}> {{ $domain->domainname }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="submit" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                  </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Download PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your PDF is ready! Click the link below to download:</p>
                    <a id="pdf-link" href="#" target="_blank" class="btn btn-success">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
 </div>

@section('scripts')
<script>

window.addEventListener('cancelletterGenerated',(event) => {
           let data= event.detail;
             Swal.fire({
              position: 'center',
              width:800,
              showConfirmButton: false,
              title:data.title,
              icon: data.icon,
              html: data.html,
              timer: null,
              allowOutsideClick: false,
              allowEscapeKey: false,
              footer: '<a href="/user/dashboard">Back to Dashboard</a>'

            }); // Show alert with the message
        });
</script>
@endsection
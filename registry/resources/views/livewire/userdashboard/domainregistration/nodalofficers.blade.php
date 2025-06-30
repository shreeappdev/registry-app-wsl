@extends('layout.user-dashboard.app')

@section('content')
    <!-- Begin Page Content -->
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Choose Sighing Authority</h1>

        </div>
        @if($currentstep == 2 && !empty($nodaloffiers))
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body mx-5">
                    <div id="message"></div>

                <form id="generatePdfForm">
                  
                  <table class="table table-bordered" id="nodalOfficer">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Ministry/Department/Organisation</th>
                        <th scope="col">Select officer</th>
                      </tr>
                    </thead>
                    <tbody>

                  
                        @php $i=1; @endphp
                        @foreach($nodaloffiers as $nodal)

                        <tr>
                          <td>{{ $i++}}</td>
                          <td>{{ $nodal->name}}</td>
                          <td>{{ $nodal->email}}</td>
                          <td>{{ $nodal->name}}</td>
                          <td><input type="radio" name="nodalofficerid" id="nodalofficerid" value="{{$nodal->faid}}"/> </td>
                        </tr>
                        @endforeach
                   
                    
                    </tbody>
                  </table>
                 <div>
                    <input type="hidden" id="domainid" value="{{ !empty($domainid) ? $domainid :""}}">
                    <button  type="submit"  class="btn btn-success pull-right">Generate Letter</button>
                    <a href="{{route('generatletter_domainreg')}}"> 
                    <button type="button" class="btn btn-danger pull-right">Back</button></a>
                </div>
                </form>
                </div>
            </div>
        </div>
        @endif

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
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#generatePdfForm').on('submit', function (e) {
            e.preventDefault();
            $('#message').html('');
            var formData = {
                nodalofficerid: $('#nodalofficerid:checked').val(),
                domainid: $('#domainid').val(),
                _token: '{{ csrf_token() }}' // CSRF token
            };
          
            $.ajax({
                url: '{{ route("generate.pdf") }}',
                type: 'POST',
                data:formData,
                success: function (response) {

                    if(response.success === false){
                        $('#message').html('<div class="alert alert-danger">'+response.message+'</div>');

                    }else{
                        if (response.pdf_url) {
                            $('#pdf-link').attr('href', response.pdf_url);
                            $('#pdfModal').modal('show'); // Show the modal
                        }
                    }

                    
                },
                error: function (xhr) {
                    $('#message').prepend('<div class="alert alert-danger">'+xhr.responseJSON.message+'</div>');
                    
                }
            });
         });
    });
</script>
@endsection
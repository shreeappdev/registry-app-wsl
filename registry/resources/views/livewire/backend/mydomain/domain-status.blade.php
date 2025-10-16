<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Domain Status</h1>

    </div>
    @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
    @endif
    <!-- Content Column -->
    <div class="col-lg-12 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-body mx-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Sl No</th>
                            <th scope="col">Domain Name</th>
                            <th scope="col">Letter Details</th>
                            <th scope="col" class="text-center">Get Domain Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1;@endphp
                        @foreach ($domains as $domain)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $domain->domainname }}</td>
                                                    
                                <td>
                                    @if($domain->registrationLetters()->exists())
                                     @foreach ($domain->registrationLetters as $letter) 
                                        <p><a href="">{{$letter->lettertype == 1 ? "Anex-I" : "Annex-II"}} </a>
                                            
                                            <span class="badge badge-sm border border-warning text-warning bg-warning"> {{$letter->asReason->as_reason_detail}}
                                            </span>
                                            </p>
                                
                                    @endforeach
                                    @else
                                      <span class="badge badge-sm border border-danger text-danger bg-danger"> No letter</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{route('single-domain',['domainid' => $domain->domainid])}}"><button class="btn btn-success btn-sm"> View</button></a> 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Update Status</h1>

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
                            <th scope="col">Contact Type</th>
                            <th scope="col" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1;@endphp
                        @foreach ($contactdata as $data)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $data->domainname }}</td>
                                                    
                                <td>
                                    @if($data->contact_type == 1)
                                        Organisation Contact
                                    @elseif($data->contact_type == 2)
                                        Administrative Contact
                                    @elseif($data->contact_type == 2)
                                        Technical Contact
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($data->approved == 'P')
                                    <span class="badge badge-sm border border-warning text-warning bg-warning"> Pending </span>
                                    @elseif($data->contact_type == 'A')
                                    <span class="badge badge-sm border border-success text-success bg-success"> Approved </span>
                                    @elseif($data->contact_type == 'R')
                                    <span class="badge badge-sm border border-danger text-danger bg-danger"> Rejected </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
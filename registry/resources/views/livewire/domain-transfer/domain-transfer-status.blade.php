<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transfer Requests</h1>
    </div>
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
                            <th scope="col">Uploaded on </th>
                            <th scope="col">Generated on </th>
                            <th scope="col">View Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1;@endphp
                        @foreach ($allrequests as $request)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $request->file_name }}</td>
                                <td>{{ date('d-m-Y', $domain->uploadedon) }}</td>
                                <td>{{ date('d-m-Y', $domain->generated_date) }}</td>
                                <td>{{ $domain->applystatus }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
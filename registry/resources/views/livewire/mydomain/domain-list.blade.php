<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Select Domain</h1>
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
                            <th scope="col">Activation Date</th>
                            <th scope="col">View Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1;@endphp
                        @foreach ($domains as $domain)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $domain->domainname }}</td>
                                <td>{{ date('d-m-Y', $domain->activatation_date) }}</td>
                                <td><a href="{{route('single-domain',['domainid' => $domain->domainid]) }}"><button class="btn btn-success"> View</button></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $domains->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
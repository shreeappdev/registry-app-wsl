<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sub Domain List</h1>
    </div>
@if($subdomains =='')
<div class="alert alert-danger">There is no subdomain under this domain</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col" class="text-center">Sl No</th>
            <th scope="col">Subdomain Name</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>

      
        @foreach ($subdomains as $subdomain)
            <tr>
                <td class="text-center">{{ $sl++ }}</td>
                <td>{{ $subdomain->domainname }}</td>
                <td>
                    <a href="{{ route('subdomain-details', ['subdomain' => $subdomain->subdomainid]) }}"><button class="btn btn-info btn-sm"> Details</button></a>
                    <a href="{{ route('subdomain-edit', ['subdomain' => $subdomain->subdomainid]) }}"><button class="btn btn-success btn-sm"> Edit/Update</button></a>                
                    <a href="{{ route('subdomain-deactivate', ['subdomain' => $subdomain->subdomainid]) }}"><button class="btn btn-danger btn-sm"> Delete </button></a>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
@endif
</div>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Subdomain Details</h1>
    </div>
    <div class="row">

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="col-12 col-xl-6 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0 font-weight-semibold text-lg">Sub Domain Information</h6>
                </div>
                <div class="card-body p-3">

                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span
                                class="text-secondary">Sub Domain Name:</span> &nbsp;
                            {{ $data['domaindetails']->domainname ?? 'No Data' }}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Activation Date:</span> &nbsp;
                            {{ $data['domaindetails']->activation_date ?? 'No Data' }}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Status:</span> &nbsp;
                            {{ $data['domaindetails']->activation_status ?? 'No Data' }}
                        </li>

                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">MappedIp :</span> &nbsp;
                            {{ $data['subdomaindetails']->multipleips ?? 'No Data' }}
                        </li>

                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">CNAME:</span> &nbsp;
                            {{ $data['subdomaindetails']->multiplecname ?? 'No Data' }}
                        </li>


                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-12 col-xl-12 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 col-9">
                            <h6 class="mb-0 font-weight-semibold text-lg">Letter Details</h6>

                        </div>

                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Sl No</th>
                            <th scope="col">Mapped IP/ CNAME</th>
                            <th scope="col">Letter</th>
                            <th scope="col">Upload Date</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($data['subdomainLetters'] as $subdomain)
                            <tr>
                                <td class="text-center">{{ $sl++ }}</td>
                                <td>{{ $subdomain->multipleips }}</td>
                                <td><a href="">{{ $subdomain->filename }}</a></td>
                                <td><a href="">{{ $subdomain->uploadddate }}</a></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 mt-4">
          <button type="button" class="btn btn-danger" wire:click="">Back</button>
        </div>
    </div>

</div>

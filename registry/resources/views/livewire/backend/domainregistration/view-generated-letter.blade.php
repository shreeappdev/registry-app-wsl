<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h4 class="h3 mb-0 text-gray-800">View Generated Letter</h4>
    </div>
    <!-- Content Column -->
    <div class="col-lg-12 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-body mx-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">S No</th>
                            <th scope="col">Domain Name</th>
                            <th scope="col">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($this->generatedLtr as $domain)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $domain->dname_decoded_punycode }}</td>
                            <td>
                                @if (Storage::exists("public/registrationletters/generated/{$domain->domainid}_annex1.pdf"))
                                    <a href="{{ Storage::url("registrationletters/generated/{$domain->domainid}_annex1.pdf") }}" target="_blank" class="btn btn-outline-primary btn-sm">View Annex I</a>
                                @endif
                                @if (Storage::exists("public/registrationletters/generated/{$domain->domainid}_annex2.pdf"))
                                    <a href="{{ Storage::url("registrationletters/generated/{$domain->domainid}_annex2.pdf") }}" target="_blank" class="btn btn-outline-primary btn-sm">View Annex II</a>
                                @endif

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{-- {{ $domains->links('pagination::bootstrap-5') }} --}}
            </div>
        </div>
    </div>
</div>

<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Submit letter</h1>
    </div>
    <form method="POST" wire:submit.prevent='geneerateLetter'>
        @csrf

        @if (session()->has('failed'))
            <div class="alert alert-danger">
                {{ session('failed') }}
            </div>
        @endif
        @if ($currentStep == 1)
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
                <div class="col-sm-10">
                    <select class="form-control @error('domainid') is-invalid @enderror" wire:model="domainid"
                        id="domainid">
                        <option value="">Select Option</option>
                        @foreach ($domains as $domain)
                            <option value={{ $domain->domainid }}
                                {{ old('domainid') == $domain->domainid || (session('submittedData')['domainid'] ?? '') == $domain->domainid ? 'selected' : '' }}>
                                {{ $domain->domainname }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        @error('domainid')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Sign By</label>
                <div class="col-sm-10">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model="officertype" id="radiobuttonNodal"
                            value="nodal" checked>
                        <label class="form-check-label" for="radiobuttonNodal">
                            Nodal Officer
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model="officertype" id="radiobuttonNonNodal"
                            value="non-nodal">
                        <label class="form-check-label" for="radiobuttonNonNodal">
                            Non Nodal Officer
                        </label>
                    </div>

                </div>
            </div>

        @endif

        @if ($currentStep == 2 && !empty($nodaloffiers))
            <div class="col-lg-12 mb-4">
                <!-- Project Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-body mx-5">
                        <div id="message"></div>



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
                                @foreach ($nodaloffiers as $nodal)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $nodal->name }}</td>
                                        <td>{{ $nodal->email }}</td>
                                        <td>{{ $nodal->name }}</td>
                                        <td class="align-middle">
                                            <input type="radio" wire:model="nodalofficerid" id="nodalofficerid"
                                                value="{{ $nodal->faid }}" />
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group row">
            <label for="submit" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                @if ($currentStep == 1)
                    <button type="button" class="btn btn-success" wire:click="increaseStep()">Next</button>
                @endif
                @if ($currentStep == 2)
                    <button type="submit" class="btn btn-success pull-right">Generate Letter</button>
                @endif
                <button type="button" class="btn btn-danger" wire:click="decreaseStep()">Back</button>
            </div>
        </div>

    </form>
</div>
@script
    <script>
        window.addEventListener('regletterGenerated', (event) => {
            let data = event.detail;
            Swal.fire({
                position: 'center',
                width: 800,
                showConfirmButton: false,
                title: data.title,
                icon: data.icon,
                html: data.html,
                timer: null,
                allowOutsideClick: false,
                allowEscapeKey: false,
                footer: '<a href="/user/dashboard">Back to Dashboard</a>'

            }); // Show alert with the message
        });
    </script>
@endscript

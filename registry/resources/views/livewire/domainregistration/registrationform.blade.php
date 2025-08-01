<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Register Domain</h1>
    </div>
    <form class="row needs-validation" method= "post" wire:submit.prevent="register" novalidate>
        @csrf
        @if ($currentStep == 1)
            <div class="step-one">
                <div class="card">
                    <div class="card-header bg-primary text-white shadow">
                        Step 1/6  Domain Details
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                        <div class="col-md-4">
                            <label for="language" class="form-label">Select language</label>
                            <select id="language" class="form-control custom-select @error('language_code') is-invalid @enderror"
                                wire:model.live="language_code">
                                <option>Choose...</option>
                                @foreach ($languages as $key => $language)
                                    <option value="{{ $language->lang_code }}"
                                        {{ $language->lang_code == 'en' ? 'selected' : '' }}>{{ $language->lang_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                @error('language_code')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        </div>
                          <div class="form-group">
                            <div class="col-md-9">
                                <label for="domainname" class="form-label">Domain Name</label>
                                <div class="input-group">
                                    <input type="text" id="domainname" class="form-control  @error('domainname') is-invalid @enderror"
                                        placeholder="Enter Domain Name" wire:model="domainname" required>
                                    <span class="input-group-text">{{ $language_extension->extension ?? '.gov.in' }}</span>
                                    <div class="invalid-feedback">
                                        @error('domainname')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if ($language_code == 'en')
                         <div class="form-group">
                            <div class="col-md-9">
                                <label for="hindidomainname" class="form-label">Idn(Hindi) Domain Name</label>
                                <div class="input-group">
                                    <input type="text"  id="hindidomainname"
                                        class="form-control @error('hindidomainname') is-invalid @enderror"
                                        placeholder="Enter Hindi Domain Name" wire:model="hindidomainname">
                                    <span class="input-group-text">.सरकार.भारत</span>
                                    <div class="invalid-feedback">
                                        @error('domainname')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endif

                     
                        <div class="form-group row g-3">
                            <div class="col-md-3">
                                <label for="region" class="form-label">Select Region</label>
                                <select id="region" class="form-control @error('region') is-invalid @enderror" wire:model.live="region">
                                    <option selected>...Select...</option>
                                    <option value=1>Central</option>
                                    <option value=2>State</option>
                                </select>
                                <div class="invalid-feedback">
                                    @error('region')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                         
                            <div class="col-md-9">
                                <label for="orgCategory" class="form-label">Select Organization Category</label>
                                <select id="orgCategory" class="form-control @error('selectedOrgcategory') is-invalid @enderror"
                                    wire:model.live="selectedOrgcategory">
                                    <option selected>Choose...</option>
                                    @foreach ($orgCategories as $key => $orgcategory)
                                        <option value={{ $orgcategory->orgcatid }}
                                            data-deptVisible={{ $orgcategory->dept_is_visible }}
                                            data-addOrganisation={{ $orgcategory->add_organisation }}
                                            data-showministry={{ $orgcategory->ministry_show_in_dropdown }}>
                                            {{ $orgcategory->orgcat }}</option>
                                    @endforeach

                                </select>
                                <div class="invalid-feedback">
                                    @error('selectedOrgcategory')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                        </div>

                        @if ($region == 1)
                         <div class="form-group">
                            <div class="col-md-6">
                                <label for="ministry" class="form-label">Select Ministry</label>
                                <select id="ministry" class="form-control @error('selectedMinistry') is-invalid @enderror"
                                    wire:model.live="selectedMinistry">
                                    @if (count($ministries) < 1)
                                        <option selected>No data</option>
                                    @else
                                        <option>Choose...</option>
                                        @foreach ($ministries as $key => $min)
                                            <option value={{ $min->m_id }}>{{ $min->m_name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                <div class="invalid-feedback">
                                    @error('selectedMinistry')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                          </div>
                        @endif
                        @if ($region == 2)
                          <div class="form-group">
                            <div class="col-md-6">
                                <label for="domainstate" class="form-label">State</label>
                                <select id="domainstate" class="form-control @error('state_domain') is-invalid @enderror"
                                    wire:model="state_domain">
                                    <option selected>Choose...</option>
                                    @foreach ($states as $state)
                                        <option value={{ $state->state_utcode }}>{{ $state->state_utname }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    @error('state_domain')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                          </div>
                        @endif

                        @if($isdepartmentVisible)
                          <div class="form-group">
                            <div class="col-md-6">
                                <label for="department" class="form-label">Select Department</label>
                                <select id="department" class="form-control @error('selectedDepartment') is-invalid @enderror"
                                    wire:model.live="selectedDepartment">
                                    @if (count($departments) < 1)
                                        <option value="0" selected>No data</option>
                                    @else
                                        <option value="0" selected>Choose...</option>
                                        @foreach ($departments as $key => $department)
                                            <option value={{ $department->id }}>{{ $department->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    @error('selectedDepartment')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                          </div>
                        @endif

                       <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="organisation" class="form-label">Select Organisation</label>
                                <select  class="form-control @error('selectedOrganisation') is-invalid @enderror"
                                    wire:model="selectedOrganisation">
                                   
                                    @if(count($organisations) < 1)
                                        <option value="0" selected>No data</option>
                                    @else
                                        <option>Choose..</option>
                                        @foreach ($organisations as $key => $organisation)
                                            <option value={{ $organisation->org_id }}>{{ $organisation->org_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    @error('selectedOrganisation')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                        @if ($isaddOrganisation)

                         <div class="col-md-6">
                            <label for="addnewOrganisation" class="form-label">Add Organisation</label>
                            <input type="text"  class="form-control @error('addnewOrganisation') is-invalid @enderror" placeholder="Enter Organisation Name" wire:model="addnewOrganisation">
                                @error('addnewOrganisation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                           </div>
                        @endif
                     </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($currentStep == 2)
            <div class="step-two">
                <div class="card">
                    <div class="card-header bg-primary text-white shadow">
                        Step 2/6 (Organisational Contact)
                    </div>
                    <div class="card-body">

                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="orgName" class="form-label">Name</label>
                                <input type="text" class="form-control @error('orgName') is-invalid @enderror"
                                    placeholder="Enter name" wire:model="orgName">
                                <div class="invalid-feedback">
                                    @error('orgName')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputorgDesignation" class="form-label">Designation</label>
                                <input type="text"
                                    class="form-control @error('orgDesignation') is-invalid @enderror"
                                    placeholder="Enter designation" wire:model="orgDesignation">

                                <div class="invalid-feedback">
                                    @error('orgDesignation')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="orginputAddress1" class="form-label">Address</label>
                                <input type="text" class="form-control @error('orgAddress1') is-invalid @enderror"
                                    placeholder="Enter Address" placeholder="Enter Address" wire:model="orgAddress1">
                                <div class="invalid-feedback">
                                    @error('orgAddress1')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="orginputCity" class="form-label">City</label>
                                <input type="text" class="form-control @error('orgCity') is-invalid @enderror"
                                    placeholder="Enter City" wire:model="orgCity">
                                <div class="invalid-feedback">
                                    @error('orgCity')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="orginputState" class="form-label">State</label>
                                <select class="form-control @error('orgState') is-invalid @enderror"
                                    wire:model.live="orgState">
                                    <option selected>Choose...</option>
                                    @foreach ($states as $state)
                                        <option>{{ $state->state_utname }}</option>
                                    @endforeach
                                </select>

                                <div class="invalid-feedback">
                                    @error('orgState')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="orginputPincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control @error('orgPincode') is-invalid @enderror"
                                    placeholder="Enter Pincode" wire:model="orgPincode" minlength=6>

                                <div class="invalid-feedback">
                                    @error('orgPincode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row g-3">

                            <label for="orgstdcode" class="form-label">Telephone</label>
                             

                                    <div class="col-md-2">
                                        <label for="orgcountrydialcode" class="visually-hidden">Country Code</label>
                                        <input type="text" id="orgcountrydialcode" class="form-control @error('orgcountrydialcode') is-invalid @enderror" placeholder="{{ $selectedMinistry != 14 ? '+91':'Country Code'}}" wire:model="orgcountrydialcode" aria-describedby="orgcountrydialcode" {{ $selectedMinistry != 14 ? 'disabled':''}}>
                                        <div class="invalid-feedback">
                                            @error('orgcountrydialcode')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                              
                            
                            <div class="col-md-2">
                                <label for="stdCode" class="visually-hidden">Std Code</label>
                                <input type="text" class="form-control @error('orgstdcode') is-invalid @enderror"
                                    placeholder="STD Code" wire:model="orgstdcode" aria-describedby="stdcode"
                                    maxlength=4 minlength=2>

                                    
                                <div class="invalid-feedback">
                                    @error('orgstdcode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputPassword2" class="visually-hidden">Number</label>
                                <input type="text"
                                    class="form-control @error('orgTelehponeNo') is-invalid @enderror" maxlength=10
                                    minlength=4 aria-describedby="telnumber" placeholder="Telephone Number" wire:model="orgTelehponeNo">

                                <div class="invalid-feedback">
                                    @error('orgTelehponeNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row g-3">
                            <div class="col-md-4">
                                <label for="orginputMobile" class="form-label">Mobile No</label>
                                <input type="text" class="form-control @error('orgmobileNo') is-invalid @enderror"
                                    placeholder="Enter Mobile No" minlength=10 wire:model="orgmobileNo">
                                <div class="invalid-feedback">
                                    @error('orgmobileNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="orginputEmail" class="form-label">Email Id</label>
                                <input type="text" class="form-control @error('orgemailid') is-invalid @enderror"
                                    placeholder="Enter Email" wire:model="orgemailid">
                                <div class="invalid-feedback">
                                    @error('orgemailid')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($currentStep == 3)
            <div class="step-three">
                <div class="card">
                    <div class="card-header bg-primary text-white shadow">
                        Step 3/6 (Administrative Contact)
                    </div>
                    <div class="card-body">

                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="adminName" class="form-label">Name</label>
                                <input type="text" class="form-control @error('adminName') is-invalid @enderror"
                                    placeholder="Enter Name" wire:model="adminName">

                                <div class="invalid-feedback">
                                    @error('adminName')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="adminDesignation" class="form-label">Designation</label>
                                <input type="text"
                                    class="form-control  @error('adminDesignation') is-invalid @enderror"
                                    placeholder="Enter Designation" wire:model="adminDesignation">
                                <div class="invalid-feedback">
                                    @error('adminDesignation')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="admininputAddress" class="form-label">Address</label>
                                <input type="text"
                                    class="form-control  @error('adminAddress1') is-invalid @enderror"
                                    placeholder="Enter Address" wire:model="adminAddress1">
                                <div class="invalid-feedback">
                                    @error('adminAddress1')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="admininputCity" class="form-label">City</label>
                                <input type="text" class="form-control @error('adminCity') is-invalid @enderror"
                                    placeholder="Enter City" wire:model="adminCity">
                                <div class="invalid-feedback">
                                    @error('adminCity')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="admininputState" class="form-label">State</label>
                                <select class="form-control @error('adminCity') is-invalid @enderror"
                                    wire:model="adminState">
                                    <option selected>Choose...</option>
                                    <option selected>Choose...</option>
                                    @foreach ($states as $state)
                                        <option>{{ $state->state_utname }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('adminState')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="admininputPincode" class="form-label">Pincode</label>
                                <input type="text"
                                    class="form-control @error('adminPincode') is-invalid @enderror"
                                    placeholder="Enter Pincode" wire:model="adminPincode" minlength=6>
                                <div class="invalid-feedback">
                                    @error('adminPincode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row g-3">

                            
                            <label for="adminstdcode" class="form-label">Telephone</label>

                                <div class="col-md-2">
                                    <label for="adminstdcode" class="visually-hidden">Country Code</label>
                                    <input type="text" id="adminstdcode" class="form-control @error('admincountrydialcode') is-invalid @enderror" placeholder="{{ $selectedMinistry != 14 ? '+91':'Country Code'}}"  wire:model="admincountrydialcode" aria-describedby="admincountrydialcode" {{ $selectedMinistry != 14 ? 'disabled':''}}>

                                    <div class="invalid-feedback">
                                        @error('admincountrydialcode')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                              
                            <div class="col-md-2">
                                <label for="stdCode" class="visually-hidden">Std Code</label>
                                <input type="text"
                                    class="form-control @error('adminstdcode') is-invalid @enderror"
                                    placeholder="STD Code" wire:model="adminstdcode" aria-describedby="stdcode"
                                    maxlength=4 minlength=2>
                                <div class="invalid-feedback">
                                    @error('adminstdcode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputPassword2" class="visually-hidden">Number</label>
                                <input type="text"
                                    class="form-control @error('adminTelehponeNo') is-invalid @enderror" maxlength=10
                                    minlength=4 aria-describedby="telnumber" wire:model="adminTelehponeNo">

                                <div class="invalid-feedback">
                                    @error('adminTelehponeNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="admininputMobile" class="form-label">Mobile No</label>
                                <input type="text"
                                    class="form-control @error('adminmobileNo') is-invalid @enderror"
                                    placeholder="Enter Mobile No" minlength=10 wire:model="adminmobileNo">
                                <div class="invalid-feedback">
                                    @error('adminmobileNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label for="admininputEmail" class="form-label">Email Id</label>
                                <input type="text"
                                    class="form-control @error('adminemailid') is-invalid @enderror"
                                    placeholder="Enter Email Id" wire:model="adminemailid">
                                <div class="invalid-feedback">
                                    @error('adminemailid')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($currentStep == 4)
            <div class="step-four">
                <div class="card">
                    <div class="card-header bg-primary text-white shadow">
                        Step 4/6 (Technical Contact)
                    </div>
                    <div class="card-body">

                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="orgName" class="form-label">Name</label>
                                <input type="text" class="form-control @error('techName') is-invalid @enderror"
                                    placeholder="Enter Name" wire:model="techName">
                                <div class="invalid-feedback">
                                    @error('techName')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="techDesignation" class="form-label">Designation</label>
                                <input type="text"
                                    class="form-control @error('techDesignation') is-invalid @enderror"
                                    placeholder="Enter Designation" wire:model="techDesignation">
                                <div class="invalid-feedback">
                                    @error('techDesignation')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="techinputAddress" class="form-label">Address</label>
                                <input type="text"
                                    class="form-control @error('techAddress1') is-invalid @enderror"
                                    placeholder="Enter Address" wire:model="techAddress1">
                                <div class="invalid-feedback">
                                    @error('techAddress1')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="techinputCity" class="form-label">City</label>
                                <input type="text" class="form-control @error('techCity') is-invalid @enderror"
                                    placeholder="Enter City" wire:model="techCity">
                                <div class="invalid-feedback">
                                    @error('techCity')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="techinputState" class="form-label">State</label>
                                <select class="form-control @error('techState') is-invalid @enderror"
                                    wire:model="techState">
                                    <option selected>Choose...</option>
                                    @foreach ($states as $state)
                                        <option>{{ $state->state_utname }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    @error('techState')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="techinputPincode" class="form-label">Pincode</label>
                                <input type="text" class="form-control @error('techPincode') is-invalid @enderror"
                                    wire:model="techPincode" placeholder="Enter Pincode" minlength=6>
                                <div class="invalid-feedback">
                                    @error('techPincode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row g-3">
                            <label for="techstdcode" class="form-label">Telephone</label>

                            <div class="col-md-2">
                                    <label for="techcountrydialcode" class="visually-hidden">Country Code</label>
                                    <input type="text" id="techstdcode" class="form-control @error('techcountrydialcode') is-invalid @enderror"  placeholder="{{ $selectedMinistry != 14 ? '+91':'Country Code'}}" wire:model="techcountrydialcode" aria-describedby="techcountrydialcode" {{ $selectedMinistry != 14 ? 'disabled':''}}>
                                       
                                    <div class="invalid-feedback">
                                        @error('techcountrydialcode')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            <div class="col-md-2">
                                <label for="stdCode" class="visually-hidden">Std Code</label>
                                <input type="text" class="form-control @error('techstdcode') is-invalid @enderror"
                                    placeholder="STD Code" wire:model="techstdcode" aria-describedby="stdcode"
                                    maxlength=4 minlength=2>
                                <div class="invalid-feedback">
                                    @error('techstdcode')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="inputPassword2" class="visually-hidden">Number</label>
                                <input type="text"
                                    class="form-control @error('techTelehponeNo') is-invalid @enderror" maxlength=10
                                    minlength=4 aria-describedby="telnumber" wire:model="techTelehponeNo">

                                <div class="invalid-feedback">
                                    @error('techTelehponeNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row g-3">
                            <div class="col-md-6">
                                <label for="techinputMobile" class="form-label">Mobile No</label>
                                <input type="text"
                                    class="form-control @error('techmobileNo') is-invalid @enderror"
                                    placeholder="Enter Mobile No" wire:model="techmobileNo" minlength=10>
                                <div class="invalid-feedback">
                                    @error('techmobileNo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="techinputEmail" class="form-label">Email Id</label>
                                <input type="text"
                                    class="form-control  @error('techEmailid') is-invalid @enderror"
                                    placeholder="Enter Email Id" wire:model="techEmailid">
                                <div class="invalid-feedback">
                                    @error('techEmailid')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($currentStep == 5)
            <div class="col-lg-12 step-four">
                <div class="card">
                    <div class="card-header bg-primary text-white shadow">
                        Step 5/6 (Nameserver Details)
                    </div>
                    <div class="card-body">
                        <div class="card-body row g-3">

                            <div class="col-12">
                                <div class="form-check form-switch ps-0">
                                  <input class="form-check-input ms-auto" type="checkbox" checked="" wire:model.live="isChecked">
                                  <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">  NIC Hosted Nameservers</label>
                                 </div>
                            </div>


                            @if(!$isChecked)
                                <div class="col-12">
                                    @foreach ($multipleip as $index => $entry)
                                        <div class="row my-2 nameserverGroup">
                                            <div class="col">
                                                <input type="text"
                                                    wire:model="multipleip.{{ $index }}.nshostname"
                                                    placeholder="Hostname for IP "
                                                    class="form-control hostnameClass @error('multipleip.*') is-invalid @enderror"
                                                    placeholder="Nameserver 1" aria-label="Nameserver 1">
                                            </div>
                                            <div class="col mappedip-group">
                                                <input type="text" wire:model="multipleip.{{ $index }}.ip"
                                                    placeholder="IP Address for IP " class="form-control ipClass"
                                                    placeholder="IP of Nameserver">

                                            </div>
                                            @if ($index >= 2)
                                                <div class="col">
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-button"
                                                        wire:click="removeEntry({{ $index }})">Remove</button>
                                                </div>
                                            @else
                                                <div class="col"></div>
                                            @endif
                                        </div>
                                    @endforeach

                                    @error('multipleip.*')
                                        <div class="alert alert-danger"> {{ $message }} </div>
                                    @enderror

                                    @if (count($multipleip) < 6)
                                        <div class="row my-2">
                                            <div class="col">
                                                <button type="button" wire:click="addEntry"
                                                    class="btn btn-dark btn-sm"> Add
                                                    Nameserver <i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!--Nic nameservers-->
                            @else
                                <div class="col-12">

                                    <input type="text" class="form-control my-2" placeholder="Nameserver 1"
                                        aria-label="Nameserver 1" value="ns1.nic.in" disabled>
                                    <input type="text" class="form-control my-2" placeholder="Nameserver 1"
                                        aria-label="Nameserver 2" value="ns2.nic.in" disabled>
                                    <input type="text" class="form-control my-2" placeholder="Nameserver 1"
                                        aria-label="Nameserver 3" value="ns7.nic.in" disabled>
                                    <input type="text" class="form-control my-2" placeholder="Nameserver 1"
                                        aria-label="Nameserver 4" value="ns10.nic.in" disabled>


                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @endif
        <div class="col-12 mt-4">


            @if ($currentStep >= 1 && $currentStep < 5)
                <button type="button" class="btn btn-dark " wire:click="increaseStep()">Next</button>
            @endif
            @if ($currentStep > 1 && $currentStep <= 5)
                <button type="button" class="btn btn-dark" wire:click="decreaseStep()">Back</button>
            @endif
            @if ($currentStep == 5)
                <button type="submit" class="btn btn-dark">Submit</button>
            @endif
        </div>


    </form>
</div>
@script
    <script>
        window.addEventListener('formSubmitted', (event) => {
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
                footer: '<a href="/user/domainregistration">Back to Dashboard</a>'

            }); // Show alert with the message
        });
    </script>
@endscript

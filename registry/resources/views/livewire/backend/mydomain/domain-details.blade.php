<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Domain Details</h1>
    </div>
    <div class="row">

        @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
    
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
       
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0 font-weight-semibold text-lg">Domain Information</h6>
                    <p class="text-sm mb-1">Here you can set preferences.</p>
                </div>
                <div class="card-body p-3">
                    <p class="text-sm mb-4">
                       Domain information
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span
                                class="text-secondary">Domain Name:</span> &nbsp; {{$data['domaindetails']->domainname ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Activation Date:</span> &nbsp; {{$data['domaindetails']->activation_date ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Status:</span> &nbsp; {{$data['domaindetails']->activation_status ?? "No Data"}} </li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Organisation Catgeory:</span> &nbsp; {{$data['domaindetails']->orgcateory ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Ministry:</span> &nbsp; {{$data['domaindetails']->ministry ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                            <span class="text-secondary">State:</span>&nbsp; {{$data['domaindetails']->state_utcode ?? "No Data"}}                             
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 col-9">
                            <h6 class="mb-0 font-weight-semibold text-lg">Letter Details</h6>
                            <p class="text-sm mb-1">Registration Letters</p>
                        </div>
                     
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="text-sm mb-4">
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm">
                            <span class="text-secondary">Annexture I:</span> &nbsp; Noah</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Annexture II:</span> &nbsp; Mclaren</li>
                    
            
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row mb-sm-0 mb-2">
                        <div class="col-md-8 col-9">
                            <h6 class="mb-0 font-weight-semibold text-lg">Nameserver Details</h6>
                            <p class="text-sm mb-0"></p>
                        </div>
                        <div class="col-md-4 col-3 text-end">
                            <a href="{{route('edit_nameserver',['domain'=>$data['domaindetails']->domainid])}}">
                            <button type="button" class="btn btn-white btn-icon px-2 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    @if(!empty($data['nameservers_current_data']) && is_array($data['nameservers_current_data']))
                        <ul class="list-group">                           
                        
                            @foreach($data['nameservers_current_data'] as $key=>$value) 

                            <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm">
                                <span class="text-secondary"></span> &nbsp; Noah</li>
                        
                            @endforeach                          
                        </ul>
                    @else
                    <div> No data</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 col-9">
                            <h6 class="mb-0 font-weight-semibold text-lg">Organisation Contact</h6>

                            @if($orgcontactCount == 1)
                              <p class="text-sm mb-1 mt-2 py-1 shadow-sm px-2 rounded-3 bg-warning text-dark">Pending With Admin <i class="fa-solid fa-stopwatch"></i></p>
                            @else
                              <p class="text-sm mb-1"></p>
                            @endif
                        </div>
                         @if(!empty($data['corgcontactdetails']))
                        <div class="col-md-4 col-3 text-end">
                            <a href="{{route('editcontactform',['id'=> $data['domaindetails']->companyid,'domain'=>$data['domaindetails']->domainid,'ctype'=>1])}}"><button type="button" class="btn btn-white btn-icon px-2 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button>
                           </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body p-3">
                  
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span
                                class="text-secondary">Name:</span> &nbsp; {{$data['corgcontactdetails']->c_name}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Adress:</span> &nbsp; {{$data['corgcontactdetails']->address1}} {{$data['corgcontactdetails']->address2}} {{$data['corgcontactdetails']->pincode}}{{$data['corgcontactdetails']->state}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Telephone:</span> &nbsp; {{$data['corgcontactdetails']->telephone}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Mobile:</span> &nbsp; {{$data['corgcontactdetails']->mobileno}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                            <span class="text-secondary">Email:</span>&nbsp; {{$data['corgcontactdetails']->email}}                             
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 col-9">
                            <h6 class="mb-0 font-weight-semibold text-lg">Administrative Contact</h6>
                            @if($admincontactCount == 1)
                            <p class="text-sm mb-1 mt-2 shadow-sm py-1 px-2 rounded-3 bg-warning text-dark">Pending with Admin <i class="fa-solid fa-stopwatch"></i></p>
                            @else
                            <p class="text-sm mb-1"></p>
                            @endif
                        </div>
                        @if(!empty($data['admincontactDetails']))
                        <div class="col-md-4 col-3 text-end">
                            <a href="{{route('editcontactform',['id'=> $data['domaindetails']->adminid,'domain'=>$data['domaindetails']->domainid,'ctype'=>2])}}" target="_blank"><button type="button" class="btn btn-white btn-icon px-2 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </button></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body p-3">
                   
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span
                                class="text-secondary">Name:</span> &nbsp; {{$data['admincontactDetails']->c_name ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Adress:</span> &nbsp; {{$data['admincontactDetails']->address1 ?? "No Data"}} {{$data['admincontactDetails']->address2 ?? ""}} {{$data['admincontactDetails']->pincode ?? "No Data"}}{{$data['admincontactDetails']->state ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Telephone:</span> &nbsp; {{$data['admincontactDetails']->telephone ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Mobile:</span> &nbsp; {{$data['admincontactDetails']->mobileno ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                            <span class="text-secondary">Email:</span>&nbsp; {{$data['admincontactDetails']->email ?? "No Data"}}                             
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border shadow-xs h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 col-9">
                            <h6 class="mb-0 font-weight-semibold text-lg">Technical Contact</h6>
                                @if($techcontactCount == 1)
                                  <p class="text-sm mb-1 shadow-sm mt-2 py-1 px-2 rounded-3 bg-warning text-dark">Pending with Admin <i class="fa-solid fa-stopwatch"></i></p>
                                @else
                                  <p class="text-sm mb-1"></p>
                                @endif
                        </div>
                        @if(!empty($data['techcontactDetails']))
                            <div class="col-md-4 col-3 text-end">
                                <a href="{{route('editcontactform',['id'=> $data['domaindetails']->techid,'domain'=>$data['domaindetails']->domainid,'ctype'=>3])}}" target="_blank"><button type="button" class="btn btn-white btn-icon px-2 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                    </svg>
                                </button></a>
                            </div> 
                        @endif
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="text-sm mb-4">
                       This contact is organisation contact person
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span
                                class="text-secondary">Name:</span> &nbsp; {{$data['techcontactDetails']->c_name ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Adress:</span> &nbsp; {{$data['techcontactDetails']->address1 ?? "No Data"}} {{$data['techcontactDetails']->address2 ?? ""}} {{$data['techcontactDetails']->pincode ?? "No Data"}}{{$data['techcontactDetails']->state_utcode ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Telephone:</span> &nbsp; {{$data['techcontactDetails']->telephone ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span
                                class="text-secondary">Mobile:</span> &nbsp; {{$data['techcontactDetails']->mobileno ?? "No Data"}}</li>
                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                            <span class="text-secondary">Email:</span>&nbsp; {{$data['techcontactDetails']->email ?? "No Data"}}                             
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
          <a href="{{route('my_domains')}}"><button type="button" class="btn btn-danger">Back</button></a>
        </div>
    </div>

</div>
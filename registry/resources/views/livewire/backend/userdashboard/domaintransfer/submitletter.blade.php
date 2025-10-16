@extends('layout.user-dashboard.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Submit Letter</h1>
         
        </div>

        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body mx-5">
                    <form>
                       
                        <div class="form-group row">
                          <label for="inputPassword" class="col-sm-2 col-form-label">Select Domain</label>
                          <div class="col-sm-10">
                            <select class="form-control">
                                <option> select domain</option>
                              </select>
                          </div>
                        </div>
                       <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Upload Letter</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
        
                        </div>
                       </div>
                     
                        <div class="form-group row">
                            <label for="submit" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                      </form>
                </div>
            </div>
        </div>
     </div>
 
@endsection
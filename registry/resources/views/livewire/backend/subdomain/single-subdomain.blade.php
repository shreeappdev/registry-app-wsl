<div class="card">
    <div class="card-body">
        <div class="form-group row g-3">
            <div class="col-md-6">
                <label for="Name" class="form-label">Name</label>
                <input type="text" id="Name" class="form-control" placeholder="Enter name">
            </div>
            <div class="col-md-6">
                <label for="Designation" class="form-label">Designation</label>
                <input type="text" id="Designation" class="form-control" placeholder="Enter designation">
            </div>
        </div>

        <div class="form-group row g-3">
            <div class="col-md-6">
                <label for="inputAddress1" class="form-label">Address</label>
                <input type="text" id="inputAddress1" class="form-control" placeholder="Enter Address">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" id="inputCity" class="form-control" placeholder="Enter City">
            </div>
        </div>

        <div class="form-group row g-3">
            <div class="col-md-6">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-control">
                    <option value="" selected>Choose...</option>
                    <option>Andhra Pradesh</option>
                    <option>Delhi</option>
                    <option>Maharashtra</option>
                    <option>Tamil Nadu</option>
                    <option>Karnataka</option>
                    <option>Uttar Pradesh</option>
                    <option>West Bengal</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="inputPincode" class="form-label">Pincode</label>
                <input type="text" id="inputPincode" class="form-control" placeholder="Enter Pincode" minlength="6" maxlength="6">
            </div>
        </div>

        <div class="form-group row g-3">
            <label for="StdCode" class="form-label">Telephone</label>
            <div class="col-md-2">
                <label for="countrydialcode" class="visually-hidden">Country Code</label>
                <input type="text" id="countrydialcode" class="form-control" placeholder="+91" value="+91" disabled>
            </div>
            <div class="col-md-2">
                <label for="stdCode" class="visually-hidden">Std Code</label>
                <input type="text" id="stdCode" class="form-control" placeholder="STD Code" maxlength="4" minlength="2">
            </div>
            <div class="col-md-4">
                <label for="telnumber" class="visually-hidden">Number</label>
                <input type="text" id="telnumber" class="form-control" placeholder="Telephone Number" maxlength="10" minlength="4">
            </div>
        </div>

        <div class="form-group row g-3">
            <div class="col-md-4">
                <label for="inputMobile" class="form-label">Mobile No</label>
                <input type="text" id="inputMobile" class="form-control" placeholder="Enter Mobile No" minlength="10" maxlength="10">
            </div>

            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email Id</label>
                <input type="email" id="inputEmail" class="form-control" placeholder="Enter Email">
            </div>
        </div>
    </div>
</div>

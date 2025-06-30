<form class="row needs-validation" method= "post" wire:submit.prevent="register" novalidate>
                       
    <div class="form-group row">
      <label for="inputSubdomain" class="col-sm-2 col-form-label">Select Domain</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" wire:model="subdomainname" value="" placeholder="Enter Domain name" id="inputSubdomain">
      </div>
    </div>
    <div class="form-group row">
        <label for="inputCname" class="col-sm-2 col-form-label">CNAME</label>
        <div class="col-sm-10">
          <input type="text" class="form-control"  wire:model="cname" value="" placeholder="Enter CNAME" id="inputCname">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputIp" class="col-sm-2 col-form-label">IP</label>
        <div class="col-sm-10">
            <input type="text" class="form-control"  wire:model="ipAddress" value="" placeholder="Enter CNAME" id="inputIp">
            <input type="text" class="form-control"  wire:model="ipAddress" value="" placeholder="Enter CNAME" id="inputIp">
            <input type="text" class="form-control"  wire:model="ipAddress" value="" placeholder="Enter CNAME" id="inputIp">
            <input type="text" class="form-control"  wire:model="ipAddress" value="" placeholder="Enter CNAME" id="inputIp">
            <input type="text" class="form-control"  wire:model="ipAddress" value="" placeholder="Enter CNAME" id="inputIp">
        </div>
    </div>
  
    <div class="form-group row">
        <label for="submit" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <button type="button" class="btn btn-success">
              
             
            Submit</button>
        </div>
    </div>
</form>
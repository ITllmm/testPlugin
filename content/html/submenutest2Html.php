<h1>modal</h1>

<div class="wrap" >
  <input type="submit" class="button-primary button" value="my-menu-test2-modal" name="my-menu-test2-modal" data-toggle="modal" data-target="#myModal">
  <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> -->
</div>

<!---start modal-->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-top: 200px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Withdraw My Balance</h5>
      </div>
      <div class="row modal-body">
        <div class="col-md-4">
         <label for="withdraw_amount">withdraw amount ($):</label>
        </div>
        <div class="col-md-6">
          <input type="number" min="100" max="1000" name="withdraw_amount" class="form-control" id="withdraw_amount" value="100">
          </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

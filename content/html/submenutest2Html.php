<div class="wrap" >
  <h1>Dedign own table</h1>
  <div style="width: 80%">
  <div>
      <table class="table">
       <thead>
         <tr>
           <th>Column Header #1</th>
           <th>Column Header #2</th>
         </tr>
       </thead>
       <tbody>
         <tr>
           <th>Row Header1</th>
           <td>I'm in a cell1</td>
         </tr>
         <tr>
           <th>Row Header2</th>
           <td>I'm in a cell2</td>
         </tr>
       </tbody>
    </table>
  </div>
    <div style="float:right">
       <ul class="pagination pagination-sm">
         <li class="active"><a href="#">&laquo;</a></li>
          <li class="hidden"><a href="#">1</a></li>
          <li class="active"><a href="#">2</a></li>
          <li class="active"><a href="#">3</a></li>
          <li class="hidden"><a href="#">4</a></li>
          <li class="active"><a href="#">5</a></li>
          <li class="active"><a href="#">&raquo;</a></li>
      </ul>
  </div>
  </div>
<br/>

<h1>modal</h1>
  <input type="submit" class="button-primary button" value="my-menu-test2-modal" name="my-menu-test2-modal" data-toggle="modal" data-target="#myModal">
  <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> -->
</div>

<h1>datepicker</h1>
<div>
<input type="text" class="datepicker" name="datepicker" value="" />
</div>

<h1>Tabs</h1>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Nunc tincidunt</a></li>
        <li><a href="#tabs-2">Proin dolor</a></li>
        <li><a href="#tabs-3">Aenean lacinia</a></li>
    </ul>
    <div id="tabs-1">
        <p>Tab 1 content.</p>
    </div>
    <div id="tabs-2">
        <p>Tab 2 content</p>
    </div>
    <div id="tabs-3">
        <p>Tab 3 content</p>
    </div>
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

<script>
jQuery(function() {

    jQuery( ".datepicker" ).datepicker({
        dateFormat : "dd-mm-yy"
    });

    jQuery('#tabs').tabs(); //$('#tabs').tabs() : error

});
</script>

<dir class="wrap">

    <h1>Site Manager Test</h1>
    <table class="table">
        <th>ID</th>
        <th>Site</th>
        <th>Sales Man(profit rate)</th>
        <th>ShopOwner(profit rate)</th>
        <th>Status</th>
        <?php echo $this->showTabledata()?>
    </table>
</dir>

<!---start modal set_profit-->
<form id='form_set_profit' action=<?php echo admin_url('network/admin.php?page=').$this->page_slug?> method="post">

          <input type="hidden" id="action_user" name="action_user">
          <input type="hidden" name="action" value="set_profit">
          <?php  wp_nonce_field('set_profit_test', $this->page_slug); ?>

    <div class="modal fade" id="setProfit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" style="margin-top: 200px">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Set Profit</h5>
          </div>
          <div class="row modal-body">

            <div class="col-md-4">
             <label style="float:right;margin-top: 3px;">Set Profit(%)</label>
            </div>
            <div class="col-md-6">
            <div class="col-md-8">
              <input type="number" min="0" max="100" name="profit_value" class="form-control" id="profit_value" value="10" step="0.01">
              </div>
              <div class="col-md-4">
                <span style="margin-left: -20px;line-height: 25px;">%</span>
              </div>
                    </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" > Submit</button>
          </div>
        </div>
      </div>
    </div>

</form>

<div>
    <input type="radio" name="vehicle" value="Car1" checked="checked" /> I have a car1
     <input type="radio" name="vehicle" value="Car2"  /> I have a car2
   <button type="submit" id="btn_submit"> submit </button>
</div>

<script type="text/javascript">

 jQuery(function($){ //如果需要用$来替代jQuery话，需要这里写个'$'

        $(".setProfit").click(function(){

            $('#action_user').val(this.id);
            $('#profit_value').val(jQuery(this).attr('value'));
            $("#setProfit").modal();

        });


   $("#btn_submit").click(function(){
　　　　alert($("input[name='vehicle']:radio:checked").val());
　　});

});

</script>
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

<div>
    <input type="radio" name="vehicle" value="Car1" checked="checked" /> I have a car1
     <input type="radio" name="vehicle" value="Car2"  /> I have a car2
   <button type="submit" id="btn_submit"> submit </button>
</div>

<script type="text/javascript">

 jQuery(function() {

   　jQuery("#btn_submit").click(function(){

　　　　alert(jQuery("input[name='vehicle']:radio:checked").val());
　　});

});

</script>
<div class="wrap">
    <h1>Saler Manager Test</h1>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Saler Login name</th>
        <th>Saler Email</th>
        <th>Saler Blogs(Sites)</th>
    </tr>
    <?php echo $this->showTabledata(); ?>
</table>

<h1> add  new salername </h1>
<form id="form_add_user" method='post' action=<?php echo admin_url('network/admin.php?page='.$this->pageSlug); ?> >
    <?php wp_nonce_field('add_saler', $this->pageSlug); ?>
    <div style="width: 50%">
    <div class="row" style="margin: 10px">
        <div class="col-md-3">Sales Man Login Name</div>
        <div class="col-md-6"><input type="text" name="saler_name" class="form-control" pattern=".{4,16}" required title="4 to 16 characters or digitals"></div>
    </div>

    <div class="row" style="margin: 10px">
        <div class="col-md-3">Sales Man Email</div>
        <div class="col-md-6"><input type="email" name="saler_email" class="form-control" required></div>
    </div>

    <div class="row" style="margin: 10px">
        <div class="col-md-3">Replace Existing Sales Man (email) (Optional)</div>
        <div class="col-md-6"><input type="email" name="old_saler_email" class="form-control" readonly onfocus="this.removeAttribute('readonly');"></div>
    </div>

    <div class="row" style="margin: 10px">
        <div class="col-md-6 col-md-offset-3">
            <input type="submit" name="confirm_new_saler" value="submit" class="btn btn-primary form-control">
        </div>
    </div>
    </div>
</form>

</div>
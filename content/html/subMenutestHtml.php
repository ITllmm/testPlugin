<div class='drap'>
    <h1>Sun Menu Test1</h1>
    <form action="<?php  echo admin_url('admin.php?page='.$this->pageSlug);?>" method="post">

        <input type='hidden' name='sub_menu_test1' value='sub_menu_test1'/>
        <input type='hidden' name='action' value='<?php  echo $this->pageSlug ; ?>'/>
        <?php wp_nonce_field('add-noncefield','_wpnonce_add-noncefield') ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">ID</th>
                    <td><input type="text" id="id_number" name="my-menu-test1-input1" value="<?php echo $testdata1??""; ?>"></td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td><input type="text" id="name" name="my-menu-test1-input2" value="<?php echo $testdata2??""; ?>"></td>
                    </tr>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" class="button-primary button" value="my-menu-test1-submit" name="my-menu-test1-submit">
        </p>
    </form>
</div>
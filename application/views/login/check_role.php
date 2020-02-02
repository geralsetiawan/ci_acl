<center>
<div class="row">
        <?php
          foreach($group as $row) {
        ?>
        <a href="<?php echo site_url('login/select_group/'.$row['id_user_group'].''); ?>">
        <div class="col-md-3">
          <label><?php echo $row['name']; ?></label><br>
          <i class="fa fa-user-circle fa-3x" aria-hidden="true"></i>
        </div>
        </a>
      <?php } ?>
</div> 
</center>
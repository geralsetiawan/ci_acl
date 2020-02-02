 <?php echo $form_open; 
 $readonly = '';
 if(isset($type) && $type == 'detail' ) {
    $readonly = 'readonly';
  }
 ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input <?php echo $readonly; ?> type="text" name="name" class="form-control" id="name" value="<?php echo set_value('name', isset($callback['name']) ? $callback['name'] : ''); ?>">
                  <div id="msg_name"></div>
                </div>
                <div class="form-group">
                <label for="varchar">Group</label>
                <br>
                 <?php
                 foreach($group as $row) {
                  $checked = FALSE;
                  if(isset($callback['id_user_group'])) {
                    $arr_user_group = explode(',', $callback['id_user_group']);
                    if (in_array($row['id_user_group'], $arr_user_group)) {
                      $checked = TRUE;
                    }
                  }
                  echo form_checkbox('id_user_group[]', $row['id_user_group'], $checked, $readonly) . $row['name'] . " ";

                 }
                 ?>
                  <div id="msg_id_user_group"></div>
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input <?php echo $readonly; ?> type="text" name="username" class="form-control" id="username" value="<?php echo set_value('username', isset($callback['username']) ? $callback['username'] : ''); ?>">
                  <div id="msg_username"></div>
                </div>
                <?php
                  $disabled = '';
                  if(isset($type) && $type == 'edit' || $type == 'create') {
                  if($this->uri->segment(2) == 'edit') {
                  $disabled = 'disabled';
                ?>
                <div class="form-group">
                  <a href="#" id="change_password" class="btn btn-primary"><i class="fa fa-lock"></i>
               Change Password</a>
                  <input type="hidden" name="status_password" id="status_password">
                </div>
                <?php } ?>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input <?php echo $disabled." ".$readonly; ?> type="password" name="password" class="form-control" id="password" value="<?php echo set_value('password', isset($callback['password']) ? $callback['password'] : ''); ?>">
                  <div id="msg_password"></div>
                </div>
                <div class="form-group">
                  <label for="conf_password">Confirm password</label>
                  <input <?php echo $disabled." ".$readonly; ?> type="password" name="conf_password" class="form-control" id="conf_password" value="<?php echo set_value('password', isset($callback['password']) ? $callback['password'] : ''); ?>">
                  <div id="msg_conf_password"></div>
                </div>
              <?php } ?>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                <?php
                if(isset($type) && $type == 'edit' || $type == 'create') {
                ?>
                &nbsp; 
                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>
                 Save</button>
                <?php  } ?>
              </div>
            <?php echo form_close(); ?>
  <script>
  $( document ).ready(function() {
    $("#change_password").click(function(event){
       event.preventDefault();
       $("#password").val('');
       $("#conf_password").val('');
       $("#status_password").val(1);
       $('.form-control').prop("disabled", false); // Element(s) are now enabled.
    });
    $('#form').submit(function(event){
        event.preventDefault();
        var me = $(this);
        var formData = new FormData($(this)[0]);
        $.ajax({
          url: me.attr('action'),
          type:'POST',
          data: formData,
          dataType: 'JSON',
          async: false,
          cache: false,
          contentType: false,
          processData: false,
          success:function(result){
            if (result['st'] == 0) {
              $('#msg_name').html(result.name);
              $('#msg_id_user_group').html(result.id_user_group);
              $('#msg_username').html(result.username);
              $('#msg_password').html(result.password);
              $('#msg_conf_password').html(result.conf_password);
            }
            else if (result['st'] == 1) {
              $("#myModal").modal('hide');
              reload_table();
            } else {
              alert(result);
            }    
         }
      });
    });
   
  });
  </script>
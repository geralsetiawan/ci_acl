<?php echo $form_open; ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" value="<?php echo set_value('name', isset($callback['name']) ? $callback['name'] : ''); ?>">
                  <div id="msg_name"></div>
                </div>
                <div class="form-group">
                  <label for="username">Description</label>
                  <textarea name="description" class="form-control"><?php echo isset($callback['description']) ? $callback['description']:''?></textarea>
                  <div id="msg_description"></div>
                </div>
              </div>
              <!-- /.box-body -->
             <div class="box-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                &nbsp; 
                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i>
                 Save</button>
              </div>
            <?php echo form_close(); ?>
  <script>
  $( document ).ready(function() {
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
              $('#msg_description').html(result.description);
            }
            else if (result['st'] == 1) {
              $("#myModal").modal('hide');
              reload_table();
            }  
         }
      });
    });
  });
  </script>
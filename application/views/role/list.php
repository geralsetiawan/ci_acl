<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datatable.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/switch/css/bootstrap-toggle.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/switch/js/bootstrap-toggle.min.js"></script>
 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <label>GROUP :</label> 
              <?php echo form_dropdown('id_user_group', $option_group, '' ,'id="id_user_group" style="width: 300px;" class="form-control select2"',''); ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="data-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <td>No</td>
                      <td>Menu Name</td>
                      <td>Read</td>
                      <td>Create</td>
                      <td>Update</td>
                      <td>Delete</td>
                  </tr>
                  <tr>
                      <th>No</th>
                      <th>Menu Name</th>
                      <th>Read</th>
                      <th>Create</th>
                      <th>Update</th>
                      <th>Delete</th>
                  </tr>
               </thead>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <script>
      $(document).ready(function() {
        $('#data-table thead td').each( function () {
            var title = $(this).text();
            if(title != 'No' && title != 'Create'  && title != 'Read'  && title != 'Update'  && title != 'Delete') { 
            var inp   = '<input type="text" class="form-control" placeholder="Search '+ title +'" />';
            $(this).html(inp);
            } else {
              var inp   = '';    
              $(this).html(inp);
            }      
        });
        var oTable = $('#data-table').DataTable({
                        "processing": false,
                        "serverSide": true,
                        "fnDrawCallback": function() {
                            $('input[type=checkbox]').bootstrapToggle();
                            $('input[type=checkbox]').change(function() { 
                                     var checked = $(this).prop('checked');
                                      var name = $(this).attr('name');
                                      var id_menu = $(this).attr('id_menu');
                                      var id_user_group = $("#id_user_group").val();
                                      if(checked == true) {
                                        var val = 1;
                                      } else {
                                        var val = 0;
                                      }
                                      $.ajax({
                                          url: "<?php echo site_url($this->router->fetch_class().'/update'); ?>",
                                          type:'POST',
                                           data: { 
                                            'checked': val, 
                                            'name': name,
                                            'id_menu': id_menu,
                                            'id_user_group' : id_user_group
                                        },
                                        dataType: 'JSON',
                                          success:function(result){
                                            if (result['st'] == 1) {
                                              alert('updated...') 
                                            }
                                         }
                                      });
                           })

                        },
                         "columnDefs": [
  
                                        { "sortable": false, "targets": 0 },
                                         { "sortable": false, "targets": 2 },
                                        { "sortable": false, "targets": 3 },
                                        { "sortable": false, "targets": 4 },
                                        { "sortable": false, "targets": 5 },
                                     

                                       ],
                                       // wajib dipakai jika ingin icon sorting column pertama hilang dan dimulai dari lanjutannya
                                        "order": [[ 0, "desc" ]], 
                        "ajax": {
                            "url": "<?php echo site_url($this->router->fetch_class().'/record');?>",
                            "type": "POST",
                            error: function (xhr, error, thrown) {
                                alert(xhr.responseText);
                                },  
                        }
                    });     
                    $("#data-table thead td input[type=text]").on( 'keyup change', function () {    
                        oTable
                            .column( $(this).parent().index()+':visible' )
                            .search( this.value )
                        .draw();                  
                    });

          $( "select#id_user_group" ).change(function() {
              oTable.search( this.value ).draw();
        });
      });
    </script>
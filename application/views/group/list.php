 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datatable.css">
 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php
               if($this->general->privilege_check(auth_id_menu(),"create")) {
              ?>
               <a href="#" onClick="add()" class="btn btn-primary"><i class="fa fa-plus"></i> Create New</a>
             <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="data-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <td width="10px">No</td>
                      <td>Name</td>
                      <td>Description</td>
                      <td>Action</td>
                  </tr>
                  <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Action</th>
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
       <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="title_modal"></h4>
          </div>
          <div class="modal-body">
            <div id="detail"></div>
          </div>
         
        </div>
      </div>
    </div>
    </section>
    <!-- /.content -->
    <script>
      $(document).ready(function() {
        $('#data-table thead td').each( function () {
            var title = $(this).text();
            if(title != 'Action' && title != 'No') { 
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
                         "columnDefs": [
                                        { "sortable": false, "targets": 3 }, 
                                        { "sortable": false, "targets": 0 }, // hapus sorting kolom no
                                        { "width": "15", "targets": 0 }

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

          $( "select" ).change(function() {
              oTable.search( this.value ).draw();
        });

      });
      function add()
      {
        $("#myModal").modal({backdrop: 'static', keyboard: false});
        $.ajax({
            url: "<?php echo site_url($this->router->fetch_class().'/create'); ?>",
            type: 'GET',
            success: function(res) {
                $("#detail").html(res);
                $("#title_modal").html('Create');
            }
        });
      }

      function edit(id)
      {
        $("#myModal").modal({backdrop: 'static', keyboard: false});
        url = "<?php echo site_url($this->router->fetch_class()); ?>/edit/";
        action = url+id;
         $.ajax({
            url: action,
            type: 'GET',
            success: function(res) {
                $("#detail").html(res);
                $("#title_modal").html('Edit');
            }
        });
      }

      function detail(id)
      {
        $("#myModal").modal({backdrop: 'static', keyboard: false});
        url = "<?php echo site_url($this->router->fetch_class()); ?>/detail/";
        action = url+id;
         $.ajax({
            url: action,
            type: 'GET',
            success: function(res) {
                $("#detail").html(res);
                $("#title_modal").html('Detail');
            }
        });
      }

      function reload_table()
      {
         $('#data-table').DataTable().ajax.reload();
      }
    </script>
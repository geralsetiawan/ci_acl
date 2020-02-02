 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datatable.css">
               <table id="data-table" class="table table-bordered table-striped">
                <thead>
                  <tr>
                  <?php
                      foreach($column as $key => $head) {
                       
                  ?>
                      <td><input type="text" class="form-control <?php echo $head['search']; ?>" placeholder="Search <?php echo $head['title']; ?>"></td>
                  <?php } ?>
                  </tr>
                  <tr>
                  <?php
                      foreach($column as $key => $head) {
                        
                  ?>
                      <th><?php echo $head['title']; ?></th>
                  <?php } ?>
                  </tr>
               </thead>
              </table>

    <script>

      $(document).ready(function() {
        $('#data-table thead td').each( function () {
            
        });
        var oTable = $('#data-table').DataTable({
                        "processing": false,
                        "serverSide": true,
                         "columnDefs": [
                                       
                                        { "sortable": false, "targets": 0 }, // hapus sorting kolom no
                                      

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

      });
      function popup()
      {
      	window.open("<?php echo site_url('user'); ?>", '_blank', '	location=no,directories-no,height=500,width=560,scrollbars=yes,status=yes'
      				);

      }
    </script>
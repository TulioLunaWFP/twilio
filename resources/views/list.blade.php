<!DOCTYPE html>
 
<html lang="en">
<head>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>CityHall</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
 
<div class="container">
<h2>CityHall</h2>
<br>
<a href="https://www.tutsmake.com/how-to-install-yajra-datatables-in-laravel/" class="btn btn-secondary">Back to Post</a>
<a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-customer">Add New</a>
<br><br>
 
<table class="table table-bordered table-striped" id="laravel_datatable">
   <thead>
      <tr>
         <th>ID</th>
         <th>FirstName</th>
         <th>LastName</th>
         <th>CellularPhone</th>
         <th>Email</th>
         <th>Action</th>
      </tr>
   </thead>
</table>
</div>
 
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="customerCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="customerForm" name="customerForm" class="form-horizontal">
           <input type="hidden" name="id" id="id">

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">FirstName</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter firstname" value="" maxlength="50" required="true">
                </div>
            </div>

             <div class="form-group">
                <label for="name" class="col-sm-2 control-label">LastName</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname" value="" maxlength="50" required="true">
                </div>
            </div>
                <label for="name" class="col-sm-2 control-label">celluarPhone</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="cellularphone" name="cellularphone" placeholder="Enter  cellularphone" value="" maxlength="50" required="true">
                </div>
            </div>
 
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-12">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required="">
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
             </button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        
    </div>
</div>
</div>
</div>
</body>

<script>
var SITEURL = '{{URL::to('')}}';
 $(document).ready( function () {
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#laravel_datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
          url: SITEURL + "ajax-crud-list",
          type: 'GET',
         },
         columns: [
                  {data: 'id', name: 'id', 'visible': false},
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                  { data: 'firstname', name: 'firstname' },
                  { data: 'lastname', name: 'lastname' },
                  { data: 'cellularphone', name: 'cellularphone' },
                  { data: 'email', name: 'email' },
                  {data: 'action', name: 'action', orderable: false},
               ],
        order: [[0, 'desc']]
      });
 /*  When user click add user button */
    $('#create-new-customer').click(function () {
        $('#btn-save').val("create-customer");
        $('#id').val('');
        $('#customerForm').trigger("reset");
        $('#customerCrudModal').html("Add New Customer");
        $('#ajax-crud-modal').modal('show');
    });
 
   /* When click edit user */
    $('body').on('click', '.edit-customer', function () {
      var id = $(this).data('id');
      $.get('ajax-crud-list/' + id +'/edit', function (data) {
         $('#name-error').hide();
         $('#email-error').hide();
         $('#customerCrudModal').html("Edit Customer");
          $('#btn-save').val("edit-customer");
          $('#ajax-crud-modal').modal('show');
          $('#id').val(data.id);
          $('#firstname').val(data.firstname);
          $('#lastname').val(data.lastname);
          $('#cellularphone').val(data.cellularphone);

          $('#email').val(data.email);
      })
   });
    $('body').on('click', '#delete-customer', function () {
 
        var id = $(this).data("id");
        confirm("Are You sure want to delete !");
 
        $.ajax({
            type: "get",
            url: SITEURL + "ajax-crud-list/delete/"+user_id,
            success: function (data) {
            var oTable = $('#laravel_datatable').dataTable(); 
            oTable.fnDraw(false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });   
   });
 
if ($("#customerForm").length > 0) {
      $("#customerForm").validate({
 
     submitHandler: function(form) {
 
      var actionType = $('#btn-save').val();
      $('#btn-save').html('Sending..');
      
      $.ajax({
          data: $('#customerForm').serialize(),
          url: SITEURL + "ajax-crud-list/store",
          type: "POST",
          dataType: 'json',
          success: function (data) {
 
              $('#customerForm').trigger("reset");
              $('#ajax-crud-modal').modal('hide');
              $('#btn-save').html('Save Changes');
              var oTable = $('#laravel_datatable').dataTable();
              oTable.fnDraw(false);
              
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }
  })
}
</script>





</html>

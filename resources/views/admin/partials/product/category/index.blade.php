@include('admin.layouts.header')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap4.min.css">
<style>
  
</style>
@endsection

<div class="content-wrapper">
  <div class="card">
    <div class="card-header" style="background-color: white">
      <div class="row">
        <div class="col-md-10">
          <h4 class="card-title">Category List</h4>
        </div>
        <div class="col-md-2">
          <a class="btn btn-primary" href="{{ route('category.addEdit') }}" >Add Category</a>
        </div>
      </div>
    </div>
    <div class="card-body datatable_class">
   
    <table id="example" class="table table-striped data-table table-bordered" style="width:100%">
      <thead>
          <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Parent Category</th>
            <th>Image</th>
            <th>Is Featured</th>
            <th>Status</th>
            <th width="100px">Action</th>
          </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Name</th>
          <th>Slug</th>
          <th>Parent Category</th>
          <th>Image</th>
          <th>Is Featured</th>
          <th>Status</th>
          <th width="100px">Action</th>
        </tr>
    </tfoot>
  </table>
    </div>
  </div>

</div>

@section('script')


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap4.min.js"></script>



    
<script type="text/javascript">
$(document).ready(function () {
    // $('#example').DataTPable();
    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          type: 'POST',
          ajax: 
          {
            "url":"{{ route('category') }}",
            "data":function(d){
                d.status = "dadsa";
            }
          },
          columns: [
              {data: 'name', name: 'name'},
              {data: 'slug', name: 'slug'},
              {data: 'parent_name', name: 'parent_name'},
              {data: 'image', name: 'image'},
              {data: 'is_featured', name: 'is_featured'},
              {data: 'status', name: 'status'},
              
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      
    });

});
    
  </script>
@endsection

@include('admin.layouts.footer')


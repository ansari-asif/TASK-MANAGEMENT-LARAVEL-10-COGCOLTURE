@extends('admin.layout.base_layout')
@section('links')
    @include('admin.incld.links.datatables')
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Task List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Task List</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  @include('admin.errors.error')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Task Id</th>
                  <th>Task Title</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Added On</th>
                  <th>Added By</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>#{{$task->id}} </td>
                            <td>{{$task->title}}</td>
                            <td>{{$task->description}}</td>
                            <td>{{$task->status}}</td>
                            <td>{{date("Y-m-d h:i:s A",strtotime($task->created_at))}} </td>
                            <td>{{$task->user->name}}</td>
                            <td>
                                <a href="{{ route('edit_task', ['id'=>$task->id]) }}" class="btn btn-md btn-primary ">Edit</a>
                                <a href="javascript:void(0)" data-id="{{$task->id}}" class="btn btn-md btn-danger delete_task_btn">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

         
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
@endsection

@section('scripts')
<script>
  $(function () {
    $("#table").DataTable({
      "responsive": true,"searching": true,
    });
  });

  $(document).ready(function () {
    $(document).on('click','.delete_task_btn',function(){
      console.log('clicked');
      var id=$(this).data('id');
      if(id){
        $.ajax({
          url:"{{route('delete_task')}}",
          method:"post",
          data:{id:id,_token:"{{csrf_token()}}"},
          dataType:"json",
          success:function(data){
            alert(data.message);
            if(data.status){
              window.location.reload();
            }
          }
        })
      }
    });
  });
</script>
@endsection

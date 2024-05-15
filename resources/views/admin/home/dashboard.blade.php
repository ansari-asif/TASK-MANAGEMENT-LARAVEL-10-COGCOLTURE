@extends('admin.layout.base_layout')
@section('links')
    @include('admin.incld.links.datatables')
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-striped table-bordered">
                <tr>
                    <th>Full Name</th>
                    <td>{{Auth::user()->name}} </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{Auth::user()->email}}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{Auth::user()->phone}}</td>
                </tr>
                <tr>
                    <th>User type</th>
                    <td>{{Auth::user()->user_type}}</td>
                </tr>
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


@extends('admin.layout.base_layout')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Task</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tasks') }}">Tasks</a></li>
            <li class="breadcrumb-item active">Edit Task</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    @include('admin.errors.error')
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-body" style="display: block;">
            <form action="{{ route('edit_task', ['id'=>$task->id]) }}" method="post">
                @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Task Title <span class="text-danger" >*</span></label>
                    <input type="text" id="title" class="form-control @error('title')
                        is-invalid
                    @enderror " name="title" value="{{old('title',$task->title??'')}}" placeholder="Enter Task Title">
                    <span id="exampleInputEmail1-error" class="error invalid-feedback">@error('title')
                        {{$message}}
                    @enderror</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status <span class="text-danger" >*</span></label>
                    <select id="status" class="form-control custom-select @error('status')
                    is-invalid
                    @enderror" name="status">
                      <option selected="" disabled="" value="">Select Status</option>
                      <option value="pending" 
                      {{ old('status',$task->status??'') == 'pending' ? 'selected' : '' }}
                      >Pending</option>
                      <option value="in-progress"
                      {{ old('status',$task->status??'') == 'in-progress' ? 'selected' : '' }}
                      >In-Progress</option>
                      <option value="completed"
                      {{ old('status',$task->status??'') == 'completed' ? 'selected' : '' }}
                      >Completed</option>
                    </select>
                    <span id="exampleInputEmail1-error" class="error invalid-feedback">@error('status')
                        {{$message}}
                    @enderror</span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="deadline">Deadline <span class="text-danger" >*</span></label>
                    <input type="date" id="deadline" class="form-control @error('deadline')
                    is-invalid
                @enderror " name="deadline" min="{{ date("Y-m-d") }}" value="{{old('deadline',$task->deadline??'')}}" placeholder="Enter Deadline">
                    <span id="exampleInputEmail1-error" class="error invalid-feedback">@error('deadline')
                        {{$message}}
                    @enderror</span>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description">Task Description <span class="text-danger" >*</span></label>
                    <textarea class="form-control @error('description')
                    is-invalid
                    @enderror" name="description" id="description" rows="3">{{old('description',$task->description??'')}}</textarea>
                    <span id="" class="error invalid-feedback">@error('description')
                        {{$message}}
                    @enderror</span>
                  </div>
                </div>  
              </div>  
              <div class="row">
                <div class="col-md-4 offset-md-5">
                  <button type="submit" class="btn btn-success">Update Task</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </section>
@endsection



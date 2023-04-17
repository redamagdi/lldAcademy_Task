@extends('adminlte::page')

@section('title', config('adminlte.title').' | '.__('auth.admins'))

@section('content')

      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">

          <div class="col-lg-12 col-md-12 col-sm-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ __('auth.list') }} {{ __('auth.admins') }}
                  </h3>
                  <div class="card-tools">
                    @if($roles->a=="1")<button class="btn btn-xs btn-success" data-toggle="modal" data-target="#addNew"><i class="fa fa-plus"></i> {{ __('auth.add') }}</button>@endif
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  @if($errors->any())
                      <div class="alert alert-danger col-lg-12 col-md-12 col-sm-12 alert-dismissible">
                          <i class="close fa fa-times" style="cursor:pointer;" data-dismiss="alert" aria-hidden="true"></i>
                          @foreach($errors->all() as $error)
                              <i class="fa fa-times"></i> &nbsp; {{$error}}<br>
                          @endforeach
                      </div>
                  @endif
          
                  @if(Session::has("success"))
                      <div class="alert alert-success col-lg-12 col-md-12 col-sm-12 alert-dismissible">
                          <i class="close fa fa-times" style="cursor:pointer;" data-dismiss="alert" aria-hidden="true"></i>
                          <i class="fa fa-check"></i> &nbsp; {{Session::get('success')}}
                          @php Session::forget('success'); @endphp
                      </div>
                  @endif

                  @if(Session::has("error"))
                <div class="alert alert-danger col-lg-12 col-md-12 col-sm-12 alert-dismissible">
                    <i class="close fa fa-times" style="cursor:pointer;" data-dismiss="alert" aria-hidden="true"></i>
                    <i class="fa fa-times"></i> &nbsp; {{Session::get('error')}}
                    @php Session::forget('error'); @endphp
                </div>
            @endif
                  
                  <div class="table-responsive text-nowrap">
                    <table id="example1" class="table table-bordered text-center">
                      <thead>
                        <tr>
                          <th style="width:10px">#</th>
                          <th>{{ __('auth.name') }}</th>
                          <th>{{ __('auth.job') }}</th>
                          <th>{{ __('auth.email') }}</th>
                          <th>{{ __('auth.phone') }}</th>
                          <th>{{ __('auth.actions') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($rows as $index => $r)
                        <tr @if($r->status=='0') style="background-color: red;" @endif>
                          <td>{{$index+1}}</td>
                          <td>{{$r->name}}</td>
                          <td>{{$r->email}}</td>
                          <td>{{$r->phone}}</td>
                          <td>@if(isset($r->getJob->name)){{$r->getJob->name}}@else - @endif</td>
                          <td>
                            @if($roles->e=="0"&&$roles->d=="0") <span class="badge badge-info">No Permissions</span> @endif
                            @if($roles->e=="1")<button data-rowid="{{$r->id}}" data-name="{{$r->name}}" data-email="{{$r->email}}" data-job="{{$r->job}}" data-status="{{$r->status}}" data-phone="{{$r->phone}}" class="btn btn-xs btn-warning editButton"><i class="fa fa-edit"></i> {{ __('auth.edit') }}</button>@endif
                            @if($roles->e=="1")<button data-rowid="{{$r->id}}" class="btn btn-xs btn-info resetButton"><i class="fa fa-eye"></i></button>@endif
                            @if($roles->d=="1")<button data-rowid="{{$r->id}}" data-username="{{$r->name}}" class="btn btn-xs btn-danger delButton"><i class="fa fa-times"></i> {{ __('auth.delete') }}</button>@endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

                @if($rows->hasPages())
                  @include('pagination', ['pages' => $rows])
                @endif

              </div>

          </div>

        </div>

      </div><!--/. container-fluid -->


<div class="modal fade" id="addNew">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('settings.regusers.save')}}" method="post">
            {{csrf_field()}}
            <div class="modal-header">
                <div class="modal-title">{{ __('auth.add') }}</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>{{ __('auth.name') }}:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('auth.name') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.passwordPlaceHolder') }}:</label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="{{ __('auth.passwordPlaceHolder') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.email') }}:</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="{{ __('auth.email') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.phone') }}:</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="{{ __('auth.phone') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.job') }}:</label>
                    <select class="form-control" name="job" id="{{ __('auth.job') }}" required >
                     <option value="">-- {{ __('auth.select') }} {{ __('auth.job') }} --</option>
                     @foreach($groups as $g)
                     <option value="{{$g->id}}">{{$g->name}}</option>
                     @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.status') }}:</label>
                    <select class="form-control" name="status" id="status" required >
                     <option value="">-- {{ __('auth.select') }} {{ __('auth.status') }} --</option>
                     <option value="1">Active</option>
                     <option value="0">Deactive</option>
                    </select>
                </div>
                

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('auth.cancel') }}</button>
                <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check"></i> {{ __('auth.add') }}</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="editForm">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('settings.regusers.update')}}" method="post">
            {{csrf_field()}}
            <div class="modal-header">
                <div class="modal-title">{{ __('auth.edit') }}</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="rowid" id="rowid" value="" required>
                <div class="form-group">
                    <label>{{ __('auth.name') }}:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('auth.name') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.email') }}:</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="{{ __('auth.email') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.phone') }}:</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="{{ __('auth.phone') }}" required>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.job') }}:</label>
                    <select class="form-control" name="job" id="job" required >
                     <option value="">-- {{ __('auth.select') }} {{ __('auth.job') }} --</option>
                     @foreach($groups as $g)
                     <option value="{{$g->id}}">{{$g->name}}</option>
                     @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('auth.status') }}:</label>
                    <select class="form-control" name="status" id="status" required >
                     <option value="">-- {{ __('auth.select') }} {{ __('auth.status') }} --</option>
                     <option value="1">Active</option>
                     <option value="0">Deactive</option>
                    </select>
                </div>
                

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('auth.cancel') }}</button>
                <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check"></i> {{ __('auth.edit') }}</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="deleteRow">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('settings.regusers.delete')}}" method="post">
            {{csrf_field()}}
            <div class="modal-header">
                <div class="modal-title">{{ __('auth.delete') }}</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="rowid" id="rowid" value="" required>
                <div class="form-group">
                    <label>{{ __('auth.deleteConfirm') }}:</label>
                    <h4 id="name"></h4>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('auth.cancel') }}</button>
                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-check"></i> {{ __('auth.confirm') }}</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="resetPasswordForm">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route('settings.regusers.resetPass')}}" method="post">
            {{csrf_field()}}
            <div class="modal-header">
                <div class="modal-title">{{ __('auth.reset') }} {{ __('auth.passwordPlaceHolder') }}</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="rowid" id="rowid" value="" required>
                <div class="form-group">
                  <lable>{{ __('auth.passwordPlaceHolder') }}</lable>
                  <input type="text" class="form-control" name="password" id="password" placeholder="{{ __('auth.passwordPlaceHolder') }}" required/>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('auth.cancel') }}</button>
                <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-check"></i> {{ __('auth.confirm') }}</button>
            </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

@stop

@section('js')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script>
      $(function () {
            $("#example1").DataTable({
                paging: false,
            "info": false,
            });
        });
        $(".editButton").on("click", function(){
            $("#editForm #rowid").val($(this).data("rowid"));
            $("#editForm #name").val($(this).data("name"));
            $("#editForm #email").val($(this).data("email"));
            $("#editForm #job").val($(this).data("job"));
            $("#editForm #phone").val($(this).data("phone"));
            $("#editForm #status").val($(this).data("status"));
            $("#editForm").modal("show");
        });
        $(".delButton").on("click", function(){
            $("#deleteRow #rowid").val($(this).data("rowid"));
            $("#deleteRow #username").text($(this).data("username"));
            $("#deleteRow").modal("show");
        });
        $(".resetButton").on("click", function(){
            $("#resetPasswordForm #rowid").val($(this).data("rowid"));
            $("#resetPasswordForm").modal("show");
        });
    </script>
@stop
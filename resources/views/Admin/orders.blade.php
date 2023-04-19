@extends('adminlte::page')

@section('title', config('adminlte.title').' | '.__('auth.orders'))

@section('content')

      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">

          <div class="col-lg-12 col-md-12 col-sm-12">

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    {{ __('auth.list') }} {{ __('auth.orders') }}
                  </h3>
                  <div class="card-tools">
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
                          <th>{{ __('auth.user') }}</th>
                          <th>{{ __('auth.product') }}</th>
                          <th>{{ __('auth.price') }}</th>
                          <th>{{ __('auth.amount') }}</th>
                          <th>{{ __('auth.total') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($rows as $index => $r)
                        <tr>
                          <td>{{$index+1}}</td>
                          <td>{{$r->getUser->name}}</td>
                          <td>{{$r->getProduct->name}}</td>
                          <td>{{$r->price}}</td>
                          <td>{{$r->amount}}</td>
                          <td>{{$r->total}}</td>
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
       
    </script>
@stop
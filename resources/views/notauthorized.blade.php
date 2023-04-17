@extends('adminlte::page')

@section('title', 'Octopusta | Not Authorized')

@section('content_header')
    <h1>Not Authorized</h1>
@stop

@section('content')

<div class="container-fluid">

    <!-- Info boxes -->
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Not Authorized Access</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <br><br><br>
                <div class="error-page">
                    <h2 class="headline text-danger"><i class="fa fa-flushed"></i></h2>
                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops!</h3>
                        <p>you are not authorized to view this page.</p>
                        <p>Please <a href="{{url()->previous()}}">click here to go back</a></p>
                    </div>
                </div>
                <br><br><br>
              </div>
              <!-- /.card-body -->
            </div>
        
        </div>

    </div>

</div><!--/. container-fluid -->

@stop

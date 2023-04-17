@extends('adminlte::page')

@section('title', config('adminlte.title').' | '.__('auth.dashboard'))

@section('content_header')
    <h1>{{__('auth.dashboard')}}</h1> 
@stop

@section('content')

      <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-fw fa-sitemap"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">{{__('auth.users')}}</span>
                  <span class="info-box-number">{{number_format($packa)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-fw fa-edit"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Categories</span>
                  <span class="info-box-number">{{number_format($bouqu)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-fw fa-chart-line"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Products</span>
                  <span class="info-box-number">{{number_format($lines)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-fw fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Orders</span>
                  <span class="info-box-number">{{number_format($users)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
      </div><!--/. container-fluid -->

@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/system4.css')}}">
@stop
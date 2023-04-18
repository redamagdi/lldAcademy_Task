@extends('adminlte::page')

@section('title', config('adminlte.title').' | Groups & Privileges')

@section('content')

<div class="container-fluid">

    <!-- Info boxes -->
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">

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

            @if(isset($job))
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('auth.menuSection') }}</h3>
                <div class="card-tools">
                    @if(isset($job))<a href="{{route('settings.previliges.index')}}"><button class="btn btn-xs btn-success"><i class="fa fa-user-cog"></i> {{ __('auth.backToGroups') }}</button></a>@endif
                </div>
              </div>
              <div class="card-body p-1">
                <div class="row">
                  <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        @foreach($pages as $index => $p)
                        <a class="nav-link text-dark @if($index==0){{'active'}}@endif" id="tabs-{{str_replace(' ', '-', $p->section)}}-tab" data-toggle="pill" href="#tabs-{{str_replace(' ', '-', $p->section)}}" role="tab" aria-controls="tabs-{{str_replace(' ', '-', $p->section)}}" aria-selected="@if($index==0){{'true'}}@else{{'false'}}@endif">{{$p->section}}</a>
                        @endforeach
                    </div>
                  </div>
                  <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                      @foreach($pages as $index => $p)
                      <div class="tab-pane fade @if($index==0) show active @endif" id="tabs-{{str_replace(' ', '-', $p->section)}}" role="tabpanel" aria-labelledby="tabs-{{str_replace(' ', '-', $p->section)}}-tab">
                        @if(empty($p->pages))
                        <div class="d-flex justify-content-center align-items-center" style="height:200px;">
                            <div class="badge badge-danger">There is no pages in this section</div>
                        </div>
                        @else
                        <div class="table-responsive text-nowrap">
                          <table class="table table-bordered text-center">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>{{ __('auth.title') }}</th>
                                <th>{{ __('auth.permissions') }}</th>
                                <th style="width:160px;">{{ __('auth.actions') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($p->pages as $k => $r)
                              <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$r['name']}}</td>
                                <td>
                                @if(empty($r['previliges']))
                                  <span class="badge badge-danger"><i class="fa fa-exclamation-triangle"></i> {{ __('auth.noPermisionYet') }}</span>
                                @elseif($r['route']=="system")
                                  <span class="badge badge-@if($r['previliges']['v']=='1'){{'success'}}@else{{'danger'}}@endif">All Data</span>
                                  <span class="badge badge-@if($r['previliges']['a']=='1'){{'success'}}@else{{'danger'}}@endif">Branch Data</span>
                                  <span class="badge badge-@if($r['previliges']['e']=='1'){{'success'}}@else{{'danger'}}@endif">Personal Data</span>
                                @else
                                  <span class="badge badge-@if($r['previliges']['v']=='1'){{'success'}}@else{{'danger'}}@endif">{{ __('auth.view') }}</span>
                                  <span class="badge badge-@if($r['previliges']['a']=='1'){{'success'}}@else{{'danger'}}@endif">{{ __('auth.add') }}</span>
                                  <span class="badge badge-@if($r['previliges']['e']=='1'){{'success'}}@else{{'danger'}}@endif">{{ __('auth.edit') }}</span>
                                  <span class="badge badge-@if($r['previliges']['d']=='1'){{'success'}}@else{{'danger'}}@endif">{{ __('auth.delete') }}</span>
                                @endif
                                </td>
                                <td>
                                  @if($roles->a=="0") <span class="badge badge-info">{{ __('auth.noPermission') }}</span> @endif
                                  @if($roles->a=="1")
                                      @if(empty($r['previliges']))
                                      <button class="btn btn-xs btn-warning editButton" data-route="{{$r['route']}}" data-page="{{$r['name']}}" data-categories="{{ $job->getCategoriesIDS() }}" data-jobid="{{$job->id}}" data-jobtitle="{{$job->name}}" data-view="" data-add="" data-edit="" data-delete=""><i class="fa fa-edit"></i> {{ __('auth.edit') }}</button>
                                      @else
                                      <button class="btn btn-xs btn-warning editButton" data-route="{{$r['route']}}" data-page="{{$r['name']}}" data-categories="{{ $job->getCategoriesIDS() }}" data-jobid="{{$job->id}}" data-jobtitle="{{$job->name}}" data-view="{{$r['previliges']['v']}}" data-add="{{$r['previliges']['a']}}" data-edit="{{$r['previliges']['e']}}" data-delete="{{$r['previliges']['d']}}"><i class="fa fa-edit"></i> {{__('auth.edit')}}</button>
                                      @endif
                                  @endif
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        @endif
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            @else
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Groups {{ __('auth.list') }}</h3>
                <div class="card-tools">
                  @if($roles->a=="1")<button class="btn btn-xs btn-success" data-toggle="modal" data-target="#addNew"><i class="fa fa-plus"></i> {{ __('auth.add') }}</button>@endif
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if(count($jobs)==0)
                <br><br><br>
                <div class="error-page">
                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops!</h3>
                        <p>{{ __('auth.noDataToShow') }}</p>
                    </div>
                </div>
                <br><br><br>
                @else
                <div class="table-responsive text-nowrap">
                  <table id="example1" class="table table-bordered text-center">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>{{ __('auth.name') }}</th>
                        <th>{{ __('auth.actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($jobs as $index => $job)
                      <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$job->name}}</td>
                        <td>
                          @if($roles->a=="0") <span class="badge badge-info">{{ __('auth.noPermission') }}</span> @endif
                          @if($roles->a=="1") <a href="{{route('settings.previliges.job', $job->id)}}"><button class="btn btn-xs btn-info"><i class="fa fa-edit"></i> {{ __('auth.permissions') }} </button></a> @endif
                          @if($roles->e=="1")<button data-rowid="{{$job->id}}" data-name="{{$job->name}}" class="btn btn-xs btn-warning editOriginButton"><i class="fa fa-edit"></i> {{ __('auth.edit') }}</button>@endif
                          @if($roles->d=="1")<button data-rowid="{{$job->id}}" data-name="{{$job->name}}" class="btn btn-xs btn-danger delButton"><i class="fa fa-times"></i> {{ __('auth.delete') }}</button>@endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @endif
              </div>
              <!-- /.card-body -->

            </div>
            @endif
        
        </div>

    </div>

</div><!--/. container-fluid -->

<div class="modal fade" id="system">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('settings.previliges.update')}}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                <div class="modal-title"> {{ __('auth.edit') }} <span id="jobtitle"></span> {{ __('permissions') }}</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="route" id="route" required>
                    <input type="hidden" name="jobid" id="jobid" required>
                    <div class="form-group">
                        <label> {{ __('auth.permissions') }} :</label>
                        <input type="text" class="form-control" name="page" id="page" readonly>
                    </div>
                    <div class="row m-0">
                        <input type="hidden" name="view" value="0">
                        <input type="hidden" name="add" value="0">
                        <input type="hidden" name="edit" value="0">
                        <input type="hidden" name="delete" value="0">
                        <div class="form-radio col">
                            <input style="cursor:pointer;" class="form-radio-input" type="radio" name="system" id="all" value="all">
                            <label style="cursor:pointer;" class="form-radio-label" for="all"> All Data</label>
                        </div>
                        <div class="form-radio col">
                            <input style="cursor:pointer;" class="form-radio-input" type="radio" name="system" id="branch" value="branch">
                            <label style="cursor:pointer;" class="form-radio-label" for="branch"> Branch Data</label>
                        </div>
                        <div class="form-radio col">
                            <input style="cursor:pointer;" class="form-radio-input" type="radio" name="system" id="personal" value="personal">
                            <label style="cursor:pointer;" class="form-radio-label" for="personal"> Personal Data</label>
                        </div>
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

<div class="modal fade" id="editForm">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('settings.previliges.update')}}" method="post">
            {{csrf_field()}}
            <div class="modal-header">
                <div class="modal-title">{{ __('auth.edit') }} <span id="jobtitle"></span> {{ __('auth.permissions') }}</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="route" id="route" required>
                <input type="hidden" name="jobid" id="jobid" required>
                <div class="form-group">
                    <label>{{ __('auth.permissionForPage') }} :</label>
                    <input type="text" class="form-control" name="page" id="page" readonly>
                </div>
                <div class="form-group">
                    <label> {{ __('auth.view') }} :</label>
                    <select class="form-control" onchange="setView(this.value)" name="view" id="view" required>
                        <option value=""> - {{ __('auth.select') }} {{ __('auth.status') }} -</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div id="extras">  
                    @if($categories)
                        <div class="form-group" id="categoriesBox" style="display: none;">
                            <label>{{ __('auth.categories') }}:</label>
                            <select class="form-control" multiple name="categories[]" id="categories">
                                <option value=""> - {{ __('auth.select') }} {{ __('auth.categories') }} -</option>
                                @foreach($categories as $ca)
                                    <option value="{{$ca->id}}">{{$ca->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>{{ __('auth.add') }}:</label>
                        <select class="form-control" name="add" id="add" required>
                            <option value=""> - {{ __('auth.select') }} {{ __('auth.status') }} -</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ __('auth.edit') }} :</label>
                        <select class="form-control" name="edit" id="edit" required>
                            <option value=""> - {{ __('auth.select') }} {{ __('auth.status') }} -</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ __('auth.delete') }} :</label>
                        <select class="form-control" name="delete" id="delete" required>
                            <option value=""> - {{ __('auth.select') }} {{ __('auth.status') }} -</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

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

<div class="modal fade" id="addNew">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('settings.job.save')}}" method="post">
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

<div class="modal fade" id="editOriginForm">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('settings.job.update')}}" method="post">
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
        <form action="{{route('settings.job.delete')}}" method="post">
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
        
        function setView(view){
            if(view==0){
                $("#editForm #extras").slideUp(function(){
                    $("#editForm #add").val(0);
                    $("#editForm #edit").val(0);
                    $("#editForm #delete").val(0);
                });
            }else{
                $("#editForm #extras").slideDown();
            }
        }
        $(".editButton").on("click", function(){
            let form = "editForm";
            let route = $(this).data("route");
            let pageName = $(this).data("page");
            let categories = $(this).data("categories");
            if(route=="system"){
                form = "system";
                $("#system #all").attr("checked", $(this).data("view")==1);
                $("#system #branch").attr("checked", $(this).data("add")==1);
                $("#system #personal").attr("checked", $(this).data("edit")==1);
            }else{
                $("#editForm #view").val($(this).data("view"));
                $("#editForm #add").val($(this).data("add"));
                $("#editForm #edit").val($(this).data("edit"));
                $("#editForm #delete").val($(this).data("delete"));
                if($(this).data("view")==0){
                    $("#editForm #extras").hide();
                    $("#editForm #categories").val("");
                }else{
                    $("#editForm #extras").show();
                    if(pageName=="التصنيفات"||pageName=="Categories"){
                        $("#editForm #categoriesBox").css('display','block');
                        $("#editForm #categories").val(categories);
                    }else{
                        $("#editForm #categoriesBox").css('display','none');
                        $("#editForm #categories").val("");
                    }
                }
            }
            $("#"+form+" #route").val(route);
            $("#"+form+" #page").val($(this).data("page"));
            $("#"+form+" #jobid").val($(this).data("jobid"));
            $("#"+form+" #jobtitle").text($(this).data("jobtitle"));
            $("#"+form).modal("show");
        });

        $(".editOriginButton").on("click", function(){
            $("#editOriginForm #rowid").val($(this).data("rowid"));
            $("#editOriginForm #name").val($(this).data("name"));
            $("#editOriginForm").modal("show");
        });
        $(".delButton").on("click", function(){
            $("#deleteRow #rowid").val($(this).data("rowid"));
            $("#deleteRow #username").text($(this).data("name"));
            $("#deleteRow").modal("show");
        });
    </script>
@stop
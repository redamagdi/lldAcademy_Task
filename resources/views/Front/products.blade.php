<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">


        <title>{{ config('adminlte.title') }} - {{__('auth.products')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('front/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('front/css/style.css')}}" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />

    </head>
    <body>
        <div class="container bootdey">
            <!-- right side  -->
            <div class="col-md-3">
                <section class="panel">
                    <header class="panel-heading">
                        Category
                    </header>

                    <div class="panel-body">
                        <ul class="nav prod-cat">
                            @foreach($categories as $ca)
                            <li>
                                <a href="{{route('userProducts',$ca->id)}}" @if($category_id==$ca->id) class="active" @endif >
                                  <i class="fa fa-angle-right"></i> {{$ca->name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </section>
            </div>
            <!-- End of right side  -->

            <div class="col-md-9">
                <!-- header  -->
                <section class="panel">
                    <div class="panel-body">
                        <h4 style="display: inline;"> Products </h4>
                        <a class="pull-right" href="{{route('logout')}}" style="display: inline;"> Logout </a>
                    </div>
                </section>
                <!-- End of header  -->
                
                <!-- products  -->
                <div class="row product-list">

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
                    
                    @foreach($rows as $r)
                        <div class="col-md-4">
                            <section class="panel">
                                <div class="pro-img-box">
                                    <img src="https://www.bootdey.com/image/250x220/FFB6C1/000000" alt />
                                    <a type="button" data-rowid="{{$r->id}}" data-description="{{$r->description}}" data-price="{{$r->price}}" class="payButton adtocart">
                                      <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>

                                <div class="panel-body text-center">
                                    <h4> <a href="#" class="pro-title"> {{$r->name}} </a> </h4>
                                    <p class="price">{{$r->price}}</p>
                                </div>

                            </section>
                        </div>
                    @endforeach

                </div>
                <!-- End of products products  -->

            </div>

        </div>

        <!-- paying modal  -->
        <div class="modal fade" id="addNew">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('userProducts.save')}}" method="post">
                    {{csrf_field()}}
                    
                    <div class="modal-header">
                        <div class="modal-title">Add Amount</div>
                        
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="rowid" id="rowid" value="" required>

                        <div class="form-group">
                            <label>Unit Price:</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="unit Price" readonly>
                        </div>

                        <div class="form-group">
                            <label>Amount:</label>
                            <input type="text" class="form-control" name="amount" id="amount" placeholder="amount" required >
                        </div>

                        <div class="form-group">
                           <h6 class="text-center" style="color: red;" id="description"></h6>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Pay</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(".payButton").on("click", function(){
                $("#addNew #rowid").val($(this).data("rowid"));
                $("#addNew #price").val($(this).data("price"));
                $("#addNew #description").text($(this).data("description"));
                $("#addNew").modal("show");
            });
        </script>
    </body>
</html>
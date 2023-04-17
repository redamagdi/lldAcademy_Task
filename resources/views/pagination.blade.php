              <div class="card-footer clearfix">
                <span class="float-left">
                    Current Page: <b>{{$pages->currentPage()}}</b> of {{$pages->lastPage()}}
                </span>
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="{{$pages->url(1)}}">1</a></li>
                    @if($pages->lastPage()>=2)
                    <li class="page-item"><a class="page-link" href="{{$pages->url(2)}}">2</a></li>
                    @endif
                    @if($pages->lastPage()>=3)
                    <li class="page-item"><a class="page-link" href="{{$pages->url(3)}}">3</a></li>
                    @endif
                    @if(($pages->currentPage()<4&&$pages->lastPage()>4)||$pages->currentPage()>6)
                    <li class="page-item"><a class="page-link" href="javascript:void(0)">....</a></li>
                    @endif
                    @if($pages->currentPage()>=4)
                    @if($pages->currentPage()>5)<li class="page-item"><a class="page-link" href="{{$pages->url($pages->currentPage()-2)}}">{{$pages->currentPage()-2}}</a></li>@endif
                    @if($pages->currentPage()>4)<li class="page-item"><a class="page-link" href="{{$pages->url($pages->currentPage()-1)}}">{{$pages->currentPage()-1}}</a></li>@endif
                    <li class="page-item"><a class="page-link" href="javascript:void(0)">{{$pages->currentPage()}}</a></li>
                    @if($pages->currentPage()+1<$pages->lastPage())<li class="page-item"><a class="page-link" href="{{$pages->url($pages->currentPage()+1)}}">{{$pages->currentPage()+1}}</a></li>@endif
                    @if($pages->currentPage()+2<$pages->lastPage())<li class="page-item"><a class="page-link" href="{{$pages->url($pages->currentPage()+2)}}">{{$pages->currentPage()+2}}</a></li>@endif
                    @if($pages->currentPage()<=$pages->lastPage()-2)<li class="page-item"><a class="page-link" href="javascript:void(0)">....</a></li>@endif
                    @endif
                    @if($pages->currentPage()<$pages->lastPage()-2&&$pages->lastPage()>9)
                    <li class="page-item"><a class="page-link" href="{{$pages->url($pages->lastPage()-1)}}">{{$pages->lastPage()-1}}</a></li>
                    <li class="page-item"><a class="page-link" href="{{$pages->url($pages->lastPage())}}">{{$pages->lastPage()}}</a></li>
                    @endif
                </ul>
                <ul class="pagination pagination-sm m-0 mr-3 float-right">
                    <li class="page-item"><a class="page-link" href="@if($pages->onFirstPage()){{'javascript:void(0)'}}@else{{$pages->previousPageUrl()}}@endif">&laquo; Prev</a></li>
                    <li class="page-item"><a class="page-link" href="@if($pages->lastPage()==$pages->currentPage()){{'javascript:void(0)'}}@else{{$pages->nextPageUrl()}}@endif">Next &raquo;</a></li>
                </ul>
              </div>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        {{-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> --}}
        <a class="navbar-brand" href="{{route('giangvien.danhsach')}}" style="color: #1A91EA; font-size: 18px;">QUẢN LÝ LUẬN VĂN TỐT NGHIỆP</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        @if(Session::has('login1') && Session::get('login1')==true)
        <li><a href="" data-toggle="modal" id="abc" data-target="#giangvien"><i class="fa fa-user fa-fw"></i> {{Session::get('name1')}}</a></li>
        <div class="modal fade" id="giangvien" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{Session::get('name1')}}</h4>
                        @if($errors-> has('matkhaucu'))
                            @foreach($errors->get('matkhaucu') as $err)
                                <span style="color:red;">{{$err}}</span><br>
                            @endforeach
                        @endif
                        @if($errors-> has('matkhaumoi'))
                            @foreach($errors->get('matkhaumoi') as $err)
                                <span style="color:red;">{{$err}}</span><br>
                            @endforeach
                        @endif
                        @if($errors-> has('nhaplaimatkhau'))
                            @foreach($errors->get('nhaplaimatkhau') as $err)
                                <span style="color:red;">{{$err}}</span><br>
                            @endforeach
                        @endif
                        @if(session('thongbao1'))
                            <span style="color:red;">{{session('thongbao1')}}</span>
                        @endif
                    </div>
                    <div class="modal-body">
                        <form role="form" action="{{route('doimatkhauadmin',Session::get('magv1'))}}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <fieldset>
                                <div class="form-group ">
                                    <label>Mã sinh viên: </label> {{Session::get('magv1')}}<br>
                                    <label>Email: </label> {{Session::get('email1')}}
                                </div>
                                <div class="form-group an">
                                    <label>Nhập mật khẩu cũ </label>
                                    <input type="password" name='matkhaucu' placeholder="Nhập mật mẩu cũ" class="form-control">
                                </div>
                                <div class="form-group an">
                                    <label>Nhập mật khẩu mới </label>
                                    <input type="password" name='matkhaumoi' placeholder="Nhập mật khẩu mới" class="form-control">
                                </div>
                                <div class="form-group an">
                                    <label>Nhập lại mật khẩu mới </label>
                                    <input type="password" name='nhaplaimatkhau' placeholder="Nhập lại mật khẩu mới" class="form-control" >
                                </div>
                                <button id="nhan" type="button" class="btn btn-lg btn-info btn-block" >Thay đổi mật khẩu</button>
                                <button type="submit" type="button" class="an btn btn-lg btn-info btn-block" >Cập nhật</button>
                            </fieldset>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
        <li class="divider"></li>
        <li><a href="{{route('dangxuat')}}"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a>
        </li>
        @endif
    </ul>
    <!-- /.navbar-top-links -->

    @include('admin.layout.menu')
    <!-- /.navbar-static-side -->
</nav>
@section('script')
<script>
    $(document).ready(function() {
          $(".an").hide();
          $("#nhan").click(function(){
            $(".an").show();
            $("#nhan").hide();
          });
    });
</script>
@if(session('thongbao1'))
    <script>
            $(document).ready(function() {
                  $("#abc").click();
            });
    </script>
@endif
    @if($errors-> has('matkhaucu') || $errors-> has('matkhaumoi') || $errors-> has('nhaplaimatkhau'))
        <script>
            $(document).ready(function() {
                  $("#abc").click();
            });
        </script>
    @endif
@endsection
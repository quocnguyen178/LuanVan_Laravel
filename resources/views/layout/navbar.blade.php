<div class="col-md-12">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ route('trangchu.get') }}" style="color:black;">Trang chủ</a>
				@if( (Session::has('login2') && Session::get('login2')==true) || (Session::has('login3') && Session::get('login3')==true) )
				
				@else
				<ul class="nav navbar-nav navbar-left" >
						 <li><a href="{{ route('thongke.getallluanvan') }}">Xem tất cả luận văn</a></li> 
					</ul>
				@endif
				
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				@if( (Session::has('login2') && Session::get('login2')==true) || (Session::has('login3') && Session::get('login3')==true) )
				<ul class="nav navbar-nav navbar-left" style="margin-right: 50px;">
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Chức năng <b class="caret"></b></a>
					<ul class="dropdown-menu">
						 <li><a href="{{ route('thongke.getallluanvan') }}">Xem tất cả luận văn</a></li> 
						<li><a href="{{ route('thongke.getloailuanvan') }}">Xem theo loại luận văn</a></li>
						<li><a href="{{ route('thongke.getsinhvien') }}">Xem theo sinh viên</a></li>
						@if(Session::has('login2') && Session::get('login2')==true)
						<li><a href="{{route('thongke.getdiem')}}">Xem theo điểm luận văn</a></li>
						@endif
					</ul>
				</li>
				</ul>
				@else
					<ul class="nav navbar-nav navbar-left">
						<li class="dropdown">
					<a href="#" class="dropdown-toggle" ></a></li>
					</ul>
				@endif
				@if(Session::has('login2') && Session::get('login2')==true)
				<form class="navbar-form navbar-left" action="{{route('giangvien.timkiem')}}" method="GET" role="search" style="margin-left: 100px;">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="form-group">
						<input type="text" class="form-control" name="search" placeholder="Tìm...">
					</div>
					<select class="form-control" name ="sel">
                        <option value="Tất cả" selected="">Tất cả</option>
                        <option value="GVHD">GVHD</option>
                        <option value="Sinh viên">Sinh Viên</option>
                    </select>
					<button type="submit" class="btn btn-default">Tìm</button>
				</form>
				@else
				<form class="navbar-form navbar-left" action="{{route('sinhvien.timkiem')}}" method="GET" role="search" style="margin-left: 100px;">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="form-group" >
						<input type="text" class="form-control" name="search" placeholder="Tìm...">
					</div>
					<select class="form-control" name ="sel">
                        <option value="Tất cả" selected="">Tất cả</option>
                        <option value="GVHD">GVHD</option>
                        <option value="Sinh viên">Sinh Viên</option>
                    </select>
					<button type="submit" class="btn btn-default">Tìm</button>
				</form>
				@endif

				<ul class="nav navbar-nav navbar-right">
					@if(Session::has('login2') && Session::get('login2')==true)
					<li><a href="" data-toggle="modal" id="abc" data-target="#giangvien"><i class="fa fa-user fa-fw"></i>{{Session::get('name2')}}</a></li>
					<div class="modal fade" id="giangvien" role="dialog">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">{{Session::get('name2')}}</h4>
                                  @if(count($errors) >0)
				                        @foreach($errors->all() as $err)
				                            <span style="color:red;">{{$err}}</span><br>
				                        @endforeach
					                @endif
                                  	@if(session('thongbao'))
				                        <span style="color:red;">{{session('thongbao')}}</span>
				                	@endif
                                </div>
                                <div class="modal-body">
                                  <form role="form" action="{{route('doimatkhaugiangvien',Session::get('magv2'))}}" method="POST">
				                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
				                    <fieldset>
				                        <div class="form-group ">
							                <label>Mã giảng viên:</label> {{Session::get('magv2')}}<br>
							                <label>Email:</label> {{Session::get('email2')}}
							            </div>
							            <div class="form-group an">
							                <label>Mật khẩu cũ </label>
							                <input type="password" name='matkhaucu' placeholder="Nhập mật mẩu cũ" class="form-control">
							            </div>
							            <div class="form-group an">
							                <label>Mật khẩu mới </label>
							                <input type="password" name='matkhaumoi' placeholder="Nhập mật mẩu mới" class="form-control">
							            </div>
							            <div class="form-group an">
							                <label>Nhập lại mật khẩu mới </label>
							                <input type="password" name='nhaplaimatkhau' placeholder="Nhập lại mật mẩu mới" class="form-control" >
							            </div>
							            <button id="nhan" type="button" class="btn btn-lg btn-info btn-block" >Thay đổi mật khẩu</button>
							            <button type="submit" type="button" class="an btn btn-lg btn-info btn-block" >Cập nhật</button>
				                        {{-- <p id="nhan">asdfsd</p> --}}
				                    </fieldset>
				                </form>
                                </div>
                              </div>
                            </div>
                        </div>
					<li><a href="{{route('dangxuat')}}"><i class="fa fa-sign-out fa-fw"></i>Đăng xuất</a></li>
					@elseif(Session::has('login3') && Session::get('login3')==true)
					<li><a href="" data-toggle="modal" id="abc" data-target="#sinhvien">
						<i class="fa fa-user fa-fw"></i>{{Session::get('name3')}}</a></li>
					<div class="modal fade" id="sinhvien" role="dialog">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">{{Session::get('name3')}}</h4>
                              @if(count($errors) >0)
			                        @foreach($errors->all() as $err)
			                            <span style="color:red;">{{$err}}</span><br>
			                        @endforeach
				                @endif
                              	@if(session('thongbao'))
			                        <span style="color:red;">{{session('thongbao')}}</span>
			                	@endif
                            </div>
                            <div class="modal-body">
                              <form role="form" action="{{route('doimatkhausinhvien',Session::get('masv3'))}}" method="POST">
			                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			                    <fieldset>
			                        <div class="form-group ">
						                <label>MSSV: </label> {{Session::get('masv3')}}<br>
						                <label>Email: </label> {{Session::get('email3')}}
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
			                        {{-- <p id="nhan">asdfsd</p> --}}
			                    </fieldset>
			                </form>
                            </div>
                          </div>
                        </div>
                    </div>
					<li><a href="{{route('dangxuat')}}"><i class="fa fa-sign-out fa-fw"></i>Đăng xuất</a></li>
					@else
					<li><a href="{{route('dangnhap')}}" data-toggle="modal" id="abc" data-target="#dangnhap">Đăng nhập</a></li>
					@endif
					<div class="modal fade" id="dangnhap" role="dialog">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Đăng nhập</h4>
                                  	@if(count($errors) >0)
				                        @foreach($errors->all() as $err)
				                            <span style="color:red;">{{$err}}</span><br>
				                        @endforeach
					                @endif
                                  	@if(session('thongbao'))
			                        <span style="color:red;">{{session('thongbao')}}</span>
			                		@endif
                                </div>
                                <div class="modal-body">
                                  <form role="form" action="{{route('dangnhap')}}" method="POST">
				                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
				                    <fieldset>
				                        <div class="form-group">
				                            <input class="form-control" placeholder="Nhập tài khoản" name="username"  autofocus value="">
				                        </div>
				                        <div class="form-group">
				                            <input class="form-control" placeholder="Nhập mật khẩu" name="password" type="password" value="">
				                        </div>
				                        <div class="form-group">
				                            <label>Quyền người dùng</label><br>
				                            <label class="radio-inline">
				                                <input name="maquyen" value="3" type="radio">Sinh Viên 
				                            </label>
				                            <label class="radio-inline">
				                                <input name="maquyen" value="2" type="radio">Giảng Viên 
				                            </label>
				                            <label class="radio-inline">
				                                <input name="maquyen" value="1" type="radio">Admin 
				                            </label>
				                        </div>
				                        <button type="submit" class="btn btn-lg btn-info btn-block">Đăng nhập</button>
				                    </fieldset>
				                </form>
                                </div>
                              </div>
                            </div>
                        </div>
				</ul>
				
			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
</div>
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
@if(session('thongbao'))
	<script>
			$(document).ready(function() {
			    $("#abc").click();
			});
	</script>
@endif
@if(count($errors) >0)
	<script>
			$(document).ready(function() {
			      $("#abc").click();
			});
	</script>
@endif
@endsection
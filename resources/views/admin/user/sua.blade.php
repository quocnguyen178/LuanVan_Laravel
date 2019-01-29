@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Sửa</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
            	@if(count($errors) >0)
                    <div class="alert alert-danger">
                        Thông tin bạn nhập không đúng, bạn cần chỉnh sửa như sau:
                        <ul>
                        @foreach($errors->all() as $err)
                            <li>{{$err}}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('user.postsua', $user-> username)}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" value="{{$user-> username}}" placeholder="Nhập mã loại luận văn" />
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="username" value="{{$user-> name}}" placeholder="Nhập họ tên" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="username" value="{{$user-> email}}" placeholder="Nhập địa chỉ email" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="password" value="{{$user-> password}}" placeholder="Nhập mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Quyền người dùng</label>
                        @foreach($quyen as $q)
                        <label class="radio-inline">
                            <input name="maquyen" 
                                @if($user-> quyen-> maquyen == $q-> maquyen)
                                {{"checked"}}
                                @endif
                             value="{{$q-> maquyen}}" type="radio">{{$q-> tenquyen}}
                        </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
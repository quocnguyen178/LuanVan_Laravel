@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">USER
                    <small>Thêm</small>
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
                <form action="{{route('user.postthem')}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" value="{{old('username')}}" placeholder="Nhập username" />
                    </div>
                    <div class="form-group">
                        <label>Tên người dùng</label>
                        <input class="form-control" name="name" value="{{old('name')}}" placeholder="Nhập tên người dùng" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="{{old('email')}}" placeholder="Nhập email" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" value="" placeholder="Nhập mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password_again" value="" placeholder="Nhập lại mật khẩu" />
                    </div>
                    <div class="form-group">
                        <label>Quyền người dùng</label>
                        @foreach($quyen as $q)
                        <label class="radio-inline">
                            <input name="maquyen" 
                             value="{{$q-> maquyen}}" type="radio">{{$q-> tenquyen}}
                        </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-default">Thêm</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
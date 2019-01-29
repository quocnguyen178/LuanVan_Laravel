@extends('layout.master')
@section('content')
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Đăng nhập</h3>
            </div>
            <div class="panel-body">
                @if(count($errors) >0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            {{$err}}<br>
                        @endforeach
                    </div>
                @endif
                @if(session('thongbao'))
                        {{session('thongbao')}}
                @endif
                <form role="form" action="{{route('dangnhap')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Nhập tài khoản" name="username"  autofocus>
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
@endsection

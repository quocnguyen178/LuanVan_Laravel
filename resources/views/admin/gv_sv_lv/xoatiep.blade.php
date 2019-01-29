@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Hướng dẫn
                    <small>Xóa tiếp</small>
                </h1>
                @if(isset($huongdan))
                <div class="alert alert-success">
                    Sinh viên này có 2 giảng viên hướng dẫn nên bạn phải xóa cả 2 hoặc bạn phải xóa 1 người và thêm 1 người khác
                </div>
                @endif
                <form action="{{route('gv_sv_lv.getxoathem',[ $huongdan-> masv, $huongdan-> magv, $huongdan->malv ])}}" method="GET">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <button type="submit" id="them" class="btn btn-info" onclick="return confirm_tb()">Thêm mới 1 hướng dẫn</button>
                </form>
            </br>
                <form action="{{route('gv_sv_lv.xoatiep', [ $huongdan-> masv, $huongdan-> magv, $huongdan->malv ])}}" method="POST">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <button type="submit" id="them" class="btn btn-info" onclick="return confirm_tb()">Xóa hướng dẫn còn lại</button>
                </form>
@endsection
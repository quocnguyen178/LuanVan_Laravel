@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Upload Điểm
                    <small>Excel</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>
                @endif
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
                {{-- postexcelhuongdan upload.postexceldia upload.postdiemexcel --}}
                <form enctype="multipart/form-data" action="{{route('upload.postdiemexcel')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>File Điểm excel</label>
                        <input type="file" name="file" />
                        {{-- <button type="submit" class="btn btn-info">Upload</button> --}}
                    </div>
                    <button type="submit" class="btn btn-info">Upload</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
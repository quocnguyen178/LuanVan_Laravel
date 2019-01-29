@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Upload File
                    <small>Excel</small>
                </h1>
                @if(session('thongbaothanhcong'))
                <div class="alert alert-success">
                    {{session('thongbaothanhcong')}}
                </div>
                @endif
                @if(session('thongbao'))
                <div class="alert alert-success">Thông tin bạn nhập không đúng, bạn cần chỉnh sửa lại:<br>
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
                <form enctype="multipart/form-data" action="{{route('upload.postexcel')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>File excel</label>
                        <input type="file" name="file" />
                        {{-- <button type="submit" class="btn btn-info">Upload</button> --}}
                    </div>
                    <button type="submit" class="btn btn-info" onclick="return confirm_tb()">Upload</button>
                <form>

                
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('xacnhan')
    <script>
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    </script>
@endsection
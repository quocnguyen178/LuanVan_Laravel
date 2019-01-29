@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
        	
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Danh sách</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>
            @endif
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <td>UserName</td>
                        <td>Name</td>
                        <td>Email</td>
                        {{-- <td>Password</td> --}}
                        <td>Quyền</td>
                        <td>Hành động</td>
                    </tr>
                </thead>
                <tbody>
                	@foreach($user as $u)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $u -> username }}</td>
                        <td align="left">{{ $u -> name }}</td>
                        <td align="left">{{ $u -> email }}</td>
                        {{-- <td>{{ $u -> password }}</td> --}}
                        <td>{{ $u -> quyen-> tenquyen }}</td>
                        <td class="center"><a style="margin-right: 10px;" href="{{route('user.xoa', $u-> username)}}"><i class="fa fa-trash-o  fa-lg"></i></a><a href="{{route('user.getsua', $u-> username)}}"><i class="fa fa-pencil fa-lg"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
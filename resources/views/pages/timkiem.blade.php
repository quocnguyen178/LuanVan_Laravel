@extends('layout.master')
@section('content')
@include('layout.navbar')
    <div style="font-size: 20px;">
        <p>Kết quả tìm kiếm theo <span style="color:blue;">{{$chon}} </span> với từ khóa: <span style="color:red;">{{ $timkiem }} </span></p>
    </div>
    @if(!count($data))
    <span style="color:red;font-size: 20px;">Không tìm thấy kết quả</span>
    @else
        <table class="table table-striped table-bordered table-hover" >
            <thead style="background: #1A91EA; color: white;">
                <tr align="center">
                    <td>STT</td>
                    <td>MSSV</td>
                    <td>Họ tên SV</td>
                    {{-- <td>Mã luận văn</td> --}}
                    <td>Tên luận văn</td>
                    <td>Loại luận văn</td>
                    <td>Tháng năm nộp</td>
                    <td>Chi tiết</td>
                    <td>GVHD</td>
                    @if(Session::has('login2') && Session::get('login2')==true)
                    <td>Điểm</td>
                    <td colspan="3">Tải về</td>
                    @endif
                    @if(Session::has('login3') && Session::get('login3')==true)
                    <td>Tải về</td>
                    @endif
                </tr>
            </thead>
            <?php $i=1; ?>
            @foreach($data as $lv)
                <tr align="center" id="timkiem">
                    <td>{{$i}}</td>
                    <td>{{$lv-> masv}}</td>
                    <td>{{$lv-> hotensv}}</td>
                    {{-- <td>{{$lv-> malv}}</td> --}}
                    <td align="left">{{$lv-> tenlv}}</td>
                    <td>{{$lv-> tenloailv}}</td>
                    @if(Session::has('login2') && Session::get('login2')==true)
                    <td width="90px">{{date('m-Y', strtotime($lv -> thangnam))}}</td>
                    @else
                    <td>{{date('m-Y', strtotime($lv -> thangnam))}}</td>
                    @endif
                    
                    <td><a href="" data-toggle="modal" data-target="#{{$lv-> malv}}">Xem chi tiết</a></td>
                    <td align="left">{{$lv-> hotengv}}</td>
                    @if(Session::has('login2') && Session::get('login2')==true)
                    <td >{{$lv-> diem}}</td>
                    <td ><a href="url/pdf/{{$lv-> filepdf}}">PDF</a></td>
                    <td ><a href="url/doc/{{$lv-> fileword}}">WORD</a></td>
                    <td ><a href="url/src/{{$lv-> filesrc}}">SOURCE</a></td>
                    @endif
                    @if(Session::has('login3') && Session::get('login3')==true)
                    <td ><a href="url/pdf/{{$lv-> filepdf}}">PDF</a></td>
                    @endif
                    {{-- Pop-up --}}
                    <div class="modal fade" id="{{$lv-> malv}}" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Chi tiết: {{ $lv -> tenlv }}</h4>
                            </div>
                            <div class="modal-body">
                               <ul>
                               <li><span style="font-weight: bold;">Mã luận văn:</span> {{$lv-> malv}}</li> 
                                <li><span style="font-weight: bold;">Màu bìa:</span> {{ $lv -> maubia }}</li>
                                <li><span style="font-weight: bold;">Nội dung tóm tắt:</span> {{ $lv -> noidungtomtat }}</li>
                            </ul>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                    </div>
                </tr>
            <?php $i++; ?>
            @endforeach
        </table>
        <div style="text-align: right;">
            {{ $data->appends(request()->input())->links() }}
        </div>
    @endif
@endsection
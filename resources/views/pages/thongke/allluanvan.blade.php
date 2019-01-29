@extends('layout.master')
@section('content')
@include('layout.navbar')
    <div class="col col-sm-3" style=" margin: 5px 0px 0px 420px; padding: 10px 0px;">
        <p align="center" style="color: #0F197E; font-weight: bold;">Xem Thông Tin Luận Văn</p>
        <div class="col-sm-12">
                        <p style="color:red;font-size: 18px; margin-left: 0px ;">Danh sách luận văn của ứng dụng </p>
                    </div>
    </div>
        <table class="table table-striped table-bordered table-hover">
                <thead style="background: #1A91EA; color: white;">
                    <tr align="center">
                        <td>STT</td>
                        <td>MSSV</td>
                        <td>Họ tên sinh viên</td>
                        <td>Tên luận văn</td>
                        <td>Loại luận văn</td>
                        <td>Tháng năm nộp</td>
                        <td>Chi tiết</td>
                        <td>Giảng viên hướng dẫn</td>
                        @if( (Session::has('login3') && Session::get('login3')==true) )
                            <td>Tải về</td>
                        @endif
                        @if( (Session::has('login2') && Session::get('login2')==true) )
                            <td colspan="3">Tải về</td>
                        @endif
                    </tr>
                </thead>
                <?php $i=1; ?>
                @foreach($dataalllv as $lv1)
                    <tr align="center" id="timkiem">
                        <td>{{$i}}</td>
                        <td>{{$lv1-> masv}}</td>
                        <td align="left">{{$lv1-> hotensv}}</td>
                        <td align="left">{{$lv1-> tenlv}}</td>
                        <td>{{$lv1-> tenloailv}}</td>
                        <td>{{date('m-Y', strtotime($lv1 -> thangnam))}}</td>
                        <td><a href="" data-toggle="modal" data-target="#{{$lv1-> malv}}">Xem chi tiết</a></td>
                        <td align="left">{{$lv1-> hotengv}}</td>
                        {{-- Pop-up --}}
                        <div class="modal fade" id="{{$lv1-> malv}}" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Chi tiết: {{ $lv1 -> tenlv }}</h4>
                                </div>
                                <div class="modal-body">
                                 <ul>                                       
                                    <li><span style="font-weight: bold;">Mã luận văn:</span> {{$lv1-> malv}}</li>
                                    <li><span style="font-weight: bold;">Màu bìa:</span> {{ $lv1 -> maubia }}</li>
                                    <li><span style="font-weight: bold;">Nội dung tóm tắt:</span> {{ $lv1 -> noidungtomtat }}</li>
                                </ul>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        @if( (Session::has('login3') && Session::get('login3')==true) )
                            <td ><a href="url/pdf/{{$lv1->filepdf}}">PDF</a></td>
                        @endif
                        @if( (Session::has('login2') && Session::get('login2')==true) )
                            <td ><a href="url/pdf/{{$lv1->filepdf}}">PDF</a></td>
                            <td ><a href="url/doc/{{$lv1->fileword}}">WORD</a></td>
                            <td ><a href="url/src/{{$lv1->filesrc}}">SOURCE</a></td>
                        @endif
                    </tr>
                <?php $i++; ?>
                @endforeach
            </table> 
            <div style="text-align: right;">
            {!! $dataalllv->render() !!}
        </div>
@endsection
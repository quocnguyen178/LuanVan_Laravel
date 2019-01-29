<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPExcel;
use PHPExcel_IOFactory; 
use PHPExcel_Cell;
use PHPExcel_Shared_Date;
use App\SinhVien;
use App\GiangVien;
use App\GV_SDT;
use App\LuanVan;
use App\SV_BV_LV;
use App\GV_SV_LV;
use App\GV_Quyen;
use App\PhanLoai_LV;
use App\DiaLuanVan;
use DB;


class ExcelController extends Controller
{
    public function getExcel()
    {
    	return view('admin.excel.upload');
    }
    
    public function postExcel(Request $request)
    {
    	$file = '';
    	if($request-> hasFile('file')){
    		$file = $request->file('file');
    		$duoi = $file-> getClientOriginalExtension();
    		if($duoi != 'xlsx')
    			return redirect()-> back()->with('thongbao','File bạn chọn không phải Excel');
    	}
    	else
    		return redirect()-> back()->with('thongbao','Bạn chưa chọn file');
    	try {
			//Tiến hành xác thực file
			$objFile = PHPExcel_IOFactory::identify($file);
			$objData = PHPExcel_IOFactory::createReader($objFile);
			//Chỉ đọc dữ liệu
			$objData->setReadDataOnly(true);
			// Load dữ liệu sang dạng đối tượng
			$objPHPExcel = $objData->load($file);
		} catch(Exception $e) {
		    die('Lỗi không thể đọc file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		$count = $objPHPExcel->getSheetCount();

		for($k=0; $k< $count; $k++)
		{
			//chạy từng sheet
	        $sheet  = $objPHPExcel->setActiveSheetIndex($k);
			//Lấy ra số dòng cuối cùng
			$Totalrow = $sheet->getHighestRow();
			//Lấy ra tên cột cuối cùng
			$LastColumn = $sheet->getHighestColumn();

			//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
			$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

			//Tạo mảng chứa dữ liệu
			$data = [];
			//Sheet sinh viên
			if($k==0){
				//Tiến hành lặp qua từng ô dữ liệu
				//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
				for ($i = 2; $i <= $Totalrow; $i++)
				{
					//----Lặp cột
					for ($j = 0; $j < $TotalCol; $j++)
					{
				    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
						$data[$i-2][$j]=$sheet->getCellByColumnAndRow($j, $i)->getValue();
					}
					
				}
				foreach($data as $sv)
				{
					//tìm masv đó có tồn tại chưa
					$temp = SinhVien::find($sv[0]);
					// if(isset($temp)){
					// 	return redirect()->route('upload.getexcel')->with('thongbao','Mã sinh viên: '.$sv[0].' đã tồn tại');
					// }
					
					// nếu chưa thì insert vào
					if(is_null($temp) && isset($sv[0]))
					{ 
						//email sinh viên đã tồn tại
						$tempemailsv = SinhVien::where('email',$sv[4])-> first();
						if(isset($tempemailsv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Email: '.$sv[4].' của sinh viên đã tồn tại');
						}
						//email sinh viên đã tồn tại bên giảng viên
						$tempemailgv = GiangVien::where('email',$sv[4])-> first();
						if(isset($tempemailgv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Email: '.$sv[4].' của sinh viên đã tồn tại');
						}
						//sdt sinh viên đã tồn tại
						$tempsdtsv = SinhVien::where('sdt',$sv[3])-> first();
						if(isset($tempsdtsv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại: '.$sv[3].' của sinh viên đã tồn tại');
						}
						//sdt sinh viên đã tồn tại bên giảng viên
						$tempsdt1gv = GiangVien::where('sdt1',$sv[3])-> first();
						$tempsdt2gv = GiangVien::where('sdt2',$sv[3])-> first();
						if(isset($tempsdt1gv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại: '.$sv[3].' của sinh viên đã tồn tại');
						}
						if(isset($tempsdt2gv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại: '.$sv[3].' của sinh viên đã tồn tại');
						}

						//Tên sinh viên phải đúng định dạng
						if(!preg_match("/^[\pL\s\-]+$/u",$sv[1])){
							return redirect()->route('upload.getexcel')->with('thongbao','Tên: '.$sv[1].' của sinh viên sai định dạng');
						}
						//Mã sinh viên phải đúng định dạng
						if(!preg_match("/^(DH5)[0-9]{7}$|^(CD5)[0-9]{7}$/",$sv[0])){
							return redirect()->route('upload.getexcel')->with('thongbao','Mã: '.$sv[0].' của sinh viên sai định dạng');
						}
						//sdt sinh viên phải đúng định dạng
						if(!preg_match("/^(0)[0-9]{9,10}$/",$sv[3])){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại: '.$sv[3].' của sinh viên sai định dạng');
						}
						//email sinh viên phải đúng định dạng
						if(!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/",$sv[4])){
							return redirect()->route('upload.getexcel')->with('thongbao','Email: '.$sv[4].' của sinh viên sai định dạng');
						}
						//lớp sinh viên phải đúng định dạng
						if(!preg_match("/^(D)[0-9]{2}(_TH)[0-9]{2}$|^(C)[0-9]{2}(_TH)[0-9]{2}$/",$sv[2])){
							return redirect()->route('upload.getexcel')->with('thongbao','Lớp: '.$sv[2].' của sinh viên sai định dạng');
						}
						
						$sinhvien = new SinhVien;
						$sinhvien-> masv = $sv[0];
						$sinhvien-> hotensv = mb_convert_case($sv[1], MB_CASE_TITLE, "UTF-8");
						$sinhvien-> lop = $sv[2];
						$sinhvien-> sdt = $sv[3];
						$sinhvien-> email = $sv[4];
						$sinhvien-> matkhau = md5($sv[0]);
						$sinhvien-> maquyen = 3;
						$sinhvien-> save();
					}
				}
			}
			if($k==1)
			{
				//Tiến hành lặp qua từng ô dữ liệu
				//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
				for ($i = 2; $i <= $Totalrow; $i++)
				{
					//----Lặp cột
					for ($j = 0; $j < $TotalCol; $j++)
					{
				    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
						$data[$i-2][$j]=$sheet->getCellByColumnAndRow($j, $i)->getValue();
					}
				}
				//var_dump($data);
				foreach ($data as $gv) 
				{
					$gv_temp= GiangVien::orderBy('magv','desc')->first();
					$magv='';
					if(is_null($gv_temp))
					{
					    $magv="TH001";  
					}else
					{
			            //lấy tiền tố GV
			            $tiento = substr( $gv_temp-> magv,  0, 2);
			            // độ dài của mã = 5(GV001)
			            $len = $gv_temp-> magv;
			            //cắt bỏ tiền tố 'GV'-> 001 + 1 = 2 
			            $next= substr( $gv_temp-> magv,  2, 3) + 1;
			            //lấy độ dài mã trừ độ dài tiền tố 5-2=3
			            $lenght= strlen($len) - strlen($tiento);
			            //chuỗi chứa dãy số 0
			            $zero='';
			            for ($i=1; $i <= $lenght ; $i++) 
			            { 
			            //pow(10,i) lấy bình phương 10^i
			                if($next < pow(10,$i)){
			                    for ($j=1; $j <= $lenght - $i  ; $i++) {
			                        $zero .="0";
			                    }
			                   	$magv = $tiento.$zero.$next;
			                }
		            	}
			    	}
				 
					$gv_tim = GiangVien::where('email',$gv[4])->first();
					if(is_null($gv_tim) && isset($gv[0]))
					{
						//email giảng viên đã tồn tại bên sinh viên
						$tempemailsv = SinhVien::where('email',$gv[4])-> first();
						if(isset($tempemailsv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Email: '.$gv[4].' của giảng viên đã tồn tại');
						}
						//Tên giảng viên phải đúng định dạng
						if(!preg_match("/^[\pL\s\-]+$/u",$gv[0])){
							return redirect()->route('upload.getexcel')->with('thongbao','Tên: '.$gv[0].' của giảng viên sai định dạng');
						}
						//sdt giảng viên phải đúng định dạng
						if($gv[5] == null)
						{
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 1 của giảng viên '.$gv[0].' không được để trống');
						}
						elseif(!preg_match("/^(0)[0-9]{9,10}$/",$gv[5])){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 1: '.$gv[5].' của giảng viên sai định dạng');
						}
						//sdt sai định dạng
						if($gv[6] != null )
						{
							if(!preg_match("/^(0)[0-9]{9,10}$/",$gv[6])){
								return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 2: '.$gv[6].' của giảng viên sai định dạng');
							}
						}
						//sdt1 giảng viên đã tồn tại
						$tempsdt1gv = GiangVien::where('sdt1',$gv[5])->orWhere('sdt2',$gv[5])-> first();
						if(isset($tempsdt1gv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 1: '.$gv[5].' của giảng viên đã tồn tại');
						}
						//sdt2 giảng viên đã tồn tại
						$tempsdt2gv = GiangVien::where('sdt2',$gv[6])->orWhere('sdt1',$gv[6])-> first();
						if(isset($tempsdt2gv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 2: '.$gv[6].' của giảng viên đã tồn tại');
						}
						//sdt1 giảng viên đã tồn tại bên sinh viên
						$tempsdt1sv = SinhVien::where('sdt',$gv[5])-> first();
						if(isset($tempsdt1sv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 1: '.$gv[5].' của giảng viên đã tồn tại');
						}
						//sdt2 giảng viên đã tồn tại bên sinh viên
						$tempsdt2sv = SinhVien::where('sdt',$gv[6])-> first();
						if(isset($tempsdt2sv)){
							return redirect()->route('upload.getexcel')->with('thongbao','Số điện thoại 2: '.$gv[6].' của giảng viên đã tồn tại');
						}
						//học hàm sai định dạng
						if(!preg_match("/^(GS)$|^(PGS)$|^(GVC)$/",$gv[1])){
							return redirect()->route('upload.getexcel')->with('thongbao','Học hàm: '.$gv[1].' của giảng viên sai định dạng');
						}
						//học vị sai định dạng
						if(!preg_match("/^(TS)$|^(KS)$|^(CN)$|^(ThS)$/",$gv[2])){
							return redirect()->route('upload.getexcel')->with('thongbao','Học vị: '.$gv[2].' của giảng viên sai định dạng');
						}
						//loại giảng viên sai định dạng
						if(!preg_match("/^(Cơ Hữu)$|^(Bán Cơ Hữu)$|^(Thỉnh Giảng)$/",$gv[3])){
							return redirect()->route('upload.getexcel')->with('thongbao','Loại giảng viên: '.$gv[3].' sai định dạng');
						}
						//sdt trùng nhau
						if($gv[5] == $gv[6])
							return redirect()->route('upload.getexcel')->with('thongbao','SDT1 và SDT2: '.$gv[6].' của giảng viên trùng nhau');
						$giangvien = new GiangVien;
						$giangvien-> magv = $magv;
						$giangvien-> hotengv = mb_convert_case($gv[0], MB_CASE_TITLE, "UTF-8");
						$giangvien-> hocham = $gv[1];
						$giangvien-> hocvi = $gv[2];
						$giangvien-> loaigv = mb_convert_case($gv[3], MB_CASE_TITLE, "UTF-8");
						$giangvien-> email = $gv[4];
						$giangvien-> matkhau = md5($magv);
						$giangvien-> sdt1 = $gv[5];
						$gv[6] = isset($gv[6])? $gv[6] : '';
						$giangvien-> sdt2 = $gv[6];
						$giangvien-> save();
						$gv_quyen = new GV_Quyen;
						$gv_quyen-> magv = $magv;
						$gv_quyen-> maquyen = 2;
						$gv_quyen-> save();
					}
				}
				
			}
			if($k==2)
			{
				//Tiến hành lặp qua từng ô dữ liệu
				//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
				for ($i = 2; $i <= $Totalrow; $i++)
				{
					//----Lặp cột
					for ($j = 0; $j < $TotalCol; $j++)
					{
				    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
						$data[$i-2][$j]=$sheet->getCellByColumnAndRow($j, $i)->getValue();
					}
				}
				foreach ($data as $lv) 
				{
					$lv_temp= LuanVan::orderBy('malv','desc')->first();
       				$malv='';
				    //format ngày từ excel sang php 01/04/2018 => 2018/04/01
				    $ngayexcel = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($lv[1]));
				    //format ngày trong php lấy ra tháng năm
				    $date=date_create($ngayexcel);
				    //lấy ra ngày giờ tháng năm
					$namlv = date_format($date,"y");//18
					$thanglv = date_format($date,"m");;//năm hiện tại
					$ngay = date_format($date, "Y-m-d");//18-04-01
					// echo $thangnam.'</br>';
					if($thanglv == '01' || $thanglv == '02' || $thanglv == '07' || $thanglv == '08'){

					}else{
						return redirect()->route('upload.getexcel')->with('thongbao','Tháng nộp luận văn: '.date('d-m-Y', strtotime($ngayexcel)).' chỉ được trong tháng 1, 2 ,7 8');
					}
					if($namlv != date("y") )
						return redirect()->route('upload.getexcel')->with('thongbao','Năm nộp luận văn: '.date('d-m-Y', strtotime($ngayexcel)).' khác năm hiện tại'); 
				}
				foreach ($data as $lv) 
				{
					$lv_temp= LuanVan::orderBy('malv','desc')->first();
       				$malv='';
				    //format ngày từ excel sang php 01/04/2018 => 2018/04/01
				    $ngayexcel = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($lv[1]));
				    //format ngày trong php lấy ra tháng năm
				    $date=date_create($ngayexcel);
				    //lấy ra ngày giờ tháng năm
					$namlv = date_format($date,"y");//18
					$namht = date("y");//năm hiện tại
					$ngay = date_format($date, "Y-m-d");//18-04-01
					$thangnam = date($ngay);//18-04-01 - giờ hệ thống
					// echo $thangnam.'</br>';
					if($namlv < date("y"))
						return redirect()->route('upload.getexcel')->with('thongbao','Năm nộp luận văn: '.date('d-m-Y', strtotime($ngayexcel)).' đã cũ'); 
					if(is_null($lv_temp))
				   {
				       $malv="LV".$namlv."0001";  
				   }else
				   {
			            //lấy tiền tố LV
			            $tiento = substr( $lv_temp-> malv,  0, 2);
			            // độ dài của mã = 8(LV180001)
			            $len = $lv_temp-> malv;
			            //cắt bỏ tiền tố 'GV'-> 0001 + 1 = 2 
			            $next= substr( $lv_temp-> malv,  4, 4) + 1;
			            //lấy độ dài mã trừ độ dài tiền tố 8-2=5
			            $lenght= strlen($len) - strlen($tiento) -strlen($namlv);
			            //chuỗi chứa dãy số 0
			            $zero='';
			            for ($i=1; $i <= $lenght ; $i++) { 
			            //pow(10,i) lấy bình phương 10^i
			                if($next < pow(10,$i)){
			                    for ($j=1; $j <= $lenght - $i  ; $i++) {
			                        $zero .="0";
			                    }
			                   	$malv = $tiento.$namlv.$zero.$next;
			                }
		            	}
				      
			    	}
			    	if($lv[2]==''){
				    	$lv[2] = '';
				    }
				    if(isset($lv[0]))
					{ 
						//màu bìa phải đúng định dạng
						if(!preg_match("/^[\pL\s\-]+$/u",$lv[3])){
							return redirect()->route('upload.getexcel')->with('thongbao','Màu bìa: '.$lv[3].' không đúng');
						}
						//loại luận văn phải đúng định dạng
						if(!preg_match("/^(LLV)[0-9]{2}$/",$lv[4])){
							return redirect()->route('upload.getexcel')->with('thongbao','Loại luận văn: '.$lv[4].' không đúng');
						}
						// Kiểm tra xem có mã loại luận văn này chưa có mới thêm
						$templlv = PhanLoai_LV::where('maloailv',$lv[4])->first();
						if(is_null($templlv))
							return redirect()->route('upload.getexcel')->with('thongbao','Không có loại luận văn: '.$lv[4]);

					    $luanvan = new LuanVan;
					    $luanvan-> malv = $malv;
					    $luanvan-> tenlv = mb_convert_case($lv[0], MB_CASE_TITLE, "UTF-8");
					    $luanvan-> thangnam =$thangnam;
					    $luanvan-> noidungtomtat = $lv[2];
					    $luanvan-> maubia = mb_convert_case($lv[3], MB_CASE_TITLE, "UTF-8");
					    $luanvan-> maloailv = $lv[4];
						$luanvan-> save();
					}
				}
				
			}
		}
		
		
		return redirect()->route('upload.getexcel')->with('thongbaothanhcong','Đã upload thành công');
    }
    public function getExportDiemExcel()
    {
    	$luanvan = LuanVan::all();
        $arr=[];
        $arrnam=[];
        foreach ($luanvan as $lv) {
            $thang = substr( $lv-> thangnam,5,2);
            $nam = substr( $lv-> thangnam,0,4);
            $arr[$thang] = $thang;
            foreach ($arr as $v) {
                if($v != $thang)
                    $arr[$thang] = $thang;
            }
            $arrnam[$nam] = $nam;
            foreach ($arrnam as $v) {
                if($v != $nam)
                    $arr[$nam] = $nam;
            }
        }
        sort($arr);
        sort($arrnam);
    	return view('admin.export.diem',compact('arr','arrnam'));
    }
    public function postExportDiemExcel(Request $request)
    {
    	$thang = $request-> thang;
        $nam = $request-> nam;
        $arr = DB::table('sv_bv_lv')
        		->join('luanvan', 'luanvan.malv', '=', 'sv_bv_lv.malv')
        		->join('sinhvien', 'sinhvien.masv', '=', 'sv_bv_lv.masv')
       			// ->join('GV_SV_LV', 'GV_SV_LV.masv', '=', 'SinhVien.masv')//
    			// ->join('GiangVien', 'GV_SV_LV.magv', '=', 'GiangVien.magv')//
                ->select('*')
                ->whereMonth('luanvan.thangnam',$thang)
                ->whereYear('luanvan.thangnam',$request-> nam)
                // ->when($thang,function($query) use ($thang)  {
                //     return $query->whereMonth('LuanVan.thangnam',$thang);
                // })
                ->get();
        if(count($arr) == 0)
        	return redirect()->back()->with('thongbao','Không tìm thấy kết quả');
       
		$data= array();
		foreach ($arr as $v) {
			$r = array('masv'=> $v-> masv ,'hotensv'=> $v-> hotensv,'malv'=> $v-> malv,'tenlv'=>$v-> tenlv,'thangnam' => date('m-Y', strtotime($v-> thangnam)),'diem'=>$v-> diem);
			$data[] = $r;
		}
		//Khởi tạo đối tượng
		$excel = new PHPExcel();
		//Chọn trang cần ghi (là số từ 0->n)
		$excel->setActiveSheetIndex(0);
		//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		//$excel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		//Xét in đậm cho khoảng cột
		$excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
		// Thiết lập tên các cột dữ liệu
		$excel->setActiveSheetIndex(0)
                            ->setCellValue('A1', "STT")
                            ->setCellValue('B1', "Mã sinh viên")
                            ->setCellValue('C1', "Họ tên sinh viên")
                            ->setCellValue('D1', "Mã luận văn")
                            ->setCellValue('E1', "Tên luận văn")
                            ->setCellValue('F1', "Tháng năm nộp luận văn")
                            ->setCellValue('G1', "Điểm");
                            //->setCellValue('H1', "Giảng viên hướng dẫn");
        $numRow = 2;
		foreach($data as $row){
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $numRow-1)
										->setCellValue('B'.$numRow, $row['masv'])
										->setCellValue('C'.$numRow, $row['hotensv'])
										->setCellValue('D'.$numRow, $row['malv'])
										->setCellValue('E'.$numRow, $row['tenlv'])
										->setCellValue('F'.$numRow, $row['thangnam'])
										->setCellValue('G'.$numRow, $row['diem']);
										//->setCellValue('H'.$numRow, $row['hotengv']);
			$numRow++;
		}
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Export-Excel-Diem.xlsx"');
		PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
    }
    public function getExportLuanVanExcel()
    {
        return view('admin.export.luanvan');
    }
    public function postExportLuanVanExcel(Request $request)
    {
        $thang = $request-> thang;
        $nam = $request-> nam;
        $arr = DB::table('luanvan')
                ->select('*')
                ->whereYear('luanvan.thangnam',$request-> nam)
                ->when($thang,function($query) use ($thang)  {
                    return $query->whereMonth('luanvan.thangnam',$thang);
                })
                ->get();
        // if(!isset($arr))
        //     return redirect()->back()->with('thongbao','Năm này chưa thực hiện');
        $data= array();
        foreach ($arr as $v) {
            $r = array('malv'=> $v-> malv ,'tenlv'=> $v-> tenlv,'thangnam'=>date('m-Y', strtotime($v-> thangnam)) );
            $data[] = $r;
        }
        //Khởi tạo đối tượng
        $excel = new PHPExcel();
        //Chọn trang cần ghi (là số từ 0->n)
        $excel->setActiveSheetIndex(0);
        //Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        // $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        // $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        //Xét in đậm cho khoảng cột
        $excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        // Thiết lập tên các cột dữ liệu
        $excel->setActiveSheetIndex(0)
                            ->setCellValue('A1', "STT")
                            ->setCellValue('B1', "Mã luận văn")
                            ->setCellValue('C1', "Họ tên luận văn")
                            ->setCellValue('D1', "Tháng năm nộp luận văn");
                            // ->setCellValue('E1', "Tên luận văn")
                            // ->setCellValue('F1', "Điểm");
        $numRow = 2;
        foreach($data as $row){
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numRow, $numRow-1)
                                        ->setCellValue('B'.$numRow, $row['malv'])
                                        ->setCellValue('C'.$numRow, $row['tenlv'])
                                        ->setCellValue('D'.$numRow, $row['thangnam']);
            $numRow++;
        }
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Export-Excel-LuanVan.xlsx"');
        PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');
    }

    public function getDiemExcel()
    {
    	return view('admin.excel.upload_diem');
    }
    public function postExcelHuongDan(Request $request)
    {
    	$file='';
    	if($request-> hasFile('file')){
    		$file = $request->file('file');
    		$duoi = $file-> getClientOriginalExtension();
    		if($duoi != 'xlsx')
    			return redirect()->back()->with('thongbao','File bạn chọn không phải Excel');
    	}
    	else
    		return redirect()-> back()->with('thongbao','Bạn chưa chọn file');
    	try {
			//Tiến hành xác thực file
			$objFile = PHPExcel_IOFactory::identify($file);
			$objData = PHPExcel_IOFactory::createReader($objFile);
			//Chỉ đọc dữ liệu
			$objData->setReadDataOnly(true);
			// Load dữ liệu sang dạng đối tượng
			$objPHPExcel = $objData->load($file);
		} catch(Exception $e) {
		    die('Lỗi không thể đọc file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		//Chọn trang cần truy xuất
		$sheet  = $objPHPExcel->setActiveSheetIndex(0);

		//Lấy ra số dòng cuối cùng
		$Totalrow = $sheet->getHighestRow();
		//Lấy ra tên cột cuối cùng
		$LastColumn = $sheet->getHighestColumn();

		//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
		$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

		//Tạo mảng chứa dữ liệu
		$data = [];

		//Tiến hành lặp qua từng ô dữ liệu
		//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
		for ($i = 2; $i <= $Totalrow; $i++)
		{
			//----Lặp cột
			for ($j = 0; $j < $TotalCol; $j++)
			{
		    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
				$data[$i-2][$j]=$sheet->getCellByColumnAndRow($j, $i)->getValue();;
			}
		}
		//Duyệt mảng đổ vào cơ sở dữ liệu
		foreach($data as $sv)
		{
			$ngaybd = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($sv[3]));
			$ngaykt = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($sv[4]));
			//tìm masv đó có tồn tại chưa
			$sinhvien = new GV_SV_LV;
			$sinhvien-> masv = $sv[0];
			$sinhvien-> magv = $sv[1];
			$sinhvien-> malv = $sv[2];
			$sinhvien-> ngaybd = $ngaybd;
			$sinhvien-> ngaykt = $ngaykt;
			$sinhvien-> phantramhd = $sv[5];
			$sinhvien-> save();
			
		}
		return redirect()->route('upload.getdiemexcel')->with('thongbao','Đã upload thành công');
    }
    public function postExcelDia(Request $request)
    {
    	$file='';
    	if($request-> hasFile('file')){
    		$file = $request->file('file');
    		$duoi = $file-> getClientOriginalExtension();
    		if($duoi != 'xlsx')
    			return redirect()->back()->with('thongbao','File bạn chọn không phải Excel');
    	}
    	else
    		return redirect()-> back()->with('thongbao','Bạn chưa chọn file');
    	try {
			//Tiến hành xác thực file
			$objFile = PHPExcel_IOFactory::identify($file);
			$objData = PHPExcel_IOFactory::createReader($objFile);
			//Chỉ đọc dữ liệu
			$objData->setReadDataOnly(true);
			// Load dữ liệu sang dạng đối tượng
			$objPHPExcel = $objData->load($file);
		} catch(Exception $e) {
		    die('Lỗi không thể đọc file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		//Chọn trang cần truy xuất
		$sheet  = $objPHPExcel->setActiveSheetIndex(0);

		//Lấy ra số dòng cuối cùng
		$Totalrow = $sheet->getHighestRow();
		//Lấy ra tên cột cuối cùng
		$LastColumn = $sheet->getHighestColumn();

		//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
		$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

		//Tạo mảng chứa dữ liệu
		$data = [];

		//Tiến hành lặp qua từng ô dữ liệu
		//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
		for ($i = 2; $i <= $Totalrow; $i++)
		{
			//----Lặp cột
			for ($j = 0; $j < $TotalCol; $j++)
			{
		    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
				$data[$i-2][$j]=$sheet->getCellByColumnAndRow($j, $i)->getValue();;
			}
		}
		//Duyệt mảng đổ vào cơ sở dữ liệu
		foreach($data as $sv)
		{
			$dlv_temp= DiaLuanVan::orderBy('madia','desc')->first();
	        $madia='';
	        $namdlv = date("y");//18
	        if(is_null($dlv_temp))
	       {
	           $madia="LVD".$namdlv."0001";  
	       }else
	       {
	            //lấy tiền tố LVD
	            $tiento = substr( $dlv_temp-> madia,  0, 3);
	            //lấy năm LVD
	            $nam = substr( $dlv_temp-> madia,  3, 2);
	            // độ dài của mã = 8(LVD180001)
	            $len = $dlv_temp-> madia;
	            //cắt bỏ tiền tố 'LVD'-> 0001 + 1 = 2 
	            $next= substr( $dlv_temp-> madia,  5, 4) + 1;
	            //lấy độ dài mã trừ độ dài tiền tố 8-2=5
	            $lenght= strlen($len) - strlen($tiento) -strlen($nam);
	            //chuỗi chứa dãy số 0
	            $zero='';
	            for ($i=1; $i <= $lenght ; $i++) { 
	            //pow(10,i) lấy bình phương 10^i
	                if($next < pow(10,$i)){
	                    for ($j=1; $j <= $lenght - $i  ; $i++) {
	                        $zero .="0";
	                    }
	                    $madia = $tiento.$nam.$zero.$next;
	                }
	            }
	        }
			//tìm masv đó có tồn tại chưa
			$sinhvien = new DiaLuanVan;
			$sinhvien-> madia = $madia;
			$sinhvien-> malv = $sv[0];
			$sinhvien-> filepdf = $sv[1];
			$sinhvien-> fileword = $sv[2];
			$sinhvien-> filesrc = $sv[3];
			$sinhvien-> save();
			
		}
		return redirect()->route('upload.getdiemexcel')->with('thongbao','Đã upload thành công');
    }
    public function postDiemExcel(Request $request)
    {
    	$file='';
    	if($request-> hasFile('file')){
    		$file = $request->file('file');
    		$duoi = $file-> getClientOriginalExtension();
    		if($duoi != 'xlsx')
    			return redirect()->back()->with('thongbao','File bạn chọn không phải Excel');
    	}
    	else
    		return redirect()-> back()->with('thongbao','Bạn chưa chọn file');
    	try {
			//Tiến hành xác thực file
			$objFile = PHPExcel_IOFactory::identify($file);
			$objData = PHPExcel_IOFactory::createReader($objFile);
			//Chỉ đọc dữ liệu
			$objData->setReadDataOnly(true);
			// Load dữ liệu sang dạng đối tượng
			$objPHPExcel = $objData->load($file);
		} catch(Exception $e) {
		    die('Lỗi không thể đọc file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
		}
		//Chọn trang cần truy xuất
		$sheet  = $objPHPExcel->setActiveSheetIndex(0);

		//Lấy ra số dòng cuối cùng
		$Totalrow = $sheet->getHighestRow();
		//Lấy ra tên cột cuối cùng
		$LastColumn = $sheet->getHighestColumn();

		//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
		$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

		//Tạo mảng chứa dữ liệu
		$data = [];

		//Tiến hành lặp qua từng ô dữ liệu
		//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
		for ($i = 2; $i <= $Totalrow; $i++)
		{
			//----Lặp cột
			for ($j = 0; $j < $TotalCol; $j++)
			{
		    	// Tiến hành lấy giá trị của từng ô đổ vào mảng
				$data[$i-2][$j]=$sheet->getCellByColumnAndRow($j, $i)->getValue();;
			}
		}
		//Duyệt mảng đổ vào cơ sở dữ liệu
		foreach($data as $sv_diem)
		{
			// if(!preg_match("/^[0-9]{1,2}|[\0]$/",$sv_diem[6])){
			// 	//$sv_diem[6] = null;
			// 	//dd($sv_diem[6]);
			// 	return redirect()->route('upload.getdiemexcel')->with('thongbao','Điểm1: '.$sv_diem[6].' của '.$sv_diem[1].' và '.$sv_diem[3].' không đúng');
			// }
			//tìm masv đó có tồn tại chưa
			$sv_diem[6] = isset($sv_diem[6])? $sv_diem[6] : null;
			if($sv_diem[6] < 0 || $sv_diem[6] > 10){
				return redirect()->route('upload.getdiemexcel')->with('thongbao','Điểm: '.$sv_diem[6].' của '.$sv_diem[1].' và '.$sv_diem[3].' không đúng');
			}
			if(!preg_match("/^(?!0$)\d+(?:[,.][01])?$|^(?!0$)\d+(?:[,.][02])?$|^(?!0$)\d+(?:[,.][03])?$|^(?!0$)\d+(?:[,.][04])?$|^(?!0$)\d+(?:[,.][05])?$|^(?!0$)\d+(?:[,.][06])?$|^(?!0$)\d+(?:[,.][07])?$|^(?!0$)\d+(?:[,.][08])?$|^(?!0$)\d+(?:[,.][09])?$|^$/",$sv_diem[6])){
				return redirect()->route('upload.getdiemexcel')->with('thongbao','Điểm: '.$sv_diem[6].' của '.$sv_diem[1].' và '.$sv_diem[3].' không đúng');
			}
			$a = SV_BV_LV::where('masv', $sv_diem[1])-> where('malv', $sv_diem[3])->first();
			$kt = GV_SV_LV::where('masv', $sv_diem[1])-> where('malv', $sv_diem[3])->first();
			if(is_null($a) && isset($kt)){
				$diem_sv = new SV_BV_LV;
				$diem_sv-> masv = $sv_diem[1];
				$diem_sv-> malv = $sv_diem[3];
				$diem_sv-> diem = $sv_diem[6];
				$diem_sv-> save();
			}
			elseif(isset($kt)){
				$diem = SV_BV_LV::where('masv', $sv_diem[1])
							-> where('malv',$sv_diem[3])->update(['diem'=> $sv_diem[6]]);
			}
			else return redirect()->route('upload.getdiemexcel')->with('thongbao','Mã sinh viên: '.$sv_diem[1].' và mã luận văn: '.$sv_diem[3].' chưa có giảng viên hướng dẫn');
			
		}
		return redirect()->route('upload.getdiemexcel')->with('thongbao','Đã upload thành công');
    }
}

<?php

namespace App\Http\Controllers;
// Include or autoload the class definition
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use PDF;
ini_set('memory_limit', '1024M'); // เพิ่มเป็น 1 GB
set_time_limit(180); // เพิ่มเวลาการทำงานเป็น 180 วินาที
date_default_timezone_set('Asia/Bangkok');

class DooDuagController extends Controller
{
    public $headers;
    public function __construct()
    {
        // $this->middleware('cors');
        $this->headers = [];
    }

    // Start-Settingpage
    public function settingpage(Request $request)
    {
        $title  = '';

        // $password = $request->input('password');

        $title  = 'หน้าหลัก || ตั้งค่าระบบเริ่มต้น';
        return view('dooduag.settingpage.index',compact('title'));

    }

    public function LoadDooDuagMain(Request $request)
    {
        try {
            $sql = DB::select('CALL usp_LoadDooDuagMain');
            
            $div ="";
           
            $i = 1;
            foreach($sql as $key=>$row){
                $link = "<button type='button' class='btn btn-sm btn-dark' data-id='".$row->DooDuagDayID."' onclick='LoadDooDuagSub(this);'>ดูรายการเวลา</button>";
                if($row->IsActive == 1){
                    $col = "<button class='btn btn-sm btn-success' data-name='".$row->DoDuagDayName1."' data-id='".$row->DooDuagDayID."' onclick='HandleIsActiveMain(this);'>ใช้งาน</button>";
                }else{
                    $col = "<button class='btn btn-sm btn-danger' data-name='".$row->DoDuagDayName1."' data-id='".$row->DooDuagDayID."' onclick='HandleIsActiveMain(this);'>ไม่ใช้งาน</button>";
                }

                $div .="<div class='MasterDooduagMain'>";
                $div .="<h5>".$i.".".$row->DoDuagDayName1."</h5>";
                $div .="<h6>(".$row->DoDuagDayName2.")</h6>";
                $div .="<h6>".$col." ".$link."</h6>";
                $div .="</div>";

                $i++;


            }

            $data = [
                'data' => $div
            ];
    
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Handle the exception, for example, log the error
            Log::error('Error in : ' . $e->getMessage());
    
            // Return an appropriate error response
            return response()->json(['error' => 'An error occurred while loading data.'], 500);
        }
    }

    public function HandleIsActiveMain(Request $request){
        try {
            $DooDuagMainID = $request->input('DooDuagMainID');
            $sql = DB::select("CALL usp_DooDuagMainSaveStatus(?)", [$DooDuagMainID]);
            $data = [
                'data' => 'success'
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Handle the exception, for example, log the error
            Log::error('Error in : ' . $e->getMessage());

            // Return an appropriate error response
            return response()->json(['error' => 'An error occurred while loading data.'], 500);
        }
    }

    public function LoadDooDuagSub(Request $request){
        try {
            $DooDuagdayID = $request->input('DooDuagdayID');
            $sql = DB::select("CALL usp_DooDuagSubLoad(?)", [$DooDuagdayID]);

            $div = '';
            
            $div .= '<div class="table-responsive">';
            $div .= "<div class='row'>";
            foreach($sql as $key=>$row){
                if($row->IsActive == 1){
                    $status = 'btn-success';
                }else{
                    $status = 'btn-warning';
                }
                $div .= "<div class='col-2 mb-1 text-center'>";
                $div .= "<button width='100%' 
                                        class='btn btn-sm $status' 
                                        data-dooduagsubid ='" . $row->DooDuagSubID . "' 
                                        onclick='RemoveDooDuagSub(this)'>" . $row->DooDuagSubTime . '</button>';
                $div .= "</div>";
            }
            
            $div .= "</div>";
            $div .= "</div>";

            $data = [
                'data' => $div
            ];
            return response()->json($data, 200);

        } catch (\Exception $e) {
            // Handle the exception, for example, log the error
            Log::error('Error in : ' . $e->getMessage());

            // Return an appropriate error response
            return response()->json(['error' => 'An error occurred while loading data.'], 500);
        }
    }

    public function AddDooDuagSub(Request $request){
        try {
            $DooDuagdayID = $request->input('DooDuagdayID');
            $subtime = $request->input('DooDuagSubTime');
            $subtimename = $request->input('DooDuagSubTimeName');
            $sql = DB::select("CALL usp_AddDooDuagSub(?,?,?)", [$DooDuagdayID,$subtime,$subtimename]);

            
            $data = [
                'data' => $sql[0]->MESSAGE
            ];
          

            return response()->json($data, 200);
           
        } catch (\Exception $e) {
            // Handle the exception, for example, log the error
            Log::error('Error in : ' . $e->getMessage());

            // Return an appropriate error response
            return response()->json(['error' => 'An error occurred while loading data.'], 500);
        }
    }

    public function RemoveDooDuagSub(Request $request){
        try {
            $DooDuagSubID = $request->input('DooDuagSubID');
            $sql = DB::select("CALL usp_RemoveDooDuagSub(?)", [$DooDuagSubID]);

            
            $data = [
                'data' => $sql[0]->MESSAGE
            ];
            

            return response()->json($data, 200);
           
        } catch (\Exception $e) {
            // Handle the exception, for example, log the error
            Log::error('Error in : ' . $e->getMessage());

            // Return an appropriate error response
            return response()->json(['error' => 'An error occurred while loading data.'], 500);
        }
    }
    
    

    // End-Settingpage

    // Start-Transectionpage

    
    public function homecustomer(Request $request)
    {
        $title  = '';

        // $password = $request->input('password');

        $title  = 'หน้าหลัก || จองคิวดูดวง';
        return view('dooduag.transectionpage.index',compact('title'));

    }


    public function LoadDooDuagAll(Request $request){
        
            $MonthObject = [
                '01'=>'มกราคม',
                '02'=>'กุมภาพันธ์',
                '03'=>'มีนาคม',
                '04'=>'เมษายน',
                '05'=>'พฤษภาคม',
                '06'=>'มิถุนายน',
                '07'=>'กรกฎาคม',
                '08'=>'สิงหาคม',
                '09'=>'กันยายน',
                '10'=>'ตุลาคม',
                '11'=>'พฤศจิกายน',
                '12'=>'ธันวาคม',
            ];
            $DayObject = [
                '1'=>'วันจันทร์',
                '2'=>'วันอังคาร',
                '3'=>'วันพุธ',
                '4'=>'วันพฤหัส',
                '5'=>'วันศุกร์',
                '6'=>'วันเสาร์',
                '7'=>'วันอาทิตย์',
            ];

            $SelYear = $request->input('SelYear');
            $SelMonth = $request->input('SelMonth');
            $monthname = $MonthObject[$SelMonth];

            $yearstart = $SelYear;
            $yearend = $SelYear;
            $itemNot = [];
            $notuse = DB::select("SELECT DooDuagDayID, IsActive FROM Z_Master_DooDuagMain");
            foreach ($notuse as $new) {
                $itemNot[$new->DooDuagDayID] = $new->IsActive;
            }


            $divsub = "<div class='table-responsive' style='height:490px;'>";
            $divsub .= "<table class='table' id='TableDooDuagShow' style='width:100%;'>";
            $divsub .= "<thead>";

            $divsub .= "<tr><th><h3>$monthname</h3></th></tr>";
            $divsub .= "</thead>";
            $divsub .= "<tbody>";
        
            for ($year = $yearstart; $year <= $yearend; $year++) {
                $buddit = $year + 543;        
                // $divsub .= '<tr>';
                // $divsub .= "<td><h2> $year ($buddit)</h2></td>";
                // $divsub .= '</tr>';
                if($year == $yearstart){
                    $months = $SelMonth;
                }else{
                    $months = $SelMonth;
                }

                for($mo = $months ; $mo <= $SelMonth ; $mo++){
                    
            
                    $m_use = sprintf('%02d',$mo);
                    $divsub .= '<tr>';
                    $divsub .= "<td><div class='row'>";
                    
                    $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $mo, $year);

                    // ลูปเดือนปัจจุบัน
                    $tomonth = $year.'-'.$m_use;

                    // ค้นหาเดือนนี้กับเดือนหน้า
                    
                    $monthcur = date('Y-m');
                    $monthnext = date('Y-m', strtotime('+1 month'));


                    if($tomonth == $monthcur){
                        $daystart = date('d');
                    }else{
                        $daystart = 1;
                    }

                    for($day = $daystart ; $day <=$numberOfDays ;$day++){

                        $formattedDay = sprintf('%02d', $day);
                        // Ex. 2024-01-01
                        $today = $tomonth . '-' . $formattedDay;
                        
                        // Get the numeric representation of the day of the week (0 for Sunday through 6 for Saturday) +1 ด้วย เพราะจะเอาไปอิง DooDuagDayID เลย
                        $dayOfWeekNumeric = date('N', strtotime($today));
                        
                        // Assuming $DayObject is an array containing the names of days (e.g., ['Sun', 'Mon', ..., 'Sat'])
                        $toDays = $DayObject[$dayOfWeekNumeric];

                        //หาจำนวนคงเหลือ




                        // if($tomonth == $monthcur || $tomonth == $monthnext){
                        //     $remainDays = DB::select("CALL usp_LoadRemainDays(?,?)", [$dayOfWeekNumeric,$today]);

                        //     if($remainDays[0]->Remain == 0){
                        //         $disabled = 'disabled';
                        //     }else{
                        //         $disabled = '';
                        //     }

                        //     $par = "$formattedDay ($toDays)<br>คงเหลือ ".$remainDays[0]->Remain;
                        // }else{
                        //     $disabled = '';
                        //     $par = "$formattedDay ($toDays)";
                        // }
                       
                        $remainDays = DB::select("CALL usp_LoadRemainDays(?,?)", [$dayOfWeekNumeric,$today]);

                            if($remainDays[0]->Remain == 0){
                                $disabled = 'disabled';
                            }else{
                                $disabled = '';
                            }

                        $par = $toDays ."ที่ $formattedDay $monthname <br>คิวคงเหลือ ".$remainDays[0]->Remain;

                        if ($itemNot[$dayOfWeekNumeric] == 0) {}else{
                            $divsub .= "<div class='col-12'>
                            <button 
                            class='text-left btn btn-sm btn-secondary mr-2 mb-2' 
                            style='width:100%;' 
                            data-dooduagdate='$today'
                            data-dooduagday='$dayOfWeekNumeric'
                            $disabled
                            onclick='LoadDooDuagTime(this)'
                            >
                            $par
                            </button>
                            </div>";
                        }
                           
                        
                        
                    }

                    $divsub .= '</div></td></tr>';

                }
               

            }
            $divsub .= "</tbody>";
            $divsub .= "</table></div>";
        

            $data = [
                'data' => $divsub
            ];
            

            return response()->json($data, 200);
           
        
    }

    
  
    public function LoadDooDuagTime(Request $request){
       
        $dooduagdate = $request->input('dooduagdate');
        $dooduagday = $request->input('dooduagday');
        $sql = DB::select("CALL usp_LoadDataTimeAll(?,?)", [$dooduagdate,$dooduagday]);
        $div = '';
            
        $div .= '<div class="table-responsive">';
        $div .= "<div class='row'>";
        foreach($sql as $key=>$row){
            if($row->DooDuagTranNo == ''){
                $disabled= '';
            }else{
                $disabled= 'disabled';
            }
            $div .= "<div class='col-2 mb-1 text-center'>";
            $div .= "<button width='100%' 
                                    class='btn btn-sm btn-secondary' 
                                    data-dooduagsubid ='" . $row->DooDuagSubID . "' 
                                    data-dooduagsubtime ='" . $row->DooDuagSubTime . "' 
                                    $disabled
                                    onclick='SelectDooDuagSub(this)'>" . $row->DooDuagSubTime . "</button>";
            $div .= "</div>";
        }
        
        $div .= "</div>";
        $div .= "</div>";
            
        $data = [
                'data' => $div
        ];
            

        return response()->json($data, 200);
           
       
    }
    public function SaveDooDuagTran(Request $request){
        $DooDuagSubID = $request->input('DooDuagSubID');
        $DooDuagSubShow = $request->input('DooDuagSubShow');
        $DooDuagCustomerName = $request->input('DooDuagCustomerName');
        $DooDuagCustomerTel = $request->input('DooDuagCustomerTel') ;
        $DooDuagCustomerAge = $request->input('DooDuagCustomerAge');
        $DooDuagCustomerEmail = $request->input('DooDuagCustomerEmail');
        $DooDuagTranDate = $request->input('DooDuagTranDate');
        $sql = DB::select("CALL usp_SaveDooDuagTran(?,?,?,?,?,?)", [$DooDuagSubID,$DooDuagCustomerName,$DooDuagCustomerTel,$DooDuagCustomerAge,$DooDuagCustomerEmail,$DooDuagTranDate]);

        $data = [
                'data' => $sql[0]->MESSAGE,
                'DooDuagTranNo' => $sql[0]->DooDuagTranNo
        ];
            

        return response()->json($data, 200);
    }
    public function LoadListCustomer(Request $request){
        
        $sql = DB::select("CALL usp_LoadListCustomer");

        $styleth = "background:#333;color:#fff;";
        $div ="";
        $div .= "<table class='table table-bordered table-hover' id='TableDooDuagCustomer' style='width:100%;'>";
        $div .="<thead>";
        $div .="<tr>";
        $div .="<th style='$styleth'>รายการ</th>";
        $div .="</tr>";
        $div .="</thead>";
        $div .="<tbody>";
        $i = 1;
        foreach($sql as $key=>$row){
            $link =  "<button type='button' class='btn btn-md btn-danger' data-dooduagtranid='".$row->DooDuagTranID."' onclick='RemoveCustomer(this);'>ยกเลิก</button>";
            $div .="<tr>";
            $div .="<td><h4>".$i.".".$row->DooDuagCustomerName."</h4>";
            $div .="<p style='font-size:20px;'>".$row->DoDuagDayName1." / ".$row->DooDuagTranDate." / ".$row->DooDuagSubTime."</p>";
            $div .="<p style='color:#c00;'>".$row->DooDuagTranNo."</p>";
            $div .="<p>".$row->DooDuagCustomerTel."</p>";
            $div .="<p>".$link."</p> ";
            $div .="</td></tr>";
            $i++;
        }
        $div .="</tbody>";
        $div .="</table>";
        $data = [
                'data' => $div,
        ];
            

        return response()->json($data, 200);
    }
    

    public function RemoveCustomer(Request $request){
        $dooduagtranid = $request->input('dooduagtranid');

        
        $sql = DB::select("CALL usp_RemoveCustomer(?)",[$dooduagtranid]);

        $data = [
            'data' => $sql[0]->MESSAGE
        ];
        

        return response()->json($data, 200);
    }

}



   

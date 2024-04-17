<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlusModel;
use Illuminate\Support\Facades\DB;
// Using the Session facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use App\Libraries\Image\ImageFacade;

class MainController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Bangkok');

    }
    public function dashbord(){
        return view('user.home');
    }
    
    public function load_page1(){
        return view('user.page1');
    }
    public function load_page2(){
        return view('admin.page2');
    }
    public function load_page3(){

        $MST_WORK = DB::table('TB_MST_WORK')
                    ->select('WK_ID','WK_NAME')
                    ->whereRaw('WK_ID NOT IN(1,5)')
                    ->get();
        return view('user.page3')
        ->with('MST_WORK',$MST_WORK)
        ;
        
    }


    public function load_location(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $userid = $request->input('userid');

        // ตรวจสอบตำแหน่งที่ต้องการกับตำแหน่งปัจจุบันที่รับมา
        // ในที่นี้ให้ตรวจสอบระยะห่างไม่เกิน +- 100 เมตร
        $LA1 = ($latitude - 0.0009);
        $LA2 = ($latitude + 0.0009);
        $LO1 = ($longitude - 0.0009);
        $LO2 = ($longitude + 0.0009);
        $result = DB::table('TB_MST_SHOP')
        ->select('SHO_ID', 'SHO_NAME')
        ->whereRaw("REPLACE(TRIM(SHO_LATITUDE), ' ', '') BETWEEN ? AND ?", [$LA1, $LA2])
        ->whereRaw("REPLACE(TRIM(SHO_LONGITUDE), ' ', '') BETWEEN ? AND ?", [$LO1, $LO2])
        ->where('FLAG', 1)
        ->get();
        // dd($result);
        $dates = date('Y-m-d');

        $html = [];
        $TRN = [];
        if(empty($result[0])){
            $html = [
                'shop'=>'ไม่พบสถานที่ กรุณาอยู่ในพื้นที่ ไม่เกิน 100 เมตร',
                'sho_id'=>null,
            ];
            $TRN = [
                'MA_ID'=>null,
                'WI_ID'=>null,
                'WK_NAME'=>null,
                'COUNT_SHO'=>null
            ]; 
        }else{
            $html = [
                'shop'=>$result[0]->SHO_NAME,
                'sho_id'=>$result[0]->SHO_ID,
            ];
            $MAIN = DB::table('TB_TRN_MAINTIME as a')
            ->select('a.MA_ID', 'a.WK_ID', 'd.WK_NAME')
            ->leftJoin('TB_MST_WORK AS d', 'a.WK_ID', '=', 'd.WK_ID')
            ->where('a.USR_ID', $userid)
            ->where('a.MA_DT', $dates)
            ->whereRaw('a.ST_ID IN(1,2)')
            ->get();

            // dd($MAIN);
            
                if(!empty($MAIN[0])){
                    $SHO_ID = empty($result[0]->SHO_ID)?null:$result[0]->SHO_ID;
                    $trnsho = DB::table('TB_TRN_SUBTIME as a')
                    ->select('a.*', 'b.SHO_NAME', 'c.TC_NAME')
                    ->leftJoin('TB_MST_SHOP as b', 'a.SHO_ID', '=', 'b.SHO_ID')
                    ->leftJoin('TB_MST_TYPE_CHECK as c', 'a.TC_ID', '=', 'c.TC_ID')
                    ->where('MA_ID', $MAIN[0]->MA_ID)
                    ->where('a.SHO_ID', $SHO_ID)
                    ->get();
                    $TRN = [
                        'MA_ID'=>$MAIN[0]->MA_ID,
                        'WI_ID'=>$MAIN[0]->WK_ID,
                        'WK_NAME'=>$MAIN[0]->WK_NAME,
                        'COUNT_SHO'=>COUNT($trnsho)
                    ]; 
                }else{
                    $TRN = [
                        'MA_ID'=>null,
                        'WI_ID'=>null,
                        'WK_NAME'=>null,
                        'COUNT_SHO'=>0
                    ]; 
                }
          
        }

        
        return response()->json(['location' => $html,'dataall'=>$TRN]);
    }
    

    public function trnsave1(Request $request)
    {
        $input = $request->all();
        dd($input);
        $trnmain = DB::table('TB_TRN_MAINTIME')
                    ->select('MA_ID')
                    ->where('MA_DT', date('Y-m-d'))
                    ->where('USR_ID', $input['user_id'])
                    ->whereRaw('ST_ID IN(1,2)')
                    ->get();

        if(empty($trnmain[0]->MA_ID)){
            $TRN1 = [
                'USR_ID'=>$input['user_id'],
                'WK_ID'=>1,
                'MA_DAY'=>date('d'),
                'MA_MONTH'=>date('m'),
                'MA_YEAR'=>date('Y'),
                'MA_DT'=>date('Y-m-d'),
                'MA_ALL_HOURS'=>9,
                'ST_ID'=>1,
                'CR_DT'=>date('Y-m-d H:i:s'),
                'CR_ID'=>$input['user_id'],
            ];
            $MA_ID= DB::table('TB_TRN_MAINTIME')
            ->insertGetId($TRN1);
        }else{
            $MA_ID = $trnmain[0]->MA_ID;
        }
        $TRN1SUB = [
            'MA_ID'=>$MA_ID,
            'SHO_ID'=>$input['sho_id'],
            'SU_PIC_TIME'=>date('Y-m-d H:i:s'),
            'SU_LATITUDE'=>$input['latitude'],
            'SU_LONGITUDE'=>$input['longitude'],
            'CR_DT'=>date('Y-m-d H:i:s'),
            'CR_ID'=>$input['user_id'],
        ] ;

        $TRN1_1 = DB::table('TB_TRN_SUBTIME')
                    ->select('SU_ID')
                    ->where('MA_ID',$MA_ID)
                    ->where('SHO_ID',$input['sho_id'])
                    ->get();
        
        if(COUNT($TRN1_1) == 0){
                $folderPath = storage_path('app/public/in');
                if (File::exists($folderPath)) {
                    // โฟลเดอร์ 'out' อยู่ใน storage path
                    // ทำสิ่งที่คุณต้องการทำที่นี่
                } else {
                    // โฟลเดอร์ 'out' ไม่อยู่ใน storage path
                    File::makeDirectory($folderPath, 0755, true, true);
                    // ทำสิ่งที่คุณต้องการทำหลังจากสร้างโฟลเดอร์ 'out' ที่นี่
                }
                if ($request->hasFile('file1')) {
                    $file = $request->file('file1');
                    $filename = 'in_' . time() . '.' . $file->getClientOriginalExtension();
                    // โหลดรูปภาพจากไฟล์
                    $image = imagecreatefromstring(file_get_contents($file->getPathname()));

                    // ปรับขนาดรูปภาพ
                    $width = 800; // กำหนดความกว้างที่ต้องการ
                    $height = null; // กำหนดความสูงเป็น null เพื่อรักษาอัตราส่วน
                    $aspectRatio = imagesx($image) / imagesy($image);
                    $newWidth = $width;
                    $newHeight = $height === null ? intval($newWidth / $aspectRatio) : $height;
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($image), imagesy($image));

                    // สร้างตัวแปรเพื่อเก็บ path ของไฟล์ที่ปรับขนาดแล้ว
                    $resizedFilePath = storage_path('app/public/in/'. $filename);

                    // บันทึกไฟล์ที่ปรับขนาดแล้ว
                    imagejpeg($newImage, $resizedFilePath, 90);

                    // ล้างหน่วยความจำที่ใช้งานของรูปภาพ
                    imagedestroy($image);
                    imagedestroy($newImage);


                    $TRN1SUB += [
                        'TC_ID' => 1,
                        'SU_PIC' => $filename,
                    ];
                    DB::table('TB_TRN_SUBTIME')
                        ->insert($TRN1SUB);
                }   
            }else{
                $folderPath = storage_path('app/public/out');
                if (File::exists($folderPath)) {
                    // โฟลเดอร์ 'out' อยู่ใน storage path
                    // ทำสิ่งที่คุณต้องการทำที่นี่
                } else {
                    // โฟลเดอร์ 'out' ไม่อยู่ใน storage path
                    File::makeDirectory($folderPath, 0755, true, true);
                    // ทำสิ่งที่คุณต้องการทำหลังจากสร้างโฟลเดอร์ 'out' ที่นี่
                }
                if ($request->hasFile('file1')) {
                    $file = $request->file('file1');
                    $filename = 'out_' . time() . '.' . $file->getClientOriginalExtension();

                   // โหลดรูปภาพจากไฟล์
                    $image = imagecreatefromstring(file_get_contents($file->getPathname()));

                    // ปรับขนาดรูปภาพ
                    $width = 800; // กำหนดความกว้างที่ต้องการ
                    $height = null; // กำหนดความสูงเป็น null เพื่อรักษาอัตราส่วน
                    $aspectRatio = imagesx($image) / imagesy($image);
                    $newWidth = $width;
                    $newHeight = $height === null ? intval($newWidth / $aspectRatio) : $height;
                    $newImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($image), imagesy($image));

                    // สร้างตัวแปรเพื่อเก็บ path ของไฟล์ที่ปรับขนาดแล้ว
                    $resizedFilePath = storage_path('app/public/out/'. $filename);

                    // บันทึกไฟล์ที่ปรับขนาดแล้ว
                    imagejpeg($newImage, $resizedFilePath, 90);

                    // ล้างหน่วยความจำที่ใช้งานของรูปภาพ
                    imagedestroy($image);
                    imagedestroy($newImage);


                    $TRN1SUB += [
                        'TC_ID' => 2,
                        'SU_PIC' => $filename,
                        'SU_REMARK'
                    ];
                    DB::table('TB_TRN_SUBTIME')
                        ->insert($TRN1SUB);
                }   
        }
        
        

        return COUNT($TRN1_1);
        
    }
    public function trnsave2(Request $request){
        $input = $request->all();
        $year = $input['year']; // ปีที่ต้องการหาวัน

        foreach($input['months'] as $key=>$row){ // MULTIPLE MONYHS

        $month = $row; // เดือนที่ต้องการหาวัน
        $startDate = '01';
        $endDate = date('t',strtotime("$year-$month"));
        // echo $startDate.'<br>';


            $users = DB::table('TB_TRN_DAYOFF as a')
            ->select('a.USR_ID', 'b.DO_NAME')
            ->leftJoin('TB_MST_DAYOFF as b', 'a.DO_ID', '=', 'b.DO_ID')
            ->groupBy('a.USR_ID', 'b.DO_NAME')
            ->get();
            foreach($users as $val){ // TB_TRN_DAYOFF
                $usr_id = $val->USR_ID;
                $dayoff = $val->DO_NAME;
                // echo $usr_id.'<br>';
                $this->genarate_val($startDate,$endDate,$month,$year,$usr_id,$dayoff);
            }

        }
        
    }

    public function trnsave3(Request $request){

        $input = $request->all();
        // dd($input);
        $data = [];
        $I = 0;

        if($input['TYPE'] == 'ALLDAY'){
            $DATE = explode(', ',$input['MA_DT_1']);
            $MA = [
                'USR_ID'=>$input['user_id'],
                'WK_ID'=>$input['WK_ID_1'],
                'MA_REMARK'=>empty($input['MA_REMARK_1'])?null:$input['MA_REMARK_1'],
                'MA_ALL_HOURS'=>24,
                'CR_DT'=>date('Y-m-d H:i:s'),
                'CR_ID'=>$input['user_id']
            ];
            foreach ($DATE as $key => $value) {
                $check = DB::table('TB_TRN_MAINTIME')
                ->select(DB::raw('COUNT(*) as COUNT'))
                ->where('MA_DT',$value)
                ->where('WK_ID',$input['WK_ID_1'])
                ->get();
                if($check[0]->COUNT == 0){
                    $DAY = date("d",strtotime($value));
                    $MONTH = date("m",strtotime($value));
                    $YEAR = date("Y",strtotime($value));
                    $MA += [
                        'MA_DAY'=>$DAY,
                        'MA_MONTH'=>$MONTH,
                        'MA_YEAR'=>$YEAR,
                        'MA_DT'=>$value
                    ];
                    DB::table('TB_TRN_MAINTIME')
                    ->insert($MA);
                }else{
                    $I++;
                }
            }
            $data += [
                'error'=>$I,
            ];
        }elseif($input['TYPE'] == 'HOUR'){
            $DATE = $input['MA_DT_2'];
            
            
                $check = DB::table('TB_TRN_MAINTIME')
                        ->select('MA_ID')
                        ->where('WK_ID',$input['WK_ID_2'])
                        ->where('MA_DT',$DATE)
                        ->get();

                if(empty($check[0])){
                    $DAY = date("d",strtotime($DATE));
                    $MONTH = date("m",strtotime($DATE));
                    $YEAR = date("Y",strtotime($DATE));

                    $calhours = $this->CAL_HOURS($input['SU_PIC_TIME_START'],$input['SU_PIC_TIME_END']);
                    $MA = [
                        'USR_ID'=>$input['user_id'],
                        'WK_ID'=>$input['WK_ID_2'],
                        'MA_DAY'=>$DAY,
                        'MA_MONTH'=>$MONTH,
                        'MA_YEAR'=>$YEAR,
                        'MA_DT'=>$DATE,
                        'MA_ALL_HOURS'=>$calhours,
                        'MA_REMARK'=>empty($input['MA_REMARK_2'])?null:$input['MA_REMARK_2'],
                        'CR_DT'=>date('Y-m-d H:i:s'),
                        'CR_ID'=>$input['user_id'],
                    ];
                    $MA_ID = DB::table('TB_TRN_MAINTIME')
                    ->insertGetId($MA);
                }else{
                    $MA_ID = $check[0]->MA_ID;
                }

                $SUB = $TRN1_1 = DB::table('TB_TRN_SUBTIME')
                                ->select('SU_ID')
                                ->where('MA_ID',$MA_ID)
                                ->get();
                if(empty($SUB[0]->SU_ID)){
                    $SU_START = [
                        'MA_ID'=>$MA_ID,
                        'TC_ID'=>3,
                        'SU_PIC_TIME'=>$input['SU_PIC_TIME_START'],
                        'CR_DT'=>date('Y-m-d H:i:s'),
                        'CR_ID'=>$input['user_id'],
                    ];
                    DB::table('TB_TRN_SUBTIME')
                    ->insert($SU_START);
                    $SU_END = [
                        'MA_ID'=>$MA_ID,
                        'TC_ID'=>4,
                        'SU_PIC_TIME'=>$input['SU_PIC_TIME_END'],
                        'CR_DT'=>date('Y-m-d H:i:s'),
                        'CR_ID'=>$input['user_id'],
                    ];
                    DB::table('TB_TRN_SUBTIME')
                    ->insert($SU_END);
                }else{
                    $I++;
                }

                $data += [
                    'error'=>$I,
                ];
            
        }

        return $data;

    }
    public function load_wk_dash(Request $request)
    {
        $input = $request->all();
        $year = date('Y');
        $month = $input['month'];
        $user_id = $input['user_id'];
        $TRN_WK = DB::select("WITH MST_WK AS (
            SELECT WK_ID, WK_NAME
            FROM TB_MST_WORK
            WHERE WK_ID NOT IN (1, 5)
        ),
        TRN_MAIN AS (
            SELECT a.WK_ID, SUM(a.MA_ALL_HOURS) AS ALL_HOURS, a.USR_ID
            FROM TB_TRN_MAINTIME a
            LEFT JOIN MST_WK b ON a.WK_ID = b.WK_ID
            WHERE a.USR_ID = '$user_id' AND a.MA_MONTH = '$month' AND a.MA_YEAR = '$year' AND a.ST_ID IN(2)
            GROUP BY a.WK_ID, a.USR_ID
        )
        SELECT a.*, b.ALL_HOURS, b.USR_ID
        FROM MST_WK a
        LEFT JOIN TRN_MAIN b ON a.WK_ID = b.WK_ID;");
        
        $td = '';
        foreach ($TRN_WK as $row) {
            $td .= '<tr>';
            $td .= '<td>' . $row->WK_NAME . '</td>';
            $td .= '<td>' . $this->convertHoursToDaysHours($row->ALL_HOURS) . '</td>';
            $td .= '</tr>';
        }
        return $td;
   
    }

    public function load_wk(Request $request)
    {
        $input = $request->all();
        $year = date('Y');
        $month = $input['month'];
        $user_id = $input['user_id'];

        $maintrn = DB::select("SELECT a.*,b.WK_NAME FROM TB_TRN_MAINTIME a
                LEFT JOIN TB_MST_WORK b ON (a.WK_ID=b.WK_ID)
                LEFT JOIN TB_MST_STATUS c ON (a.ST_ID=c.ST_ID)
                WHERE
                1=1
                AND a.MA_YEAR = '$year'
                AND a.MA_MONTH = '$month'
                AND a.USR_ID = '$user_id'
                AND a.WK_ID NOT IN(1,5)
                ");
                
        $td = '';   
        if(!empty($maintrn[0])){
            foreach($maintrn as $M => $val){
                if($val->ST_ID == 3){
                    $btn = "<button class='btn btn-sm btn-secondary'><i class='bx bxs-trash'></i></button>";
                    $status = "<span class='badge bg-label-warning'>รออนุมัติ</span>";
                }elseif($val->ST_ID == 2){
                    $btn = "";
                    $status = "<span class='badge bg-label-success'>อนุมัติ</span>";
                }elseif($val->ST_ID == 4){
                    $btn = "";
                    $status = "<span class='badge bg-label-danger'>ไม่อนุมัติ</span>";
                }
                $td .="<tr>";
                $td .="<td colspan='2'>".$val->WK_NAME."<br>".$this->dateThai($val->MA_DT)."</td>";
                $td .="<td >$status</td>";
                $td .="<td >$btn</td>";
                $td .="</tr>";
                $sub = DB::select("SELECT b.TC_NAME,a.SU_PIC_TIME FROM TB_TRN_SUBTIME a
                LEFT JOIN TB_MST_TYPE_CHECK b ON (a.TC_ID=b.TC_ID)
                WHERE
                1=1
                AND a.MA_ID IN(".$val->MA_ID.")");
                    
                    if(!empty($sub[0])){
                        foreach($sub as $S => $val2){
                            $td .="<tr>";
                            $td .="<td class='text-end'>".$val2->TC_NAME."</td>";
                            $td .="<td class='text-end'>".$val2->SU_PIC_TIME."</td>";
                            $td .="<td class='text-end'></td>";
                            $td .="<td class='text-end'></td>";
                            $td .="</tr>";
                        }
                    }
            }   
        }else{
            $td .="<tr>";
            $td .="<td colspan='2' class='text-center'>ไม่มีข้อมูล</td>";
            $td .="</tr>";
        }
        

        return $td;


    }





    //***************************************************************** MST ****************************/ 
    public function CAL_HOURS($startTIME,$endTIME){
        $startHour = intval($startTIME);
        $endHour = intval($endTIME);

        $hours = $endHour - $startHour;

        return $hours;
    }
    
    public function dateThai($date)
    {
        $months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $day = date('d', strtotime($date));
        $month = date('n', strtotime($date));
        $year = date('Y', strtotime($date)) + 543; // Convert to Thai year
    
        return $day . ' ' . $months[$month - 1] . ' ' . $year;
    }
    public function convertHoursToDaysHours($hours)
    {
        $days = floor($hours / 24);
        $remainingHours = $hours % 24;
    
        $formattedTime = '';
    
        if ($days > 0) {
            $formattedTime .= $days . ' วัน ';
        }
    
        $formattedTime .= $remainingHours . ' ชั่วโมง';
    
        return $formattedTime;
    }





    public function genarate_val($startDate,$endDate,$month,$year,$usr_id,$dayoff){
        for ($i = $startDate ;$i<= $endDate ;$i++) {
            $currentDate ="$year-$month-".sprintf('%02d',$i);
            $currentDay = date('D', strtotime($currentDate));
            echo $currentDate.'<br>';
            if($currentDay == $dayoff){
                $res = DB::table('TB_TRN_MAINTIME')
                ->selectRaw('COUNT(*) as COUNTS')
                ->where('USR_ID',$usr_id)
                ->where('MA_DT',$currentDate)
                ->where('WK_ID',5)
                ->get();
                if($res[0]->COUNTS == 0){
                    $TRN5 = [
                        'USR_ID'=>$usr_id,
                        'WK_ID'=>5,
                        'MA_DAY'=>date('d',strtotime($currentDate)),
                        'MA_MONTH'=>date('m',strtotime($currentDate)),
                        'MA_YEAR'=>date('Y',strtotime($currentDate)),
                        'MA_ALL_HOURS'=>0,
                        'ST_ID'=>1,
                        'MA_DT'=>$currentDate,
                        'CR_DT'=>date('Y-m-d'),
                        'CR_ID'=>$usr_id,
                    ];
                    DB::table('TB_TRN_MAINTIME')
                    ->insert($TRN5);
                }
            }
        }
    }
    
}

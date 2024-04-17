<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use PDF;
ini_set('memory_limit', '1024M'); // เพิ่มเป็น 1 GB
set_time_limit(180); // เพิ่มเวลาการทำงานเป็น 180 วินาที
date_default_timezone_set('Asia/Bangkok');

class ResellerController extends Controller
{
    public $headers;
    public function __construct()
    {
        // $this->middleware('cors');
        $this->headers = [];
    }
    public function login(){
        return view('reseller.auth.login');
    }
    public function checklogin(Request $request){

        $input = $request->all();
        $USR = DB::select("WITH USR AS (SELECT id,name,ResellerCode FROM TB_DBO_USR WHERE username = '".$input['username']."' AND password = '".$input['password']."')
        SELECT * FROM USR ");
        if(!empty($USR)){
            // Session::put('USR',$USR[0]);
           
            return response()->json(['status' => 'OK','result'=>'active-user','data'=>$USR[0]], 200);


        }else{
            return response()->json(['status' => 'OK','result'=>'not-user'], 200);
        }
        // return view('login.login');
    }
    public function home(){
        return view('reseller.home');
    }
    

    public function ManageProduct(Request $request)
    {
        
        return view('reseller.ManageProduct.index');

    }
    
    public function AddDataCustomer(Request $request)
    {
        $CustomerName = $request->input('CustomerName');
        $dbo_usr = $request->input('dbo_usr');
        $smtp = date('Y-m-d H:i:s');

        $insert = [
            'CustomerName'=> $CustomerName,
            'Status'=> 1,
            'CreateBy'=> $dbo_usr['id'],
            'UpdateBy'=> $dbo_usr['id'],
            'CreateDate'=> $smtp,
            'UpdateDate'=> $smtp,
        ];

        DB::table('TB_Customer')
        ->insert($insert);

        $data=[
            'message'=>'success'
        ];
        return response()->json($data, 200);
    }
    public function loadDataCustomer(Request $request)
    {

        $sql = DB::select("SELECT * FROM TB_Customer ORDER BY CreateDate DESC");

        $div = '';

        foreach($sql as $key=>$row){
            $CustomerID = $row->CustomerID;

            $dataCustomerAddress = DB::select("SELECT ca.AddressID,ca.AddressText,tz.ZIP_CODE,tt.TUM_SUBJECT,ta.AMP_SUBJECT,tp.PRV_SUBJECT FROM TB_CustomerAddress ca
            LEFT JOIN TB_ZIPCODE tz ON (tz.ZIP_CODE = ca.AddressZipCode)
            LEFT JOIN TB_TUMBON tt ON (tz.ZIP_ID=tt.ZIP_ID)
            LEFT JOIN TB_AMPHOR ta ON (tt.AMP_ID=ta.AMP_ID)
            LEFT JOIN TB_PROVINCE tp ON (ta.PRV_ID=tp.PRV_ID)
            WHERE CustomerID = $CustomerID");
            



            $div .= "<tr>";
            $div .= "<td>".$row->CustomerName."</td>";
            $div .= "<td>";

            if(!empty($dataCustomerAddress)){
                foreach($dataCustomerAddress as $row1){
                    $div .= "<b>- ".$row1->AddressText." ".$row1->AMP_SUBJECT." ".$row1->TUM_SUBJECT." ".$row1->PRV_SUBJECT." ".$row1->ZIP_CODE."<br><button class='btn btn-sm btn-secondary' data-customerid='$row->AddressID' >แก้ไข</button> 
                    <button class='btn btn-sm btn-secondary' data-customerid='$row->AddressID' onclick='DelCustomerAddress(this)'>ลบ</button></b>";
                }
            }
           
            $div .= "</td>";

            $div .= "<td><button class='btn btn-sm btn-secondary' data-customerid='$CustomerID'  onclick='AddCustomerAddress(this)'>เพิ่มที่อยู่ใหม่</button> <button class='btn btn-sm btn-secondary' data-customerid='$CustomerID' onclick='DelCustomer(this)'>ลบลูกค้า</button></td>";

            $div .= "</tr>";

        }
       

        $data=[
            'message'=>$div
        ];
        return response()->json($data, 200);
    }


    // /////
    // public function pdftest() 
    // {
    //     $html = '<h1 style="color:red;">Hello World</h1>';
        
    //     PDF::SetTitle('Hello World');
    //     PDF::AddPage();
    //     PDF::writeHTML($html, true, false, true, false, '');

    //     PDF::Output('hello_world.pdf');
    // }

    // public function playground() 
    // {
       
    //     $title  = 'Table League';
    //     return view('playground.index',compact('title'));
        
    // }



    // //END VIEW //


    // public function splitArray($totalRecords){
    //     $chunkSize = 300;
    //     $chunks = [];

    //     for ($start = 1; $start <= $totalRecords; $start += $chunkSize) {
    //         $end = min($start + $chunkSize - 1, $totalRecords);
    //         $chunks[] = ['start' => $start, 'end' => $end];
    //     }
    //     return $chunks;
    // }


    // public function loadMainGI(Request $request)
    // {

    //     $get = DB::select("SELECT * FROM TBL_GI_MAIN ORDER BY M_CODE DESC");
    //     $baseurl = "/plus/loadsubgi";
    //     // dd($get);
    //     $styleth = "background:#333;color:#fff;";
    //     $div ="";
    //     $div .= "<table class='table table-bordered table-hover' width='100%' id='TableMain'>";
    //     $div .="<thead>";
    //     $div .="<tr>";
    //     $div .="<th style='$styleth'>#</th>";
    //     $div .="<th style='$styleth'>รหัส</th>";
    //     $div .="<th style='$styleth'>ชื่อ</th>";
    //     $div .="<th style='$styleth'>DateTime</th>";
    //     $div .="<th style='$styleth'>AI ตรวจ</th>";
    //     $div .="<th style='$styleth'>Action</th>";
    //     $div .="<th style='$styleth width:200px'>Download</th>";
    //     $div .="</tr>";
    //     $div .="</thead>";
    //     $div .="<tbody>";
    //     $i = 1;
    //     foreach($get as $key=>$row){
    //         if($row->AI_STATUS != 'C'){
    //             $col = '';
    //             $link = "<button type='button' class='btn btn-md btn-dark' data-mcode='".$row->M_CODE."' onclick='LoadDropDrow_Reg(this);'>เลือกลิงค์นี้</button>";


    //             $totalrecord = DB::select("SELECT COUNT(*) AS TOTAL FROM TBL_GI WHERE M_CODE ='".$row->M_CODE."'");   
    //             $ARR = $this->splitArray($totalrecord[0]->TOTAL);


    //             $imgdownload[$key] = "<div style='height:100px;overflow-y:scroll;'>";
    //             foreach($ARR as $sp){
    //                 $imgdownload[$key] .= "<button type='button' class='btn btn-sm btn-dark' data-mcode='".$row->M_CODE."' 
    //                 data-start='".$sp['start']."'
    //                 data-end='".$sp['end']."'
    //                 onclick='ImgDownLoad(this);'>ดาวน์โหลดช่วง ".$sp['start']."-".$sp['end']."</button><br>";
    //             }
    //             $imgdownload[$key] .= "</div>";
    //             // $imgdownload[$key] = "";

    //             if($row->AI_STATUS == 'P'){
    //                 $col = "<div style='color:green;font-weight:500;'>AI PASS</div>";
    //             }else if ($row->AI_STATUS == 'N'){
    //                 $col = "<div style='color:#C00;font-weight:500;'>AI NOT PASS</div>";
    //             }else if ($row->AI_STATUS == 'C'){
    //                 $col = "<div style='font-weight:500;'>CLOSE</div>";
    //             }

    //             $div .="<tr>";
    //             $div .="<th>".$i."</th>";
    //             $div .="<th>".$row->M_CODE."</th>";
    //             $div .="<th>".$row->M_NAME."</th>";
    //             $div .="<th>".$row->SMTP."</th>";
    //             $div .="<th>".$col."</th>";
    //             $div .="<th>".$link."</th> ";
    //             $div .="<th>".$imgdownload[$key]."</th>";
    //             $div .="</tr>";
    //             $i++;
    //         }
    //     }
    //     $div .="</tbody>";
    //     $div .="</table>";
    //     echo $div;

    // }

    // public function uploadexcel(Request $request)
    // {

    //         if ($request->hasFile('M_EXCEL')) {
    //             $file = $request->file('M_EXCEL');
    //             $path = $file->getRealPath();

    //             $spreadsheet = IOFactory::load($path);
    //             $worksheet = $spreadsheet->getActiveSheet();
    //             $highestRow = $worksheet->getHighestRow();

    //             $data = [];
    //             $maxValue = DB::table('TBL_GI_MAIN')->max('M_ID');
    //             $datamain = $maxValue + 1;
    //             $loadmax = 'AI'.date('ymd'). sprintf('%04d', $datamain);

    //             for ($row = 2; $row <= $highestRow; $row++) {
    //                         $GI_SECTION = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    //                         $GI_PRV =  $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    //                         $GI_REG =  $worksheet->getCellByColumnAndRow(3, $row)->getValue();
    //                         $GI_DC =  $worksheet->getCellByColumnAndRow(4, $row)->getValue();
    //                         $GI_DCNAME =  $worksheet->getCellByColumnAndRow(5, $row)->getValue();
    //                         $GI_ROUTE =  $worksheet->getCellByColumnAndRow(6, $row)->getValue();
    //                         $GI_CUSCODE =  $worksheet->getCellByColumnAndRow(7, $row)->getValue();
    //                         $GI_CUSNAME =  $worksheet->getCellByColumnAndRow(8, $row)->getValue();
    //                         $GI_PERIOD =  $worksheet->getCellByColumnAndRow(9, $row)->getValue();
    //                         $GI_TYPE =  $worksheet->getCellByColumnAndRow(10, $row)->getValue();
    //                         $GI_TIME =  $worksheet->getCellByColumnAndRow(11, $row)->getValue();
    //                         $GI_AI =  $worksheet->getCellByColumnAndRow(12, $row)->getValue();
    //                         $GI_PIC =  $worksheet->getCellByColumnAndRow(13, $row)->getValue();
    //                         $GI_PIC2 =  $worksheet->getCellByColumnAndRow(14, $row)->getValue();
    //                         $GI_LATITUDE =  $worksheet->getCellByColumnAndRow(15, $row)->getValue();
    //                         $GI_LONGTITUDE =  $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    
    //                         $excelSerialNumber = $GI_TIME;
    //                         $formattedDate = date('Y-m-d H:i:s', strtotime($excelSerialNumber));
                      



    //                 $data[] = [
    //                     "GI_SECTION"  => $GI_SECTION,
    //                     "GI_PRV"  => $GI_PRV,
    //                     "GI_REG"  => $GI_REG,
    //                     "GI_ROUTE"  => $GI_ROUTE,
    //                     "GI_DC"  => $GI_DC,
    //                     "GI_DCNAME"  => $GI_DCNAME,
    //                     "GI_CUSCODE"  => $GI_CUSCODE,
    //                     "GI_CUSNAME"  => $GI_CUSNAME,
    //                     "GI_PERIOD"  => $GI_PERIOD,
    //                     "GI_AI"  => $GI_AI,
    //                     "GI_TYPE"  => $GI_TYPE,
    //                     "GI_PIC"  => $GI_PIC,
    //                     "GI_PIC2"  => $GI_PIC2,
    //                     "GI_LATITUDE"  => $GI_LATITUDE,
    //                     "GI_LONGTITUDE"  => $GI_LONGTITUDE,
    //                     "M_CODE" => $loadmax,
    //                     'GI_TIME' => $formattedDate
    //                 ];
    //             }
    //             // dd($data);

    //             DB::table('TBL_GI_MAIN')->insert([
    //                 'M_CODE' => $loadmax,
    //                 'M_DAY' => date('d'),
    //                 'M_MONTH' => date('m'),
    //                 'M_YEAR' => date('Y'),
    //                 'SMTP' => now(),
    //                 'QR_CODE' => null,
    //                 'M_NAME' =>  $request->input('M_NAME'),
    //             ]);

    //             DB::table('TBL_GI')->insert($data);

    //             return response()->json($data, 200);
    //         }

    //     }



    // public function LoadDropDrow_Reg(Request $request){
    //     $input = $request->input();
    //     $sql = DB::table('TBL_GI')
    //                 ->select('GI_REG')
    //                 ->where('M_CODE',$input['M_CODE_RECIVE'])
    //                 ->groupBy('GI_REG')
    //                 ->get();
    //     $output = '<option value="">กรุณาเลือก...</option>';
    //     foreach ($sql as $key => $value) {
    //         $output .= "<option value='".$value->GI_REG."'>".$value->GI_REG."</option>";
    //     }          

    //     $data = [
    //         'data'=> $output
    //     ];
    //     return response()->json($data, 200);
    // }     
    // public function LoadDropDrow_DC(Request $request){
    //     $input = $request->input();
    //     $sql = DB::table('TBL_GI')
    //                 ->select('GI_DC','GI_DCNAME')
    //                 ->where('M_CODE',$input['M_CODE_RECIVE'])
    //                 ->where('GI_REG',$input['GI_REG'])
    //                 ->groupBy('GI_DC','GI_DCNAME')
    //                 ->get();
    //     $output = '<option value="">กรุณาเลือก...</option>';
    //     foreach ($sql as $key => $value) {
    //         $output .= "<option value='".$value->GI_DC."'>".$value->GI_DC." : ".$value->GI_DCNAME."</option>";
    //     }          

    //     $data = [
    //         'data'=> $output
    //     ];
    //     return response()->json($data, 200);
    // }     

    // public function LoadDropDrow_Rouge(Request $request){
    //     $input = $request->input();
    //     $sql = DB::table('TBL_GI')
    //                 ->select('GI_ROUTE')
    //                 ->where('M_CODE',$input['M_CODE_RECIVE'])
    //                 ->where('GI_REG',$input['GI_REG'])
    //                 ->where('GI_DC',$input['GI_DC'])
    //                 ->groupBy('GI_ROUTE')
    //                 ->get();
    //     $output = '<option value="">กรุณาเลือก...</option>';
    //     foreach ($sql as $key => $value) {
    //         $output .= "<option value='".$value->GI_ROUTE."'>".$value->GI_ROUTE."</option>";
    //     }          

    //     $data = [
    //         'data'=> $output
    //     ];
    //     return response()->json($data, 200);
    // }  
    

    // public function Search_Data(Request $request){
    //     $M_CODE = $request->input('M_CODE_RECIVE');
    //     $GI_REG = $request->input('GI_REG');
    //     $GI_ROUTE = $request->input('GI_ROUTE');
    //     $GI_DC = $request->input('GI_DC');
    //     $USE_REG = '';
    //     $USE_CUS = '';
    //     $USE_DC = '';
        
    //     if (!empty($GI_REG) || $GI_REG != '') {
    //         $USE_REG = "AND GI_REG = '$GI_REG'";
    //     }
        
    //     if (!empty($GI_ROUTE) ||$GI_ROUTE != '') {
    //         $USE_CUS = "AND GI_ROUTE = '$GI_ROUTE'";
    //     }
        
    //     if (!empty($GI_DC) || $GI_DC != '') {
    //         $USE_DC = "AND GI_DC = '$GI_DC'";
    //     }
        
    //     $sql = "SELECT
    //         GI_ID,
    //         M_CODE,
    //         GI_SECTION,
    //         GI_PRV,
    //         GI_REG,
    //         GI_DC,
    //         GI_DCNAME,
    //         GI_ROUTE,
    //         GI_CUSCODE,
    //         GI_CUSNAME,
    //         GI_PERIOD,
    //         GI_TYPE,
    //         GI_TIME,
    //         GI_AI,
    //         GI_PIC2,
    //         GI_PIC,
    //         GI_TEXT,
    //         GI_C,
    //         GI_LATITUDE,
    //         GI_LONGTITUDE 
    //         FROM
    //             TBL_GI 
    //         WHERE
    //             1 = 1 
    //             AND M_CODE = '$M_CODE' 
    //             $USE_REG
    //             $USE_DC
    //             $USE_CUS";
        
    //     // You can use dd($sql) for debugging, but remember to remove it in production.
        
    //     $query = DB::select($sql);
        
    //     $styleth = "background:#333;color:#fff;";

    //     $output = "<table class='table table-bordered table-hover table-striped' style='width:100%;' id='TableSub'>
    //                 <thead>
    //                 <tr>
    //                 <th style='$styleth'>PERIOD</th>
    //                 <th style='$styleth'>PROVINCE</th>
    //                 <th style='$styleth'>REGION</th>
    //                 <th style='$styleth'>DC_CODE</th>
    //                 <th style='$styleth'>DC_NAME</th>
    //                 <th style='$styleth'>AUDITOR_ID</th>
    //                 <th style='$styleth'>CUSTOMER_CODE</th>
    //                 <th style='$styleth'>CUSTOMER_NAME</th>
    //                 <th style='$styleth'>DATETIME</th>
    //                 <th style='$styleth'>AI_ANSWER</th>
    //                 <th style='$styleth'>AI_CHECK</th>
    //                 <th style='$styleth'>LATITUDE</th>
    //                 <th style='$styleth'>LONGTITUDE</th>
    //                 <th style='$styleth width:300px;'>STORE PIC</th>
    //                 <th style='$styleth width:300px;'>PICTURE</th>
    //                 <th style='$styleth width:300px;'>NOTE</th>
    //                 </tr>
    //                 </thead>
    //                 <tbody>
    //                 ";

    //     foreach($query as $value){
    //         $output .= "<tr>
    //         <td style=''>".$value->GI_PERIOD."</td>
    //         <td style=''>".$value->GI_PRV."</td>
    //         <td style=''>".$value->GI_REG."</td>
    //         <td style=''>".$value->GI_DC."</td>
    //         <td style=''>".$value->GI_DCNAME."</td>
    //         <td style=''>".$value->GI_ROUTE."</td>
    //         <td style=''>".$value->GI_CUSCODE."</td>
    //         <td style=''>".$value->GI_CUSNAME."</td>
    //         <td style=''>".date('Y-m-d H:i:s',strtotime($value->GI_TIME))."</td>
    //         <td style=''>".$value->GI_TYPE."</td>
    //         <td style=''>".$value->GI_AI."</td>
    //         <td style=''>".$value->GI_LATITUDE."</td>
    //         <td style=''>".$value->GI_LONGTITUDE."</td>
    //         <td style=''><img width='300px' src='".($value->GI_PIC2)."'/></td>
    //         <td style=''><img width='300px' src='".($value->GI_PIC)."'/></td>
    //         <td style=''><textarea rows='5' style='width:400px;' class='form-control tx_".$value->GI_ID."' 
    //         onchange='Save_txt(this)'  data-giid='".$value->GI_ID."'>".$value->GI_TEXT."</textarea></td>
    //         </tr>";

    //     }
    //     $output .= "</tbody></table>";
    //     $data = [
    //         'data'=> $output
    //     ];
    //     return response()->json($data, 200);
    // }        

    // public function Save_txt(Request $request){
    //     $GI_ID = $request->input('GI_ID');
    //     $GI_TEXT = $request->input('GI_TEXT');

    //     $data = [
    //         "GI_TEXT"=>$GI_TEXT
    //     ];

    //     DB::table('TBL_GI')
    //         ->where('GI_ID',$GI_ID)
    //         ->update($data);
    //     $data = [
    //         'data'=> 'SAVED'
    //     ];
    //     return response()->json($data, 200);
    // }

    // public function ImgDownLoad(Request $request) {
    //     $input = $request->input();
    //     $mcode = $input['M_CODE'];
    //     $start = $input['start'];
    //     $end = $input['end'];
    //     $sql = DB::select("SELECT GI_PIC FROM TBL_GI WHERE M_CODE = ? AND GI_PIC IS NOT NULL LIMIT ?, ?", [$mcode, $start - 1, $end - $start + 1]);

    //     $html = '';
    //     foreach($sql as $row){
    //         $imageData = file_get_contents($row->GI_PIC);

    //         if ($imageData !== false) {
    //             // Encode the image data as Base64
    //             $base64Image = base64_encode($imageData);

    //         } else {
    //             $base64Image ="";
    //         }
    //         $html .= "<img src='data:image/jpeg;base64," . $base64Image . "' width='300px' alt='Image' style='max-width:300px;'><br>";
 
    //     }

                    
    //     $data = [
    //         'body'=>$html,
    //         'total'=>COUNT($sql)
    //     ];



    //     return response()->json($data, 200);

    // }




}
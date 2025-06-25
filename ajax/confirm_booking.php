<?php
require('../admin/db_confg.php');
require('../admin/essential.php');



date_default_timezone_set("Asia/kolkata");

if(isset($_POST['chk_avalibility'])){
    $frm_data= filteration($_POST);
    $status="";
    $result= "";

    $today_date= new DateTime(date("Y-m-d"));
    $checkin_date=  new DateTime($frm_data['checkin']);
     $checkout_date=  new DateTime($frm_data['checkout']);

     

     

    if ($checkin_date->format('Y-m-d') === $checkout_date->format('Y-m-d')) {
        $status= 'chkin and checkout is equal';
         echo json_encode(['status' => 'chkin and checkout is equal']);;
     }

     else if($checkout_date < $checkin_date){
        $status= 'chkout is earlier';
       echo json_encode(['status' => 'chkout is earlier']);
     }
     else if($checkin_date < $today_date){
        $status= 'chkin is earlier';
        echo json_encode(['status' => 'chkin is earlier']);
     }
       
     
       
   


    //  chk booking availibity if status is blank else return the error 
    
    if($status!= ''){
        echo $result;
    }
    else{
        session_start();
        $_SESSION['room'];
        $room_id= $_SESSION['room']['id'];

        // run query to chk room is available or not
        $interval= new DateInterval('P1D');
        $period= new DatePeriod($checkin_date, $interval, $checkout_date);

        foreach($period as $date){
            $current_date= $date->format('Y-m-d');

            $query= "SELECT * from bookings WHERE room_id=? and checkin<=? and checkout>=? and status=?";
            $values= [$room_id, $current_date, $current_date,1];

            $res= select($query, $values, "issi");

            if(mysqli_num_rows($res)>0){
                 echo json_encode(['status'=>'unavailable']);
                 exit;
            }

        }



        $count_days= date_diff($checkin_date, $checkout_date)->days;
        $payment =  $_SESSION['room']['price'] * $count_days;

        $_SESSION['room']['available'] = true;

        $result= json_encode(["status"=>'available', "days"=>$count_days, "payment"=>$payment]);
        echo $result;
        
    } 

}
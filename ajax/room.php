
<?php
require('../admin/db_confg.php'); 
require('../admin/essential.php');
adminLogin();

if (isset($_POST['add_room'])) {
  $features = filteration(json_decode($_POST['features']));
  $facilities = filteration(json_decode($_POST['facilities']));
  $frm_data= filteration($_POST);
  $flag=0;

  $q= "INSERT INTO `rooms`( `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
  $values=[$frm_data['name'], $frm_data['area'],$frm_data['price'],$frm_data['quantity'],$frm_data['adult'],$frm_data['child'],$frm_data['desc']];

  if(insert($q,$values,'siiiiis')){
    $flag=1;

  }
  $room_id= mysqli_insert_id($success);

  $q2="INSERT INTO `room_facilities`(`room_id`, `facilities_id`) VALUES (?,?)";

  if($stmt= mysqli_prepare($success, $q2))
  {
    foreach($facilities as $f){
      mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
      mysqli_stmt_execute($stmt);                                                   
    }
    mysqli_stmt_close($stmt);
  }
  else{
    $flag=0;
    die('query cannot be prepared-insert');
  }

  $q3="INSERT INTO `room_features`(`room_id`, `features_id`) VALUES (?,?)";

  if($stmt= mysqli_prepare($success, $q3))
  {
    foreach($features as $f){
      mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
      mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
  }
  else{
    $flag=0;
    die('query cannot be prepared-insert');
  }

if($flag){
  echo 1;
}
else{
  echo 0;
}

} 

if (isset($_POST['get_rooms'])) {
  $query = "SELECT * FROM `rooms` WHERE `removed` = 0";
  $res = mysqli_query($success, $query); 

  if (!$res) {
    die("Query failed: " . mysqli_error($success));
  }

  while ($row = mysqli_fetch_assoc($res)) {
    $status = ($row['status'] == 1) ?
      "<button onclick='toggle_status({$row['id']},0)' class='btn btn-dark btn-sm shadow-none'>active</button>" :
      "<button onclick='toggle_status({$row['id']},1)' class='btn btn-warning btn-sm shadow-none'>inactive</button>";

    $guest = $row['adult'] + $row['children'];
    $name = addslashes($row['name']); // prevent JS break

    echo "
    <tr>
      <td>{$row['id']}</td>
      <td>{$row['name']}</td>
      <td>{$row['area']}</td>
      <td>{$guest}</td>
      <td>₹{$row['price']}</td>
      <td>{$row['description']}</td>
      <td>{$row['quantity']}</td>
      <td>{$status}</td>
      <td>
     
        <button onclick='edit_details({$row['id']})' class='btn btn-dark btn-sm shadow-none' data-bs-toggle='modal' data-bs-target='#edit_room_modal'>Edit Room</button>
      </td>
      <td>
        <button onclick=\"room_images({$row['id']}, '{$name}')\" class='btn btn-info btn-sm shadow-none' data-bs-toggle='modal' data-bs-target='#room_image'>
          Add Image <i class='bi bi-images'></i>  
        </button>
      </td>

       <td>
        <button onclick=\"Delete_room({$row['id']})\" class='btn btn-danger btn-sm shadow-none'>
         Delete Room
        </button>
      </td>
    </tr>";
  }
}

if(isset($_POST['toggle_status'])){
  $frm_data= filteration($_POST);
  $q= "UPDATE `rooms` SET `status`=? WHERE `id`=?";
  $v= [$frm_data['value'], $frm_data['toggle_status']];

  if(update($q,$v,'ii')){
    echo 1;
  }
  else {
    echo 0;
  }
  
}

if(isset($_POST['edit_details'])){
  $sql= "SELECT * FROM `rooms` WHERE `id`=?";
  $valu= [$_POST['id']];
  $res= select($sql, $valu, 'i');
  $roomdata=mysqli_fetch_assoc($res);

  $sql1= select("SELECT * FROM `room_features` WHERE `room_id`=?",[$_POST['id']],'i');                       
  $sql2= select("SELECT * FROM `room_facilities` WHERE `room_id`=?",[$_POST['id']],'i');                                   

  $features = [];
  $facilities=[];
  if(mysqli_num_rows($sql1)>0){
    while($row= mysqli_fetch_assoc($sql1)){
      array_push($features, $row['features_id']);
    }                                                           
  }

  if(mysqli_num_rows($sql2)>0){
    while($row= mysqli_fetch_assoc($sql2)){
      array_push($facilities, $row['facilities_id']);
    }
  }

  $data= ["roomdata"=>$roomdata, "features"=>$features, "facilities"=>$facilities];
   



 
  echo json_encode($data);
     
  
  
  
}
if(isset($_POST['edit_room'])) {
  $features = filteration(json_decode($_POST['features']));
  $facilities = filteration(json_decode($_POST['facilities']));
  $frm_data = filteration($_POST);
  $flag = 0;

  
  $status = isset($frm_data['status']) ? (int)$frm_data['status'] : 1;

  // Update room details - this is the critical operation
  $q1 = "UPDATE `rooms` SET `name`=?, `area`=?, `price`=?, `quantity`=?, `adult`=?, `children`=?, `description`=?, `status`=? WHERE `id`=?";
  $values = [
      $frm_data['name'], 
      $frm_data['area'],
      $frm_data['price'],
      $frm_data['quantity'],
      $frm_data['adult'],
      $frm_data['child'],
      $frm_data['desc'],
      $status,
      $frm_data['room_id']
  ];

  
  $flag = update($q1, $values, 'siiiiisii') ? 1 : 0;

  
  $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
  $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$frm_data['room_id']], 'i');

 
  if(!empty($facilities)) {
      $q2 = "INSERT INTO `room_facilities` (`room_id`, `facilities_id`) VALUES (?,?)";
      $stmt = mysqli_prepare($success, $q2);
      if($stmt) {
          foreach($facilities as $f) {
              mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
              mysqli_stmt_execute($stmt);
          }
          mysqli_stmt_close($stmt);
      }
  }


  if(!empty($features)) {
      $q3 = "INSERT INTO `room_features` (`room_id`, `features_id`) VALUES (?,?)";
      $stmt = mysqli_prepare($success, $q3);
      if($stmt) {
          foreach($features as $f) {
              mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
              mysqli_stmt_execute($stmt);
          }
          mysqli_stmt_close($stmt);
      }
  }

  echo $flag;
}


if (isset($_POST['add_image'])) {
  $frm_data = filteration($_POST);

  $img_r = uploadimage($_FILES['image'], ROOMS_FOLDER);


  if (!isset($_FILES['image'])) {
    echo 'upload_failed'; // or use 'invalid_image' if more suitable
    exit;
}



  if ($img_r == 'invalid_image') {
    echo $img_r;
  } else if ($img_r == 'invalid_size') {        
    echo $img_r;
  } else if ($img_r == 'upload_failed') {
    echo $img_r;
  } else {

 

    $q = "INSERT INTO `rooms_images`(`room_id`,`image`) VALUES(?,?)";
    $values = [$frm_data['room_id'], $img_r];
    $res = insert($q, $values, "is");

    echo $res == 1 ? "success" : "upload_failed";
  }
}

if(isset($_POST['get_room_image'])){
  $frm_data= filteration($_POST);

  $res= select("SELECT * FROM `rooms_images` WHERE `room_id`=?",[$frm_data['get_room_image']],'i');

  $path=ROOMS_IMG_PATH;

  while($row = mysqli_fetch_assoc($res)){
    
    if($row['thumb']==1){
      $thumb_btn ="<i class='bi bi-check-lg fs-1 text-success ms-3'></i>
";
    }
    else{
      $thumb_btn = "<button onclick=\"thumb_images({$row['sr_no']}, {$row['room_id']})\" type=\"button\" class=\"btn btn-warning ms-4\">Set Active</button>";

    }
    
    echo <<<data
    <tr class='align-middle'>
        <td><img src="{$path}{$row['image']}" class="img-fluid"></td>
        <td>$thumb_btn</td>
        <td><button onclick="rem_images({$row['sr_no']}, {$row['room_id']})" type="button" class="btn btn-danger ms-4">Delete</button></td>

    </tr>
data;

  }
}

if(isset($_POST['rem_images'])){
  $frm_data= filteration($_POST);
  $q= "SELECT * FROM `rooms_images` WHERE `sr_no`=? AND `room_id`=?";
  $values = [$frm_data['img_id'], $frm_data['room_id']];
  $res= select($q,$values,"ii");

  $img= mysqli_fetch_assoc($res);

   if(dl_image($img['image'],ROOMS_FOLDER)){
    $q = "DELETE FROM `rooms_images` WHERE `sr_no`=? AND `room_id`=?";
    $values = [$frm_data['img_id'], $frm_data['room_id']];

    $res = delete($q, $values, "ii"); 

   }

  if($res){
    echo 1;
    
  }
  else{
    echo 0;
  }
}

  if(isset($_POST['update_room_image'])){
    $frm_data= filteration($_POST);
     
    $prev_q= "UPDATE `rooms_images` SET `thumb`=? WHERE `room_id`=?";
    $prev_values= [0,$frm_data['room_id']];                                                     
    $prev_res= update($prev_q,$prev_values,"ii");


    $q= "UPDATE `rooms_images` SET `thumb`=? WHERE `sr_no`=?";
    $values= [1,$frm_data['update_room_image']];                                                     
    $res= update($q,$values,"ii");
  
  
  if($res){
    echo 1;
  }
  else{
    echo 0;
  }
}

if (isset($_POST['delete_room'])) {

  $frm_data = filteration($_POST);

  // Step 1: Fetch and delete images
  $res1 = select("SELECT * FROM `rooms_images` WHERE `room_id` = ?", [$frm_data['delete_room']], 'i');

  while ($row = mysqli_fetch_assoc($res1)) {
      dl_image($row['image'], ROOMS_FOLDER);
  }

  // Step 2: Delete related entries and update room
  $res2 = delete("DELETE FROM `rooms_images` WHERE `room_id` = ?", [$frm_data['delete_room']], 'i');
  $res3 = delete("DELETE FROM `room_facilities` WHERE `room_id` = ?", [$frm_data['delete_room']], 'i');
  $res4 = delete("DELETE FROM `room_features` WHERE `room_id` = ?", [$frm_data['delete_room']], 'i');     
  $res5 = update("UPDATE `rooms` SET `removed` = ? WHERE `id` = ?", [1, $frm_data['delete_room']], 'ii');

  // Step 3: Check success
  if ($res2 || $res3 || $res4 || $res5) {
      echo 1;
  } else {
      echo 0;
  }
}

  


?>

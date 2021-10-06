<?php
if(!empty($_POST)){  
    if(!empty($_POST['question_id']) && !empty($_POST['option_title'])){
        $insertData1['question_id'] = $_POST['question_id'];
        $insertData1['option_title'] = $_POST['option_title'];
        $insertData1['option_label'] = $_POST['option_label'];        
        echo saveOption($insertData1);die;
    }else if(!empty($_POST['question_id']) && !empty($_POST['title'])){
        $insertData['question_title'] = $_POST['title'];
        $insertData['question_description'] = $_POST['description'];
        updateQuestion($_POST['title'],$_POST['description'],$_POST['question_id']);
    }
    else{
        $insertData['question_title'] = $_POST['title'];
        $insertData['question_description'] = $_POST['description'];
        $insertData['created_at'] = date('Y-m-d H:i:s');
        echo saveQuestion($insertData);die;
    }    
}
if(!empty($_GET)){
    if(!empty($_GET['type']) && $_GET['type']=='delete' && !empty($_GET['guide_id'])){
        $guideDelete = guideDelete($_GET['guide_id']);
        $displayMessage = $guideDelete?'Guide has been deleted successfully':'Error in deleting guide';
        header('Location:guide_list.php?success='.$displayMessage);        
    }
}
function connect()
{
    $user = "root";
    $host = "localhost";
    $pass = "rahul";
    $db = "rightbiz";
    $mysqli = new mysqli($host,$user,  $pass, $db);
    if($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    return $mysqli;
}

function saveQuestion($insertData){
    $mysqli = connect();
    $tableName = 'guides';
    $columns = implode(", ",array_keys($insertData));    
    $escaped_values = array_values($insertData);    
    foreach ($escaped_values as $idx=>$data) $escaped_values[$idx] = "'".$data."'";
    $values  = implode(", ", $escaped_values);    
    $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
    if ($mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        return $last_id;        
    } else {
        return false;
    }  
}

function updateQuestion($title,$description,$question_id){
    $mysqli = connect();
    $query = "update guides set question_title='".$title."' , question_description='".$description."' where id='".$question_id."'";
    if ($mysqli->query($query) === TRUE) {
        echo "Question updated successfully.";
        return true;
    } else {
        return false;
    }  
}

function saveOption($insertData){
    $mysqli = connect();
    $tableName = 'options';
    $columns = implode(", ",array_keys($insertData));    
    $escaped_values = array_values($insertData);
    foreach ($escaped_values as $idx=>$data) $escaped_values[$idx] = "'".$data."'";
    $values  = implode(", ", $escaped_values);    
    $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
    if ($mysqli->query($query)) {
        $last_id = $mysqli->insert_id;
        return $last_id;
    } else {
        return false;
    }  
}

function guideList($id=''){
    $mysqli = connect();
    $sql = "SELECT * FROM guides where deleted_at is null";
    if(!empty($id)){
        $sql .= " and id='".$id."'";
    }    
    $sql .= " order by id asc";
    $result = $mysqli->query($sql);
    $selectArr = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
              $selectArr[] = $row;
        }
    } 
    return $selectArr;
}
function guideDelete($id){
    $mysqli = connect();
    $query = "delete FROM guides where id='".$id."'";    
    if (!$mysqli->query($query)) {
        return false;
    } else {
        return true;
    }  
}
?>
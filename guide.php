<?php
require_once 'database.php';
if(!empty($_POST)){  
    if(!empty($_POST['question_id']) && !empty($_POST['option_title']) && empty($_POST['choiceID'])){
        $insertData1['question_id'] = $_POST['question_id'];
        $insertData1['option_title'] = addslashes($_POST['option_title']);
        $insertData1['option_label'] = addslashes($_POST['option_label']);        
        echo saveOption($insertData1);die;
    }else if(!empty($_POST['question_id']) && !empty($_POST['title'])){
            $insertData['question_title'] = addslashes($_POST['title']);
            $insertData['question_description'] = addslashes($_POST['description']);
            $insertData['answer_option_id'] = !empty($_POST['option_id'])?$_POST['option_id']:0;
            updateQuestion($insertData['question_title'],$insertData['question_description'],$_POST['question_id'],$insertData['answer_option_id']);
    }
    else if(!empty($_POST['question_id']) && !empty($_POST['option_title']) && !empty($_POST['choiceID'])){
        $insertData1['question_id'] = $_POST['question_id'];
        $insertData1['option_title'] = addslashes($_POST['option_title']);
        $insertData1['option_label'] = addslashes($_POST['option_label']);        
        updateOption($insertData1['question_id'],$insertData1['option_title'],$insertData1['option_label'],$_POST['choiceID']);
    }
    else if(!empty($_POST['choiceID']) && $_POST['type']=='deleteOption'){        
        deleteOption($_POST['choiceID']);
    }
    else if(!empty($_POST['optionId']) && $_POST['type']=='updateCounter'){        
        updateCounter($_POST['optionId']);
    }
    else{
        $insertData['question_title'] = addslashes($_POST['title']);
        $insertData['question_description'] = addslashes($_POST['description']);
        if(!empty($_POST['option_id'])){
            $insertData['parent_id'] = $_POST['option_id'];
            $insertData['answer_option_id'] = $_POST['option_id'];
        }	    
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
    if(!empty($_GET['type']) && $_GET['type']=='publish' && !empty($_GET['guide_id'])){
        $guideDelete = guidePublish($_GET['guide_id']);
        $displayMessage = $guideDelete?'Guide has been publish successfully':'Error in publishing guide';
        header('Location:guide_list.php?success='.$displayMessage);        
    }
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

function updateQuestion($title,$description,$question_id,$option_id=''){
    $mysqli = connect();
    $query = "update guides set question_title='".$title."' , question_description='".$description."',
    answer_option_id='".$option_id."' where id='".$question_id."'";
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
function updateOption($question_id,$title,$label,$choiceID){
    $mysqli = connect();
    $query = "update options set option_title='".$title."' , option_label='".$label."' where id='".$choiceID."' limit 1";
    if ($mysqli->query($query) === TRUE) {
        echo "Choice updated successfully.";
        return true;
    } else {
        return false;
    }  
}
function guideList($id='',$option_id=''){
    $mysqli = connect();
    $sql = "SELECT id,question_title,question_description,answer_option_id,status FROM guides where deleted_at is null";
    if(!empty($id)){
        $sql .= " and id='".$id."'";
    }   
    if(!empty($option_id)){
        $sql .= " and answer_option_id='".$option_id."'";
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
    $query = "delete FROM guides where id='".$id."' limit 1";    
    if (!$mysqli->query($query)) {
        return false;
    } else {
        return true;
    }  
}

function guideOptions($guide_id=''){
    $mysqli = connect();
    $sql = "SELECT * FROM options where question_id=$guide_id order by id asc";
    $result = $mysqli->query($sql);
    $selectArr = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
              $selectArr[] = $row;
        }
    } 
    return $selectArr;
}

function deleteOption($choiceID){
    $mysqli = connect();
    $query = "delete FROM options where id='".$choiceID."' limit 1";    
    if (!$mysqli->query($query)) {
        return false;
    } else {
        echo "Option has been deleted successfully";
        return true;
       
    }  
}
function guidePublish($id){
    $mysqli = connect();
    $query = "update guides set status='published' where id='".$id."' limit 1";    
    if (!$mysqli->query($query)) {
        return false;
    } else {
        return true;
    }  
}

function getBackLink($option_id){
    $mysqli = connect();
    $query = "SELECT g.answer_option_id,g.id from guides g join options o on g.id=o.question_id where o.id='".$option_id."'";
    $result = $mysqli->query($query);
    $selectArr = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
              $selectArr[] = $row;
        }
    } 
    return $selectArr;
}

function getFirstGuideId($option_id){
    $mysqli = connect();
    $query = "SELECT g.answer_option_id,g.id from guides g join options o on g.id=o.question_id where o.id='".$option_id."'";
    $result = $mysqli->query($query);
    $guideId ='';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if(!empty($row['answer_option_id'])){
                $row1=getFirstGuideID($row['answer_option_id']);                
            }
            else{
                $guideId = $row['id'];
                break;
            }             
        }       
    } 
    return $guideId;
}

function updateCounter($optionId){
    $mysqli = connect();
    $query = "update options set click_count= click_count+1 where id='".$optionId."'";    
    if (!$mysqli->query($query)) {
        return false;
    } else {
        echo "Option count updated successfully";
        return true;
       
    }  
}
?>
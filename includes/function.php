<?php

/**
 * @author electric
 * @copyright 2011
 */
function strU($str)
{
    if (!$str)
        return false;
    $unicode = array('a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ', 'd' => 'đ', 'D' =>
        'Đ', 'A' => 'Â|Ă|Ả|Á|À|Ã|Ạ|Ầ|Ấ|Ẩ|Ẫ|Ậ|Ẵ|Ẳ|Ặ|Ằ|Ắ', 'E' => 'Ê|Ề|Ễ|Ể|Ệ|É|Ẻ|Ẽ|Ẹ', 'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 
        'i' => 'í|ì|ỉ|ĩ|ị','I' => 'Í|Ì|Ỉ|Ĩ|Ị', 'O' =>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ', 
        'o' =>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ', 'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
         'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 'Y' =>'Ý|Ỳ|Ỷ|Ỹ|Ỵ', 'y' =>'ý|ỳ|ỷ|ỹ|ỵ', '-' =>' ');
    foreach ($unicode as $nonUnicode => $uni)
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    $str = preg_replace('/[^a-zA-Z0-9--]/', '', $str);
    $str = preg_replace('/(---|--)/', '-', $str);
    return $str;
}
function product_exists($proudct_id)
{
    $proudct_id = intval($proudct_id);
    $max = count($_SESSION['cart']);
    $flag = 0;
    foreach($_SESSION['cart'] as $key=>$value)
    {
        if($proudct_id==$key)
        {
            $flag = 1;
            break;
        }
    }
    return $flag;
}
function remove_product($proudct_id)
{
    $proudct_id = intval($proudct_id);
    unset($_SESSION['cart'][$proudct_id]);
}
function addtocart($proudct_id, $sale ,$price, $quantity)
{
    if ($proudct_id < 1 || $quantity < 1)
        return;

    if (is_array($_SESSION['cart'])) {
        if (product_exists($proudct_id))
        {
            $_SESSION['cart'][$proudct_id]['quantity'] = $_SESSION['cart'][$proudct_id]['quantity']+1;
            $_SESSION['cart'][$proudct_id]['price'] = $price;
            $_SESSION['cart'][$proudct_id]['sale'] = $sale;
        }
        else
        {
            $_SESSION['cart'][$proudct_id]['quantity'] = $quantity;
            $_SESSION['cart'][$proudct_id]['price'] = $price;
            $_SESSION['cart'][$proudct_id]['sale'] = $sale;
        }
    } else {
        $_SESSION['cart'] = array();
        $_SESSION['cart'][$proudct_id]['quantity'] = $quantity;
        $_SESSION['cart'][$proudct_id]['price'] = $price;
        $_SESSION['cart'][$proudct_id]['sale'] = $sale;
    }
}

function executeQuery($query="",$table=array())
{
    global $conn,$langDefault; $arrayField=array(); $arrayResult=array();
    if(count($table)>0 && $query!="")
    {
        foreach($table as $key1=>$value1)
        {
            $sql = "describe $value1";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if (mysqli_num_rows($result) >= 1) {
                while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrayField[] = $rows["Field"];
                }
            }
            mysqli_free_result($result);
        }
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) >= 1) {
            $stt=0;
            while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                foreach($arrayField as $key=>$value)
                {
                    $arrayResult[$stt][$value] = stripslashes($rows[$value]);
                }
                $stt++;
            }
        }
        mysqli_free_result($result);   
    }
    return $arrayResult;
}

function executeQueryFontend($query="",$table=array(),$query_order="",$query_lang="lang")
{
    global $conn,$langDefault; $arrayField=array(); $arrayResult=array();
    if(count($table)>0 && $query!="")
    {
        foreach($table as $key1=>$value1)
        {
            $sql = "describe $value1";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if (mysqli_num_rows($result) >= 1) {
                while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrayField[] = $rows["Field"];
                }
            }
            mysqli_free_result($result);
        }
        $query .= " and $query_lang IN ('".$langDefault."') ".$query_order;
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) >= 1) {
            $stt=0;
            while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                foreach($arrayField as $key=>$value)
                {
                    $arrayResult[$stt][$value] = stripslashes($rows[$value]);
                }
                $stt++;
            }
        }
        mysqli_free_result($result);   
    }
    return $arrayResult;
}

function executeQueryAdmin($query="",$table=null,$query_lang="lang")
{
    global $conn, $lang; $arrayField=array(); $arrayResult=array();
    /* Thực hiện query */
    if(count($table)>0 && $query!="")
    {
        foreach($table as $key1=>$value1)
        {
            $sql = "describe $value1";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if (mysqli_num_rows($result) >= 1) {
                while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $arrayField[] = $rows["Field"];
                }
            }
            mysqli_free_result($result);
        }
        $query .= " and $query_lang IN ('".$lang."')";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) >= 1) {
            $stt=0;
            while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                foreach($arrayField as $key=>$value)
                {
                    $arrayResult[$stt][$value] = stripslashes($rows[$value]);
                }
                $stt++;
            }
        }
        mysqli_free_result($result);   
    }
    return $arrayResult;
    /* Thực hiện query */
}
function executeQueryAdminLog($query="")
{
    global $conn;
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    crea_log($query);
}
?>
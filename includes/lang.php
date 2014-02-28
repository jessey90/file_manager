<?php
    global $conn;
    $sql = "select * from lang where lang_current=1 and lang_status=1";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) >= 1) {
        while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $lang = $rows['lang_namekey'];
        }
    }
    $sql = "select * from lang";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) >= 1) {
        while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $langList[] = $rows['lang_namekey'];
        }
    }
    $sql = "select * from lang where lang_default=1 and lang_status=1";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) >= 1) {
        while ($rows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $langDefault = $rows['lang_namekey'];
        }
    }
?>
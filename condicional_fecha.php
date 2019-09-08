<?php
    $_POST['id_ins'] = true;
    if($_POST['id_ins']){
        $data = array(
            'INS' => 'INSTITUCIUON', 
            "trur_fec" => date("Y-m-d", strtotime("+100 day")),
            "dia" => date("y-m-d")
        );
        $ins_nom = $data['INS'];
        
        if($data["trur_fec"]){
            $fec_tur = $data["trur_fec"];
            echo '<script>alert("'. $fec_tur .'")</script>';
        } elseif($data["dia"]){
            $fec_tur = $data["dia"];
            echo '<script>alert("'. $fec_tur .'")</script>';
        } else{
            $fec_tur = "";
            echo '<script>alert("'. $fec_tur .'")</script>';
        }
        echo '<script>alert("'. $fec_tur .'")</script>';

    }
    echo '<script>alert("'. $fec_tur .'")</script>';
?>
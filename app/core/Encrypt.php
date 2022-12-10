<?php 

class Encrypt{
    public function Kunci($pb){
        $key = 'Zpm29AaN03';
        for ($i = 0; $i < strlen($pb); $i++) {
            $bn = substr($pb, $i, 1);
            $ki = substr($key, ($i % strlen($key)) - 1, 1);
            $bn = chr(ord($bn) + ord($ki));
            $sg .= $bn;
        }
        return base64_encode($sg);
    }


    public function Buka($pb) {
        $pb = base64_decode($pb);
        $sg = '';
        $key = 'Zpm29AaN03';
        for ($i = 0; $i < strlen($pb); $i++) {
            $bn = substr($pb, $i, 1);
            $ki = substr($key, ($i % strlen($key)) - 1, 1);
            $bn = chr(ord($bn) - ord($ki));
            $sg .= $bn;
        }
        return $sg;
    }

}
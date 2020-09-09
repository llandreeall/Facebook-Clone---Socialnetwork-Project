<?php
class Image {
        public static function uploadImage($formname, $query, $params) {
                $image = base64_encode(file_get_contents($_FILES[$formname]['tmp_name']));
                $options = array('http'=>array(
                        'method'=>"POST",
                        'header'=>"Authorization: Bearer 6eaff40f89c368a4c2105f70bb9f1268c73e4cee\n".
                        "Content-type: application/x-www-form-urlencoded",
                        'content'=>$image
                    ));
                $context = stream_context_create($options);
                $imgurURL = "https://api.imgur.com/3/image";
    
                 if ($_FILES[$formname]['size'] > 10240000) {
                        die('Imaginea este prea mare, trebuie sa fie de 10MB sau mai putin!');
                }

                $response = file_get_contents($imgurURL, false, $context);
                $response = json_decode($response);     
            
                $preparams = array($formname=>$response->data->link);
                $params = $preparams + $params;
                db::query($query, $params);
            
        }
}
?>
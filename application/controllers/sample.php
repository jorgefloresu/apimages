<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once './panthermedia-restful-client.php';
        
print '<h1>PantherMediaRESTfulClient Sample</h1>';

try{
   $rest = new PantherMediaRESTfulClient('26504a7136234b4b4b4e5ffcc6ebcaad32eea4ae8c2294ecb0c97bd6c5b75163', 'b1f0308579ef0e16331a2221c9ec79251036a0fc5e394e044a537a76dc885e2c');
   
   print '<h2>API Host Info:</h2>';
   print '<pre>';   
   print_r($rest->host_info());   
   print '</pre>';
      
   ###
      
   $ret = $rest->search('fast car', 'en', 0, 30, 'title,author_username', 'license:commercial;sort:rel;');
   
   print '<h2>Search:</h2>';
      
   if(isset($ret['items']['media'])){
      
      foreach($ret['items']['media'] as $key => $value){
         if(isset($value['thumb'])){
            print $value['title'].'<br><img src="'.$value['thumb'].'"><br>Author: '.$value['author-username'].'<br><br>';
         }
      }
      
   }else{
      print 'no result<br><br>';
      print '<pre>';
      print_r($ret);
      print '</pre>';
   }
   
   ###
   
   print '<h2>Media Info:</h2>';
   
   //$rest->setUser_Authentication('51581caccf82a8d408f03d384971bcb3d00d7097', 'photosale');
   //$ret = $rest->get_media_info('2345', 'en', true, false);
   $ret = $rest->download_image_preview('2345');
   print '<pre>';
   print_r($ret);
   //print_r(base64_decode($ret['media']['base64']));
   print '</pre>';
   echo '<a href="data:application/octet-stream;charset=utf-8;base64,'.$ret['media']['base64'].'" download="image.jpg">Dowload</a>';

}catch(Exception $ex){
   print '<p style="color:DarkRed;">';
   print $ex->getMessage().' ('.$ex->getCode().')';
   print '<br><br>Response-Headers:<br>';
   print '<pre style="color:DarkRed;">';
   print_r($rest->get_response_headers());
   print '</pre>';
   print '</p>';
}   
?>
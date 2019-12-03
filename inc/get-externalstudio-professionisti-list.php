<?php
// create curl resource
$ch = curl_init();

//curl_setopt($ch, CURLOPT_URL, "https://crm.newsmemory.com:8143/api/toplegal/contacts?link=" . urlencode("wind"));
curl_setopt($ch, CURLOPT_URL, sprintf("https://crm.newsmemory.com:8143/api/toplegal/contacts?type[]=%s", $post_type ));

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjbGllbnRfYXBwIjoidG9wbGVnYWxfd29yZHByZXNzIn0.4pZlmokVU3P5J1I415a9OUR1oE2w8PhZRiB7O1dmH-k'
));

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// $output contains the output string
$output = curl_exec($ch);

//echo $output;
$output = json_decode($output,true);

$total_items = count($output);

// close curl resource to free up system resources
curl_close($ch);

$str = '<div class="rcbScroll rcbWidth" style="height: 277.011px;"><ul class="rcbList" style="list-style:none;margin:0;padding:0;zoom:1;">';
foreach ($output as $value) {
	if ( $post_type == 'studio' ) 
	$str = $str .'<li class="rcbItem" post-type="'.$post_type.'" id="'.$value['id'].'">'.$value['name'].'</li>';
	elseif ( $post_type == 'professionista' )
	$str = $str .'<li class="rcbItem" post-type="'.$post_type.'" id="'.$value['id'].'">'.$value['first_name'].' '.$value['last_name'].'</li>';
	//echo $value;
}
$str = $str.'</ul></div>';
echo $str.'**&**'.'<span>Items <b>1</b>-<b>'.$total_items.'</b> out of <b>'.$total_items.'</b></span>';
?>
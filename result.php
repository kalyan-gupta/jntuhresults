<?php

$con=mysqli_connect("localhost","root","","result");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT ht_number from ht_n";

if ($result=mysqli_query($con,$sql))
  {
	  $count = 1;
  // Fetch one and one row
  while ($row=mysqli_fetch_row($result))
    {
		$htn = $row[0];

	$jntuhsiteurl="http://epayments.jntuh.ac.in/results/resultAction";
	$postdata="degree=btech&examCode=1284&etype=r16&result=null&grad=null&type=grade16&htno=".$htn;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$jntuhsiteurl);
	
	$request_headers = array();
	$request_headers[] = 'Host: epayments.jntuh.ac.in';
	$request_headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0';
	$request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
	$request_headers[] = 'Accept-Language: en-US,en;q=0.5';
	$request_headers[] = 'Accept-Encoding: gzip, deflate';
	$request_headers[] = 'Referer: http://epayments.jntuh.ac.in/results/jsp/SearchResult.jsp?degree=btech&examCode=1284&etype=r16&type=grade16';
	$request_headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$request_headers[] = 'Connection: keep-alive';
	$request_headers[] = 'Upgrade-Insecure-Requests: 1';

	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$out = curl_exec($ch);
	curl_close($ch);
	
	if (strpos($out, 'invalid hallticket number') !== false) {
		echo $htn." - invalid hallticket number <br>";
	}
	else 
	{
		echo $htn;
		echo " Result-number-".$count;
		$count++;
		
		$position = strpos($out,'<br>',0);
		$final = substr($out,0,$position);
		echo $final;
	}


    }
  // Free result set
//   mysqli_free_result($result);
}

mysqli_close($con);
?>

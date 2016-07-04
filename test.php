<?php
require_once('globalFunctions.php');

echo"<br/>==========begin unit test=========<br/>";
echo 'Testing function: sumArrayByColumns($inputArray,$inputArrayColumns)';
echo '<br/>$inputArray=';	
	$test_array_columns = array('col1','col2','col3');
	$test_array = array();
	$test_array_item = array();
	$test_expected_array = array();
	$test_array_item['col1'] = 12;
	$test_array_item['col2'] = 5;
	$test_array_item['col3'] = 6;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 10;
	$test_array_item['col2'] = 100;
	$test_array_item['col3'] = 1;
	array_push($test_array,$test_array_item);

print_r($test_array);
echo '<br/>expected $outputArray=';		
	$test_array_item['col1'] = 22;
	$test_array_item['col2'] = 105;
	$test_array_item['col3'] = 7;
	array_push($test_expected_array,$test_array_item);
print_r($test_expected_array);
echo '<br/>actual $outputArray=';	
$test_result_array=sumArrayByColumns($test_array,$test_array_columns);
print_r($test_result_array);

if($test_result_array==$test_expected_array)
{
	echo '<br/>SUCCESS';
}
else
{
	echo '<br/>FAILURE';
}
echo"<br/>==========end test=========<br/>";
//function filterInputArrayByParameter($inputArray,$filterParam,$filterValue)
echo"<br/>==========begin unit test=========<br/>";
echo 'Testing function: filterInputArrayByParameter($inputArray,$filterParam,$filterValue)';
echo '<br/>$inputArray=';	
	$test_array_columns = array('col1','col2','col3','Province','District','CaptureYear');
	$test_array = array();
	$test_array_item = array();
	$test_expected_array = array();
	$test_array_item['col1'] = 12;
	$test_array_item['col2'] = 5;
	$test_array_item['col3'] = 6;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 10;
	$test_array_item['col2'] = 100;
	$test_array_item['col3'] = 1;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Ekurhuleni';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 6;
	$test_array_item['col2'] = 20;
	$test_array_item['col3'] = 12;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 5;
	$test_array_item['col2'] = 33;
	$test_array_item['col3'] = 44;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Polokwane';
	$test_array_item['CaptureYear'] = 2012;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 8;
	$test_array_item['col2'] = 16;
	$test_array_item['col3'] = 3;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2012;
	array_push($test_array,$test_array_item);
print_r($test_array);
$test_col = 'Province';
$test_col_val = 'Limpopo';
echo '<br/>$filterParam = '.$test_col;	
echo '<br/>$filterValue = '.$test_col_val;	
echo '<br/>expected $outputArray=';		
	$test_array_item['col1'] = 6;
	$test_array_item['col2'] = 20;
	$test_array_item['col3'] = 12;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_expected_array,$test_array_item);
	$test_array_item['col1'] = 5;
	$test_array_item['col2'] = 33;
	$test_array_item['col3'] = 44;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Polokwane';
	$test_array_item['CaptureYear'] = 2012;
	array_push($test_expected_array,$test_array_item);
print_r($test_expected_array);
echo '<br/>actual $outputArray=';	
$test_result_array=filterInputArrayByParameter($inputArray=$test_array,$filterParam=$test_col,$test_col_val);
print_r($test_result_array);

if($test_result_array==$test_expected_array)
{
	echo '<br/>SUCCESS';
}
else
{
	echo '<br/>FAILURE';
}
echo"<br/>==========end test=========<br/>";

echo"<br/>==========end test=========<br/>";
//function summarizeArrayByParameter($inputArray,$inputArrayColumns,$summaryField)
echo"<br/>==========begin unit test=========<br/>";
echo 'Testing function: summarizeArrayByParameter($inputArray,$inputArrayColumns,$summaryField)';
echo '<br/>$inputArray=';	
	$test_array_columns = array('col1','col2','col3','Province','District','CaptureYear');
	$test_array = array();
	$test_array_item = array();
	$test_expected_array = array();
	$test_array_item['col1'] = 12;
	$test_array_item['col2'] = 5;
	$test_array_item['col3'] = 6;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 10;
	$test_array_item['col2'] = 100;
	$test_array_item['col3'] = 1;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Ekurhuleni';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 6;
	$test_array_item['col2'] = 20;
	$test_array_item['col3'] = 12;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 5;
	$test_array_item['col2'] = 33;
	$test_array_item['col3'] = 44;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Polokwane';
	$test_array_item['CaptureYear'] = 2012;
	array_push($test_array,$test_array_item);
	$test_array_item['col1'] = 8;
	$test_array_item['col2'] = 16;
	$test_array_item['col3'] = 3;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2012;
	array_push($test_array,$test_array_item);
print_r($test_array);
$test_col = 'Province';
echo '<br/>$summaryField = '.$test_col;	
echo '<br/>expected $outputArray=';		
	$test_array_item['col1'] = 30;
	$test_array_item['col2'] = 121;
	$test_array_item['col3'] = 10;
	$test_array_item['Province'] = 'Gauteng';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_expected_array,$test_array_item);
	$test_array_item['col1'] = 11;
	$test_array_item['col2'] = 53;
	$test_array_item['col3'] = 56;
	$test_array_item['Province'] = 'Limpopo';
	$test_array_item['District'] = 'Johannesburg';
	$test_array_item['CaptureYear'] = 2011;
	array_push($test_expected_array,$test_array_item);
print_r($test_expected_array);
echo '<br/>actual $outputArray=';	
$test_result_array=summarizeArrayByParameterTest($inputArray=$test_array,$inputArrayColumns=$test_array_columns,$summaryField=$test_col);
print_r($test_result_array);

if($test_result_array==$test_expected_array)
{
	echo '<br/>SUCCESS';
}
else
{
	echo '<br/>FAILURE';
}
echo"<br/>==========end test=========<br/>";
	
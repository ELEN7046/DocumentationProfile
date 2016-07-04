<?php
spl_autoload_register(function ($class_name){
	include $class_name.'.php';
});
/*
if( !isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60 ) 
{
  $_SESSION['last_access'] = time(); 
}
*/
//$parameters = array('Profile','Category','CaptureYear','Province','District','LocalMunicipality','need','DocNeed','educationneed');

//setSessionParametersFromQueryString();

function get_province_id($province)
{
/*ID	Short label	Label
05	EC	Eastern Cape
03	FS	Free State
06	GT	Gauteng
02	NL	KwaZulu-Natal
09	LP	Limpopo
07	MP	Mpumalanga
10	NW	North West
08	NC	Northern Cape
11	WC	Western Cape
*/

$province_id = "0";
if($province == "Eastern Cape")
{
$province_id = "05";
}
if($province =="Free State")
{
$province_id = "03";
}
if($province == "Gauteng")
{
$province_id = "06";
}
if($province =="KwaZulu-Natal")
{
$province_id = "02";
}
if($province =="Limpopo")
{
$province_id = "09";
}
if($province =="Mpumalanga")
{
$province_id = "07";
}
if($province == "North West")
{
$province_id = "10";
}
if($province =="Northern Cape")
{
$province_id = "08";
}
if($province == "Western Cape")
{
$province_id = "11";
}

return $province_id;
}
	
function createParametersArray($profiles,$selectedProfile)
{
	$postfix = 'Array';
	$parametersArray = array('Profile','Category','Needs');
	$_SESSION['Profile'.$postfix] = array();
	foreach ($profiles->profile as $profile) {
		
	array_push($_SESSION['Profile'.$postfix],(string)$profile->label);
	
   if($selectedProfile == (string)$profile->label)
   {
	$_SESSION['Profile'] == (string)$profile->label;
	$_SESSION['rawdata'] = json_decode(file_get_contents((string)$profile->rawdatajson),true); 
	$_SESSION['Category'.$postfix] = array();
	$_SESSION['columns_labels'] = array();

foreach ($profile->columns->column as $column) {

       switch((string) $column['type']) { // Get attributes as element indices
    case 'single':
       	array_push($_SESSION['Category'.$postfix],(string)$column->id);
	    array_push($_SESSION['columns_labels'],(string)$column->label);
        break;
    case 'aggregate':
		$_SESSION['total'] = (string)$column->id;
        break;
	case 'needs':
       	$_SESSION['Needs'] = (string)$column->id;
       	array_push($parametersArray ,(string)$column->id);
        break;
	case 'region':
       	array_push($parametersArray ,(string)$column->id);
        break;
	case 'time':
       	array_push($parametersArray ,(string)$column->id);
        break;
    }
}
   }
}

return $parametersArray;
}

function setSessionParametersFromQueryString()
{
	$postfix = 'Array';
$filterParameters = array();
$filters = array();
$profiles = readXMLConfigs('assets\config\profiles.xml');
if(!isset($_SESSION['Profile']) AND !isset($params['Profile'])) 
{
		$_SESSION['Profile'] = $profiles[0]->profile->label; 
}
else
{
	$_SESSION['Profile'] = $params['Profile']; 
}
$parameters = createParametersArray($profiles,$_SESSION['Profile']);
setProvincesAndYears($_SESSION['rawdata']);
$current_url = str_replace("www.", "", curPageURL());
$query = parse_url(curPageURL(), PHP_URL_QUERY);//parse_url('http://www.example.com?test=123&random=abc', PHP_URL_QUERY);
parse_str($query, $params);

//print_r('session'.$postfix.' parameter is set ');
//var_dump($parameters);
//var_dump($params);
//exit();

if(isset($params['Province']) AND (itemExist($params['Province'],$_SESSION['Province'.$postfix])))
{
	setSubRegions($_SESSION['rawdata'],'Province',$params['Province'],'District');
    if(isset($params['District']) AND (itemExist($params['District'],$_SESSION['District'.$postfix])))
    {
	setSubRegions($_SESSION['rawdata'],'District',$params['District'],'LocalMunicipality');
    }
}

for( $tmp_i = 0; $tmp_i < count($parameters); $tmp_i++)
{
	if(isset($params[$parameters[$tmp_i]]))
	{	
      if(itemExist($params[$parameters[$tmp_i]],$_SESSION[$parameters[$tmp_i].$postfix]))
      {	
        if($parameters[$tmp_i] != 'Needs')
           $_SESSION[$parameters[$tmp_i]] = $params[$parameters[$tmp_i]];  
		if($parameters[$tmp_i]=='Profile')
		{
			//setProfile($params[$parameters[$tmp_i]],$profiles);
			 createParametersArray($profiles,$_SESSION['Profile']);
		}
		$filters[$parameters[$tmp_i]] = $params[$parameters[$tmp_i]];
		array_push($filterParameters,$parameters[$tmp_i]);
      }
	}
}
//var_dump($filters);
//var_dump($filterParameters);
//var_dump($_SESSION['Province']);
//var_dump($_SESSION['DistrictArray']);
//var_dump($_SESSION['LocalMunicipalityArray']);
//exit();

$_SESSION['filters'] = $filters;
$_SESSION['filterParameters'] = $filterParameters;

}
function readXMLConfigs($filename)
{
	if (file_exists($filename)) {
    $configs = simplexml_load_file($filename);
} else {
    exit('Failed to open:'.$filename);
}
return $configs;
}
function setProvincesAndYears($inputArray)
{
	$postfix = 'Array';
	$_SESSION['CaptureYear'.$postfix] = array();
	$_SESSION['Province'.$postfix] = array();
	$_SESSION['Needs'.$postfix] = array();
	for( $tmp_k = 0; $tmp_k < count($inputArray); $tmp_k++)
    {
		if(!itemExist($inputArray[$tmp_k]['CaptureYear'],$_SESSION['CaptureYear'.$postfix]))
		{
			array_push($_SESSION['CaptureYear'.$postfix],$inputArray[$tmp_k]['CaptureYear']);
		}
		if(!itemExist($inputArray[$tmp_k]['Province'],$_SESSION['Province'.$postfix]))
		{
			array_push($_SESSION['Province'.$postfix],$inputArray[$tmp_k]['Province']);
		}
		
		if(!itemExist($inputArray[$tmp_k][$_SESSION['Needs']],$_SESSION['Needs'.$postfix]))
		{
			array_push($_SESSION['Needs'.$postfix],$inputArray[$tmp_k][$_SESSION['Needs']]);
		}
		
	
    }

}
function setSubRegions($inputArray,$region,$regionValue,$subRegion)
{
	$postfix = 'Array';
	$_SESSION[$subRegion.$postfix] = array();
	for( $tmp_k = 0; $tmp_k < count($inputArray); $tmp_k++)
    { 
        if($inputArray[$tmp_k][$region] == $regionValue)
		{
		   if(!itemExist($inputArray[$tmp_k][$subRegion],$_SESSION[$subRegion.$postfix]))
		    {
			array_push($_SESSION[$subRegion.$postfix],$inputArray[$tmp_k][$subRegion]);
		    }
		}
    }

}

function sumArrayByColumns($inputArray,$inputArrayColumns)
{
	$outputArray = array();
	$outputArrayItem = array();
	$summaryFieldUniqueValues = array();
	$item = $inputArray[0];
 for($tmp_cat = 0; $tmp_cat < count($inputArrayColumns); $tmp_cat++)
	{

		//$tmp_sum = $item [$inputArrayColumns[$tmp_cat]];
		for($tmp_count = 1; $tmp_count < count($inputArray); $tmp_count++) 
		{
			if(is_numeric($item[$inputArrayColumns[$tmp_cat]]))
			{
			$item [$inputArrayColumns[$tmp_cat]] =$item [$inputArrayColumns[$tmp_cat]] + $inputArray[$tmp_count][$inputArrayColumns[$tmp_cat]];	
			}
		}
		//$item[$inputArrayColumns[$tmp_cat]]=$tmp_sum;
	}
	array_push($outputArray,$item);
	return $outputArray;
	
}
function summarizeArrayByParameter($inputArray,$inputArrayColumns,$summaryField)
{
	$outputArray = array();
	$outputArrayItem = array();
	$summaryFieldUniqueValues = array();

	for($tmp_count = 0; $tmp_count < count($inputArray); $tmp_count++)  
	{
		$item = $inputArray[$tmp_count][$summaryField];
		if(!itemExist($item,$summaryFieldUniqueValues))
		{
			$outputArrayItem = $inputArray[$tmp_count];
			array_push($summaryFieldUniqueValues,$item);
		}
	}
	
	for($tmp_count = 0; $tmp_count < count($summaryFieldUniqueValues); $tmp_count++)  
	{
		$tmp_arr = array();
		for($tmp_in = 0; $tmp_in < count($inputArray); $tmp_in++)
		{
			if($summaryFieldUniqueValues[$tmp_count] == $inputArray[$tmp_in][$summaryField])
			   array_push($tmp_arr,$inputArray[$tmp_in]);
		}
		$sumArray = array();
	   foreach($tmp_arr as $key => $subArray)
	   {
		//print_r($subArray);
			foreach($subArray as $id => $value)
			{
				if(isset($sumArray[$id]) AND is_numeric($sumArray[$id]) AND $id !='CaptureYear')
				   $sumArray[$id]+=$value;
			    else
					$sumArray[$id]=$value;
			}
	    }
		array_push($outputArray,$sumArray);

	}
	

	
	
	//var_dump($summaryFieldUniqueValues);
	//now for each unique value, calculate the 
	
	return $outputArray;
}
function summarizeArrayByParameterTest($inputArray,$inputArrayColumns,$summaryField)
{
	$outputArray = array();
	$outputArrayItem = array();
	$summaryFieldUniqueValues = array();

	for($tmp_count = 0; $tmp_count < count($inputArray); $tmp_count++)  
	{
		$item = $inputArray[$tmp_count][$summaryField];
		if(!itemExist($item,$summaryFieldUniqueValues))
		{
			$outputArrayItem = $inputArray[$tmp_count];
			array_push($summaryFieldUniqueValues,$item);
			array_push($outputArray,$outputArrayItem);
		}
		else
		{
			for($tmp_j = 0; $tmp_j < count($outputArray); $tmp_j++)  
	        {
				for($tmp_k = 0; $tmp_k < count($inputArrayColumns); $tmp_k++)  
				{
		           $outputArray[$tmp_j][$inputArrayColumns[$tmp_k ]] = $outputArray[$tmp_j][$inputArrayColumns[$tmp_k ]]+ $inputArray[$tmp_count][$inputArrayColumns[$tmp_k]];
				}
	        }
			
			
		}
		
		
	}
	return $outputArray;
}

function filterInputArrayByParameter($inputArray,$filterParam,$filterValue)
{
	$postfix = 'Array';
	$_SESSION['District'.$postfix ] = array();
	$_SESSION['LocalMunicipality'.$postfix] = array();

	$outputArray = array();
	if($filterParam == 'Category')
	{
		$_SESSION['total'] = $filterValue;
		$outputArray = $inputArray;

	}
	else{
		
	if($filterParam == 'Needs')
	{
		$filterParam = $_SESSION['Needs'];// = $filterValue;
		$outputArray = $inputArray;

	}
		
	for( $tmp_count = 0; $tmp_count < count($inputArray); $tmp_count++)  
	{
	   if($inputArray[$tmp_count][$filterParam]==$filterValue)
		{
			array_push($outputArray,$inputArray[$tmp_count]);
		if(!itemExist($inputArray[$tmp_count]['District'],$_SESSION['District'.$postfix ]))
		{
			array_push($_SESSION['District'.$postfix],$inputArray[$tmp_count]['District']);
		}
		if(!itemExist($inputArray[$tmp_count]['LocalMunicipality'],$_SESSION['LocalMunicipality'.$postfix]))
		{
			array_push($_SESSION['LocalMunicipality'.$postfix],$inputArray[$tmp_count]['LocalMunicipality']);
		}
			
		}
	}
}
	return $outputArray;
}
function arraysEqual($arrayOne,$arrayTwo)
{
	if(count($arrayOne)!= count($arrayTwo))
	{
		return false;
	}
	
	for( $tmp_count = 0; $tmp_count < count($arrayOne); $tmp_count++)  
	{
		for( $tmp_i = 0; $tmp_i < count($arrayItemKeys); $tmp_i++)  
		{
			if($inputArray[$tmp_count][$arrayItemKeys[$tmp_i]]==$arrayItem[$arrayItemKeys[$tmp_i]])
			{	
			return true;
			}
			
		}

		
	}
return false;
}
function itemExist($item,$inputArray)
{
	for( $tmp_count = 0; $tmp_count < count($inputArray); $tmp_count++)  
	{
	   if($inputArray[$tmp_count]==$item)
		{
			return true;
		}
		
	}
return false;
}

function curPageURL() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 //echo'Page URL: '.$pageURL;

 return $pageURL;
}
function createLinkURL($selectedParameter,$selectedParameterValue) {
$params = $_SESSION['filters'];
$parameters = $_SESSION['filterParameters'];
//$parameters = array('Profile','Category','CaptureYear','Province','District','LocalMunicipality','need','DocNeed','educationneed');

$linkURL = "index.php?".$selectedParameter."=".$selectedParameterValue;
for( $tmp_i = 0; $tmp_i < count($parameters); ++$tmp_i)
    {		
	if(isset($params[$parameters[$tmp_i]]) AND ($parameters[$tmp_i]!=$selectedParameter))
	{
	$linkURL .='&'.$parameters[$tmp_i].'='.$params[$parameters[$tmp_i]];
	}
	}
	
return $linkURL;

}

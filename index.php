<?php
spl_autoload_register(function ($class_name){
	include 'assets/classes/'.$class_name.'.php';
});

include_once('assets\functions\globalFunctions.php');



/*
if( !isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60 ) 
{
  $_SESSION['last_access'] = time(); 
}
*/
$postfix = 'Array';
setSessionParametersFromQueryString();
$filteredItems = $_SESSION['rawdata'];
$map_extraction_level = 'Province';

if(isset($_SESSION['filters']['Province']))
{
		$map_extraction_level = 'District';
		 $filteredItems = filterInputArrayByParameter($filteredItems,'Province',$_SESSION['filters']['Province']);
}
if(isset($_SESSION['filters']['District']))
{
		$map_extraction_level = 'LocalMunicipality';
		$filteredItems = filterInputArrayByParameter($filteredItems,'District',$_SESSION['filters']['District']);
}
if(isset($_SESSION['filters']['LocalMunicipality']))
{
		$filteredItems = filterInputArrayByParameter($filteredItems,'LocalMunicipality',$_SESSION['filters']['LocalMunicipality']);
		$map_extraction_level = 'Province';
}
for( $tmp_k = 0; $tmp_k < count($_SESSION['filterParameters']); $tmp_k++)
{
	if($_SESSION['filterParameters'][$tmp_k]!='Profile' AND $_SESSION['filterParameters'][$tmp_k]!='Province' AND $_SESSION['filterParameters'][$tmp_k]!='District' AND $_SESSION['filterParameters'][$tmp_k]!='LocalMunicipality')
	  $filteredItems = filterInputArrayByParameter($filteredItems,$_SESSION['filterParameters'][$tmp_k],$_SESSION['filters'][$_SESSION['filterParameters'][$tmp_k]]);
}
//var_dump($map_extraction_level);
//	exit();	

//var_dump($filteredItems);

//var_dump($filteredItems);

//var_dump($summarizedItems);
//exit();

//var_dump($map_extraction_level);
$mapDataFilteredItems =  summarizeArrayByParameter($filteredItems,$_SESSION['Category'.$postfix],$map_extraction_level);

//var_dump($mapDataFilteredItems);
//exit();

//var_dump($_SESSION['total']);
//$mapDataFilteredItems = summarizeArrayByParameter($filteredItems,$_SESSION['columns'],$map_extraction_level);




?>

<html>
<head>
<title>Social Barometer powered by FusionCharts Suite XT</title>

  <script type="text/javascript" src="assets/fusioncharts/js/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="assets/fusioncharts/js/fusioncharts.js"></script>
  <script type="text/javascript" src="assets/fusioncharts/js/fusioncharts.charts.js"></script>
  <script type="text/javascript" src="assets/fusioncharts/js/themes/fusioncharts.theme.zune.js"></script>
 <!--- <script type="text/javascript" src="http://localhost/7046/fusioncharts/js/app.js"></script> !--->
<script type="text/javascript" src="assets/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
 <!---
 <script type ="text/javascript" src="http://localhost/7046/fusioncharts/js/menu.js" ></script> 
  <link href="http://localhost/7046/fusioncharts/assets/css/menu.css" type="text/css" rel="stylesheet"> 
    <link href="http://localhost/7046/fusioncharts/assets/css/style.css" type="text/css" rel="stylesheet"> 
   !--->

     <link href="assets/css/menustyle.css" type="text/css" rel="stylesheet" media="screen"> 

<script type="text/javascript">
FusionCharts.ready(function () {
<?php
$mapChart = new CreateMapChart();
echo $mapChart->createMapString($mapDataFilteredItems,$_SESSION['total'],$map_extraction_level);

$pieChart = new CreateMapChart($type="pie3d",$width=450,$height=300,$dataFormat="json",$renderAt="pieChartContainer",$dataSource=null);
echo $pieChart->createMapString($mapDataFilteredItems,$_SESSION['total'],$map_extraction_level);

$columnChartArray = sumArrayByColumns($mapDataFilteredItems,$_SESSION['CategoryArray']);

$columnChart = new CreateColumnChart($type="column3d",$width=450,$height=300,$dataFormat="json",$renderAt="columnChartContainer",$dataSource=null);
echo $columnChart->createMapString($columnChartArray,$_SESSION['CategoryArray'],$_SESSION['columns_labels']);

//$mapDataFilteredItems = summarizeArrayByParameter($filteredItems,$_SESSION['Needs'.$postfix],$map_extraction_level);
//$stackedChart = new CreateStackedChart($type="stacked3d",$width=500,$height=300,$dataFormat="json",$renderAt="stackedChartContainer",$dataSource=null);
//echo $pieChart->createMapString($mapDataFilteredItems,$_SESSION['total'],$map_extraction_level);

?>	  

});
</script>
</head>
<body>
	
<div id='container'>
    <div id='header'>
        <div id='logoContainer'>
            <div>

            </div>
			
        </div>

 <ul id="nav">
       <li class="current"><a href="index.php?Profile=Education%20Walk2School" class="menulink">Needs</a>
       <ul>
		<?php
		for($tmp_count=0; $tmp_count<count($_SESSION['Needs'.$postfix]);$tmp_count++)
		{	
        ?>	
          <li><a href="<?php echo createLinkURL('Needs',$_SESSION['Needs'.$postfix][$tmp_count])?>"><?php echo $_SESSION['Needs'.$postfix][$tmp_count]?></a></li>
	<?php
		}
		?>
        </ul>

     <li><a href="index.php?Profile=Education%20Walk2School" class="menulink">Profiles</a>
        <ul>
		<?php
		for($tmp_count=0; $tmp_count<count($_SESSION['Profile'.$postfix]);$tmp_count++)
		{	
        ?>	
          <li><a href="<?php echo createLinkURL('Profile',$_SESSION['Profile'.$postfix][$tmp_count])?>"><?php echo $_SESSION['Profile'.$postfix][$tmp_count]?></a></li>
	<?php
		}
		?>
      </ul>
</li> 
 
	<?php if(isset($_SESSION['Profile'])){ ?>

	<?php 
	if(isset($_SESSION['Category'.$postfix]))
	{
	?>
	 <li><a href="<?php echo createLinkURL('Profile',$_SESSION['Profile'])?>" class="menulink"><?php echo $_SESSION['Profile'];?></a>
	 <ul>
	<?php 
	//createLinkURL('Profile',$_SESSION['Profile'])
		for($tmp_count = 0; $tmp_count < count($_SESSION['Category'.$postfix]);++$tmp_count)
		{
			?>
		<li><a href="<?php echo createLinkURL('Category',$_SESSION['Category'.$postfix][$tmp_count]) ;?>"><?php echo $_SESSION['columns_labels'][$tmp_count];?></a></li>
		<?php
		}
	 ?>
        </ul>
		</li>
	<?php
	}
	?>
    
	<?php
	}
	?>

	<?php if(isset($_SESSION['CaptureYear'.$postfix])){ ?>
    
    <li><a href=""><?php echo 'Years';?></a>
	<?php 
	if(isset($_SESSION['CaptureYear'.$postfix]))
	{
	?>
	  <ul>
	<?php 
		for($tmp_count = 0; $tmp_count < count($_SESSION['CaptureYear'.$postfix]);++$tmp_count)
		{
			?>
		<li><a href="<?php echo createLinkURL('CaptureYear',$_SESSION['CaptureYear'.$postfix][$tmp_count]) ;?>"> <?php echo $_SESSION['CaptureYear'.$postfix][$tmp_count];?></a></li>
		<?php
		}
	 ?>
       </ul>
	   </li>
	<?php
	}
	}
	?>
    
	
	<?php 

	if(isset($_SESSION['filters']['Province']) AND !isset($_SESSION['filters']['District']))
	{ ?>
    
      <li> <a href="index.php?Profile=Education%20Walk2School" class="menulink"><?php echo 'Province: '.$_SESSION['filters']['Province'];?></a>
	  <ul>
	<?php 
	if(isset($_SESSION['District'.$postfix]))
	{
	?>
	
	<?php 
		for($tmp_count = 0; $tmp_count < count($_SESSION['District'.$postfix]);++$tmp_count)
		{
            echo '<li><a href="'.createLinkURL('District',$_SESSION['District'.$postfix][$tmp_count]).'">'.$_SESSION['District'.$postfix][$tmp_count].'</a></li>';
		}
	 ?>
       
	<?php
	}
	?>
 
	<?php
	}
	else if(isset($_SESSION['filters']['Province']) AND isset($_SESSION['filters']['District']))
	{ ?>
   
     <li>   <a href="index.php?Province=<?php echo $_SESSION['Province'];?>" class="menulink"><?php echo 'District: '.$_SESSION['filters']['District'];?></a>
	<?php 
	if(isset($_SESSION['LocalMunicipality'.$postfix]))
	{
	?>
	  <ul>
	<?php 
		for($tmp_count = 0; $tmp_count < count($_SESSION['LocalMunicipality'.$postfix]);++$tmp_count)
		{
            echo '<li><a href="'.createLinkURL('LocalMunicipality',$_SESSION['LocalMunicipality'.$postfix][$tmp_count]).'">'.$_SESSION['LocalMunicipality'.$postfix][$tmp_count].'</a></li>';
		}
	 ?>
        
	<?php
	}
	?>
    
	<?php
	}
	
	else {
	?>
   
      <li> <a href="" class="menulink"><?php echo 'Provinces';?></a>
	<?php 
	
	if(isset($_SESSION['Province'.$postfix]))
	{
	?>
	  <ul>
	<?php 
		for($tmp_count = 0; $tmp_count < count($_SESSION['Province'.$postfix]);++$tmp_count)
		{
            echo '<li><a href="'.createLinkURL('Province',$_SESSION['Province'.$postfix][$tmp_count]).'">'.$_SESSION['Province'.$postfix][$tmp_count].'</a></li>';
		}
	 ?>
        
	<?php
	}
		
	}
	?>
	</ul>
	</li>


      
  
		

		
		
<div id='userDetail'>




		</div>
        <div></div>
    </div>

    <div  id='content'>

      <div class='border-bottom'>
        <div class='chartCont border-right' id='needsMapContainer'>FusionCharts will load here.</div>
        <div class='chartCont' id='pieChartContainer'>FusionCharts will load here.</div>
      </div>
       <div class='border-bottom'>
        <div class='chartCont border-right' id='columnChartContainer'>FusionCharts will load here.</div>
        <div class='chartCont' id='stackedChartContainer'>FusionCharts will load here.</div>
      </div>
    </div>
    <div id='footer'>
        <p>This application was built using <a href="http://www.fusioncharts.com" target="_blank" title="FusionCharts - Data to delight... in minutes"><b>FusionCharts Suite XT</b></a>
</p>
    </div>
</div>
</body>
</html>
<?php
//unset($_SESSION);
<?php
spl_autoload_register(function ($class_name){
	include $class_name.'.php';
});

class CreatePieChart extends FusionChart
{

	public function __construct($type="pie3d",$width=500,$height=300,$dataFormat="json",$renderAt="pieChartContainer",$dataSource=null)
	{
		parent::__construct($type,$width,$height,$dataFormat,$renderAt,$dataSource);
	}
public function createPieDataArray($sel_column,$input_array)
{
	$this->initialize();
	$output_array = array();
    $output_array = $this->loopThroughDataArray($sel_column,$input_array,$output_array);
    return $output_array;
}
 
 public function createPieDataArrayByRegion($sel_column,$input_array)
{
	$this->initialize();
	$output_array = array();
    $output_array = $this->loopThroughDataArrayByRegion($sel_column,$input_array,$output_array);
    return $output_array;
}
 
public function createPieDataArrayByYear($sel_column,$input_array)
{
	$this->initialize();
	$output_array = array();
    $output_array = $this->loopThroughDataArrayByYear($sel_column,$input_array,$output_array);
    return $output_array;
}
 

public function createChartString($region="Province")
{
	$dataSet =	$_SESSION[$_SESSION['sel']];
	$subcaption = '';
	$caption = 'Total '.$_SESSION['profile'];
	
	if(isset($_SESSION['year']))
	{
	$dataSet = $this->createPieDataArrayByYear($region,$dataSet);
	$subcaption .= ' Year = '.$_SESSION['year'];
	}
	if(isset($_SESSION['viewsel']))
	{
	$dataSet = $this->createPieDataArrayByRegion($region,$dataSet);
	$subcaption .= ' Region = '.$_SESSION['viewsel'];
	}
	else
	{
	$dataSet = $this->createPieDataArray($region,$dataSet);
	}
	
	$this->chart_ = '
		var pieChartByProvince = new FusionCharts({
        type:"'.$this->type_.'",
        renderAt:"'.$this->renderAt_.'",
        width: "'.$this->width_.'",
        height: "'.$this->height_.'",
        dataFormat: "'.$this->dataFormat_.'",
        dataSource:{
            "chart": {"caption": "Total '.$_SESSION['profile'].'  by Province",
                "subcaption": "'.$subcaption.'",
                "entityFillHoverColor": "#cccccc",
                "numberScaleValue": "1,1000,1000",
                "numberScaleUnit": ",K,M",
                "numberPrefix": "",
                "showLabels": "1",
                "theme": "zune"},
            "colorrange": {
                "minvalue": "'.$this->minimum_value_.'",
                "startlabel": "Low",
                "endlabel": "High",
                "code": "#6baa01",
                "gradient": "1",
                "color": [
                    {
                        "maxvalue": "'.(($this->maximum_value_+$this->minimum_value_)/2).'",
                        "displayvalue": "Average",
                        "code": "#f8bd19"
                    },
                    {
                        "maxvalue": "'.$this->maximum_value_.'",
                        "code": "#e44a00"
                    }
                ]
            },
            "data": '.json_encode($this->result_set_).'
        }
    }).render();
';
return $this->chart_;

}



	public function __destruct()
	{}





}


/*
$test_str = json_encode($profile->getProfileFromDatabaseAsJSON());
echo $test_str;
echo ''.PHP_EOL;
$test_str = json_decode($test_str,true);
 for( $tmp_i = 0; $tmp_i < count($test_str); $tmp_i++)
    {
		
    for( $tmp_j = 0; $tmp_j < count($this->sqlSelectQueryStatement_->getColumns()); $tmp_j++)
    {
		echo $test_str[$tmp_i][$profile->getColumnsArray()[$tmp_j]].'|';
    }
	echo '<br/>';
    }
*/
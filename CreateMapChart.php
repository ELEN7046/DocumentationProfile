<?php
spl_autoload_register(function ($class_name){
	include 'assets/classes/'.$class_name.'.php';
});
include_once('assets\functions\globalFunctions.php');

class CreateMapChart extends FusionChart
{
	protected $result_set_;
	
	protected $minimum_value_ ;
    protected $maximum_value_ ;


	public function __construct($type="maps/southafrica",$width=450,$height=300,$dataFormat="json",$renderAt="needsMapContainer",$dataSource=null)
	{
		parent::__construct($type,$width,$height,$dataFormat,$renderAt,$dataSource);
	}

public function extractMapData($input_array,$sum_column,$extraction_level)
{
	$this->initialize();
		 for( $tmp_j = 0; $tmp_j < count($input_array); $tmp_j++)
		 {
		 if($this->minimum_value_ > $input_array[$tmp_j][$sum_column])
		 {
			 $this->minimum_value_ = $input_array[$tmp_j][$sum_column];
		 }
		 if($this->maximum_value_ < $input_array[$tmp_j][$sum_column])
		 {
			 $this->maximum_value_ = $input_array[$tmp_j][$sum_column];
		 }
    $result_item["label"] = $input_array[$tmp_j][$extraction_level];
	$result_item["id"] = get_province_id($input_array[$tmp_j]['Province']);
	$result_item["value"] = $input_array[$tmp_j][$sum_column];
	$result_item ["link"] = createLinkURL($extraction_level,$input_array[$tmp_j][$extraction_level]);
	
	array_push($this->result_set_,$result_item);
		 }
		unset($result_item);
}


public function createMapString($input_array,$sum_column,$extraction_level)
{
	
	$this->extractMapData($input_array,$sum_column,$extraction_level);
	$subcaption = '';
	$caption = 'Total '.$_SESSION['Profile'];
	
	
	$this->chart_ = '
		var '.$this->renderAt_.' = new FusionCharts({
        type:"'.$this->type_.'",
        renderAt:"'.$this->renderAt_.'",
        width: "'.$this->width_.'",
        height: "'.$this->height_.'",
        dataFormat: "'.$this->dataFormat_.'",
        dataSource:{
            "chart": {"caption": "Total '.$_SESSION['Profile'].'  by Province",
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
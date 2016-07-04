<?php
spl_autoload_register(function ($class_name){
	include $class_name.'.php';
});
//include('globalFunctions.php');

class CreateColumnChart extends FusionChart
{
	protected $result_set_;
	
	protected $minimum_value_ ;
    protected $maximum_value_ ;


	public function __construct($type="column3d",$width=450,$height=350,$dataFormat="json",$renderAt="needsMapContainer",$dataSource=null)
	{
		parent::__construct($type,$width,$height,$dataFormat,$renderAt,$dataSource);
	}

public function extractMapData($input_array,$sum_columns,$sum_columns_labels)
{
	$this->initialize();
	
	 for( $tmp_j = 0; $tmp_j < count($sum_columns); $tmp_j++)
		 {
    $result_item["label"] = $sum_columns_labels[$tmp_j]; ;
	$result_item["id"] = $sum_columns[$tmp_j];
	$result_item["value"] = $input_array[0][$sum_columns[$tmp_j]];
	//$result_item ["link"] = $current_prov_total;
	array_push($this->result_set_,$result_item);
		 }
		unset($result_item);
}

public function createMapString($input_array,$sum_columns,$sum_columns_labels)
{
	$this->extractMapData($input_array,$sum_columns,$sum_columns_labels);
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
            "chart": {"caption": "Total '.$_SESSION['Profile'].' By Category",
                "subcaption": "'.$subcaption.'",
                "entityFillHoverColor": "#cccccc",
                "numberScaleValue": "1,1000,1000",
                "numberScaleUnit": ",K,M",
                "numberPrefix": "",
                "showLabels": "1",
                "theme": "zune"},
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
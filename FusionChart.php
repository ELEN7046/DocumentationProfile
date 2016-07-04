<?php
spl_autoload_register(function ($class_name){
	include $class_name.'.php';
});

class FusionChart
{
	protected  $type_;
	protected  $renderAt_;
	protected  $width_;
	protected  $height_;
	protected  $dataFormat_;
	protected  $dataSource_;
	
	protected $chart_;
	
	protected $columns_array_; 
	protected $result_set_;
	protected $result_item_ ;
	
	protected $sum_column_; 
	protected $sum_sel_;
	
	protected $minimum_value_ ;
    protected $maximum_value_ ;
	
	protected $categories_ ;
    protected $yes_ ;
	protected $no_ ;
	protected $not_selected_ ;

	
	public function __construct($type,$width=450,$height=300,$dataFormat="json",$renderAt=null,$dataSource=null)
	{
		$this->type_ = $type;
		$this->renderAt_ =$renderAt;
		$this->width_ = $width;
		$this->height_ = $height;
		$this->dataFormat_ = $dataFormat;
		$this->dataSource_ = $dataSource;
		$this->initialize();
	}
	public function initialize()
{
	$this->result_set_ = array();
    $this->result_item_ = array();
	$this->columns_array_ = array();
    $this->minimum_value_ = 100000000;
    $this->maximum_value_  = 0;
	
	$this->categories_  = array();
	$this->yes_  = array();
	$this->no_  = array();
	$this->not_selected_  = array();


}

public function itemExists($item)
{
	if(!isset($this->columns_array_))
	{
		return false;
	}
	if(count($this->columns_array_)==0)
	{
		return false;
	}
	for( $tmp_i = 0; $tmp_i < count($this->columns_array_); $tmp_i++)
	{
	if($this->columns_array_[$tmp_i ]==$item)
	{
		return true;
	}
	}
	return false;
}


public function createStackedDataArrayByYear($sel_column,$input_array)
{
	$this->initialize();
	$output_array = array();
	$items_sum_array = array();
	$items_sum__item_array = array();
	$need_array = array('Yes','No','Not Selected');
	for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	{
	 $items_sum__item_array[$need_array[$tmp_k]]= 0;
	 array_push($items_sum_array,$items_sum__item_array);

	}

	for( $tmp_count = 0; $tmp_count < count($input_array); $tmp_count++)  
	{
		$item = $input_array[$tmp_count][$sel_column];
		if($_SESSION['year']== $input_array[$tmp_count]['CaptureYear'])
		{
		if(!$this->itemExists($item))
		{
		//$items_sum__item_array['region'] = $item;
		
		for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	    {
	   		$items_sum__item_array[$item][$need_array[$tmp_k]] = 0;
			if($input_array[$tmp_count][$_SESSION['need']]==$need_array[$tmp_k])
		    {
		     $items_sum__item_array[$item][$need_array[$tmp_k]] = $items_sum__item_array[$item][$need_array[$tmp_k]] + $input_array[$tmp_count][$this->sum_column_];
		    }
	    }
		array_push($this->columns_array_,$item);
		array_push($output_array,$input_array[$tmp_count]);
	   }
	   else { //selected item already exist
		for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	    {
			if($input_array[$tmp_count][$_SESSION['need']]==$need_array[$tmp_k])
		    {
		     $items_sum__item_array[$item][$need_array[$tmp_k]] = $items_sum__item_array[$item][$need_array[$tmp_k]] + $input_array[$tmp_count][$this->sum_column_];
		    }
	    }
		array_push($output_array,$input_array[$tmp_count]);
	   }
	}
	}
	//var_dump($items_sum__item_array);
	for( $tmp_j = 0; $tmp_j < count($this->columns_array_); $tmp_j++)  
	{
		$yes_array_item = array();
		$no_array_item = array();
		$not_sel_array_item = array();
		
		$this->result_item_ ["label"] = $this->columns_array_[$tmp_j];
	    $this->result_item_ ["id"] = $this->columns_array_[$tmp_j];
		array_push($this->categories_ ,$this->result_item_);
		//for( $tmp_k = 0; $tmp_k < count($items_sum__item_array); $tmp_k++)
		{
			    $yes_array_item["label"] = $this->columns_array_[$tmp_j];
	            $yes_array_item["id"] = $this->columns_array_[$tmp_j];
                $yes_array_item ["value"] = 0;
				$no_array_item["label"] = $this->columns_array_[$tmp_j];
	            $no_array_item["id"] = $this->columns_array_[$tmp_j];
                $no_array_item ["value"] = 0;
				$not_sel_array_item["label"] = $this->columns_array_[$tmp_j];
	            $not_sel_array_item["id"] = $this->columns_array_[$tmp_j];
                $not_sel_array_item ["value"] = 0;
				
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['Yes']))
				{
				 $yes_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['Yes'];
				 array_push($this->yes_ ,$yes_array_item);
				}
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['No']))
				{
				 $no_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['No'];
				 array_push($this->no_ ,$no_array_item);
				}
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['Not Selected']))
				{
				 $not_sel_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['Not Selected'];
				 array_push($this->not_selected_ ,$not_sel_array_item);
				}

	            //$result_item ["link"] = $current_prov_total;

			   	
			   	
			    
		}			
			
	}
	
return $output_array;
 }
public function createStackedDataArrayByRegion($sel_column,$input_array)
{
	$this->initialize();
	$output_array = array();
	$items_sum_array = array();
	$items_sum__item_array = array();
	$need_array = array('Yes','No','Not Selected');
	for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	{
	 $items_sum__item_array[$need_array[$tmp_k]]= 0;
	 array_push($items_sum_array,$items_sum__item_array);

	}

	for( $tmp_count = 0; $tmp_count < count($input_array); $tmp_count++)  
	{
		$item = $input_array[$tmp_count][$sel_column];
		if($_SESSION['viewsel']== $input_array[$tmp_count][$_SESSION['views'][$_SESSION['view_pos']-1]])
		{
		if(!$this->itemExists($item))
		{
		//$items_sum__item_array['region'] = $item;
		
		for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	    {
	   		$items_sum__item_array[$item][$need_array[$tmp_k]] = 0;
			if($input_array[$tmp_count][$_SESSION['need']]==$need_array[$tmp_k])
		    {
		     $items_sum__item_array[$item][$need_array[$tmp_k]] = $items_sum__item_array[$item][$need_array[$tmp_k]] + $input_array[$tmp_count][$this->sum_column_];
		    }
	    }
		array_push($this->columns_array_,$item);
		array_push($output_array,$input_array[$tmp_count]);
	   }
	   else { //selected item already exist
		for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	    {
			if($input_array[$tmp_count][$_SESSION['need']]==$need_array[$tmp_k])
		    {
		     $items_sum__item_array[$item][$need_array[$tmp_k]] = $items_sum__item_array[$item][$need_array[$tmp_k]] + $input_array[$tmp_count][$this->sum_column_];
		    }
	    }
		array_push($output_array,$input_array[$tmp_count]);
	   }
	}
	}
	//var_dump($items_sum__item_array);
	for( $tmp_j = 0; $tmp_j < count($this->columns_array_); $tmp_j++)  
	{
		$yes_array_item = array();
		$no_array_item = array();
		$not_sel_array_item = array();
		
		$this->result_item_ ["label"] = $this->columns_array_[$tmp_j];
	    $this->result_item_ ["id"] = $this->columns_array_[$tmp_j];
		array_push($this->categories_ ,$this->result_item_);
		//for( $tmp_k = 0; $tmp_k < count($items_sum__item_array); $tmp_k++)
		{
			    $yes_array_item["label"] = $this->columns_array_[$tmp_j];
	            $yes_array_item["id"] = $this->columns_array_[$tmp_j];
                $yes_array_item ["value"] = 0;
				$no_array_item["label"] = $this->columns_array_[$tmp_j];
	            $no_array_item["id"] = $this->columns_array_[$tmp_j];
                $no_array_item ["value"] = 0;
				$not_sel_array_item["label"] = $this->columns_array_[$tmp_j];
	            $not_sel_array_item["id"] = $this->columns_array_[$tmp_j];
                $not_sel_array_item ["value"] = 0;
				
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['Yes']))
				{
				 $yes_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['Yes'];
				 array_push($this->yes_ ,$yes_array_item);
				}
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['No']))
				{
				 $no_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['No'];
				 array_push($this->no_ ,$no_array_item);
				}
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['Not Selected']))
				{
				 $not_sel_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['Not Selected'];
				 array_push($this->not_selected_ ,$not_sel_array_item);
				}
			    
		}			
			
	}
	
return $output_array;

 }
public function createStackedDataArray($sel_column,$input_array)
{
	$this->initialize();
	$output_array = array();
	$items_sum_array = array();
	$items_sum__item_array = array();
	$need_array = array('Yes','No','Not Selected');
	for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	{
	 $items_sum__item_array[$need_array[$tmp_k]]= 0;
	 array_push($items_sum_array,$items_sum__item_array);

	}

	for( $tmp_count = 0; $tmp_count < count($input_array); $tmp_count++)  
	{
		$item = $input_array[$tmp_count][$sel_column];
		
		if(!$this->itemExists($item))
		{
		//$items_sum__item_array['region'] = $item;
		
		for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	    {
	   		$items_sum__item_array[$item][$need_array[$tmp_k]] = 0;
			if($input_array[$tmp_count][$_SESSION['need']]==$need_array[$tmp_k])
		    {
		     $items_sum__item_array[$item][$need_array[$tmp_k]] = $items_sum__item_array[$item][$need_array[$tmp_k]] + $input_array[$tmp_count][$this->sum_column_];
		    }
	    }
		array_push($this->columns_array_,$item);
		array_push($output_array,$input_array[$tmp_count]);
	   }
	   else { //selected item already exist
		for( $tmp_k = 0; $tmp_k < count($need_array ); $tmp_k++)  
	    {
			if($input_array[$tmp_count][$_SESSION['need']]==$need_array[$tmp_k])
		    {
		     $items_sum__item_array[$item][$need_array[$tmp_k]] = $items_sum__item_array[$item][$need_array[$tmp_k]] + $input_array[$tmp_count][$this->sum_column_];
		    }
	    }
		array_push($output_array,$input_array[$tmp_count]);
	   }
	}
	//var_dump($items_sum__item_array);
	for( $tmp_j = 0; $tmp_j < count($this->columns_array_); $tmp_j++)  
	{
		$yes_array_item = array();
		$no_array_item = array();
		$not_sel_array_item = array();
		
		$this->result_item_ ["label"] = $this->columns_array_[$tmp_j];
	    $this->result_item_ ["id"] = $this->columns_array_[$tmp_j];
		array_push($this->categories_ ,$this->result_item_);
		//for( $tmp_k = 0; $tmp_k < count($items_sum__item_array); $tmp_k++)
		{
			    $yes_array_item["label"] = $this->columns_array_[$tmp_j];
	            $yes_array_item["id"] = $this->columns_array_[$tmp_j];
                $yes_array_item ["value"] = 0;
				$no_array_item["label"] = $this->columns_array_[$tmp_j];
	            $no_array_item["id"] = $this->columns_array_[$tmp_j];
                $no_array_item ["value"] = 0;
				$not_sel_array_item["label"] = $this->columns_array_[$tmp_j];
	            $not_sel_array_item["id"] = $this->columns_array_[$tmp_j];
                $not_sel_array_item ["value"] = 0;
				
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['Yes']))
				{
				 $yes_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['Yes'];
				 array_push($this->yes_ ,$yes_array_item);
				}
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['No']))
				{
				 $no_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['No'];
				 array_push($this->no_ ,$no_array_item);
				}
				if(isset($items_sum__item_array[$this->columns_array_[$tmp_j]]['Not Selected']))
				{
				 $not_sel_array_item ["value"] = $items_sum__item_array[$this->columns_array_[$tmp_j]]['Not Selected'];
				 array_push($this->not_selected_ ,$not_sel_array_item);
				}
			    
		}			
			
	}
	
return $output_array;

 }
 
public function loopThroughDataArrayByYear($sel_column,$input_array,$output_array)
{
	for( $tmp_count = 0; $tmp_count < count($input_array); $tmp_count++)
	{
	if($_SESSION['year']== $input_array[$tmp_count]['CaptureYear'])
	{
		$output_array = $this->throughDataArray($sel_column,$input_array[$tmp_count ],$output_array);
	}
	}
	return $output_array;
}

public function loopThroughDataArrayByRegion($sel_column,$input_array,$output_array)
{
	for( $tmp_count = 0; $tmp_count < count($input_array); $tmp_count++)
	{
	if($_SESSION['viewsel']== $input_array[$tmp_count][$_SESSION['views'][$_SESSION['view_pos']-1]])
	{
		$output_array = $this->throughDataArray($sel_column,$input_array[$tmp_count ],$output_array);
	}
	}
	return $output_array;
}

public function throughDataArray($sel_column,$input_array,$output_array)
{
		$item = $input_array[$sel_column];
		$result_item = array();
		if(!$this->itemExists($item))
		{
	    $current_item_total = 0;
	 
		 for( $tmp_j = 0; $tmp_j < count($input_array); $tmp_j++)
		 {
			 if($input_array[$sel_column] ==  $item)
			 {
				 $current_item_total = $current_item_total + $input_array[$this->sum_column_]; 
			 }
		 }
		 if($this->minimum_value_ > $current_item_total)
		 {
			 $this->minimum_value_ = $current_item_total;
		 }
		 if($this->maximum_value_ < $current_item_total)
		 {
			 $this->maximum_value_ = $current_item_total;
		 }
    $result_item["label"] = $item;
	$result_item["id"] = $this->get_province_id($input_array['Province']);
	$result_item["value"] = $current_item_total;
	//$result_item ["link"] = $current_prov_total;
	array_push($this->result_set_,$result_item);
	
	array_push($this->columns_array_,$item);
	array_push($output_array,$input_array);
			
		}
		return $output_array;
}
 
public function loopThroughDataArray($sel_column,$input_array,$output_array)
{
	for( $tmp_count = 0; $tmp_count < count($input_array); $tmp_count++)
	{
     $output_array = $this->throughDataArray($sel_column,$input_array[$tmp_count ],$output_array);
	}
	return $output_array;
}

 
public function get_province_id($province)
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
	
	public function set_type($value)
	{
		$this->type_ = $value;
	}
	public function get_type()
	{
		return $this->type_;
	}
	public function set_renderAt($value)
	{
		$this->renderAt_ = $value;
	}
	public function get_renderAt()
	{
		return $this->renderAt_;
	}
	public function set_width($value)
	{
		$this->width_ = $value;
	}
	public function get_width()
	{
		return $this->width_;
	}
	public function set_height($value)
	{
		$this->width_ = $value;
	}
	public function get_height()
	{
		return $this->height_;
	}
	public function set_dataFormat($value)
	{
		$this->dataFormat_ = $value;
	}
	public function get_dataFormat()
	{
		return $this->dataFormat_;
	}
	public function set_dataSource($value)
	{
		$this->dataSource_ = $value;
	}
	public function get_dataSource()
	{
		return $this->dataSource_;
	}
	public function __destruct()
	{}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportCSV extends CI_Controller {

	public function index()
	{
		$this->load->view('exportCSV');
  }
  
	public function filtered()
	{
    $data = array();
    $memData = array();
    $output = array();
    $rowCount = 0;
    if(is_uploaded_file($_FILES['csv']['tmp_name'])){
        $csvData = $this->csvreader->parse_csv($_FILES['csv']['tmp_name']);
        if(!empty($csvData)){
            foreach($csvData as $head => $row){ $rowCount++;
                if(strpos($row['COUNTRY'], 'USA') !== false){
                  $memData += array(
                      $head => $row
                  );
                }
            }
            $filename = 'filteredCountry_'.date('Ymdhsi').'.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            $header = array("SKU", "DESCRIPTION", "YEAR", "CAPACITY", "URL", "PRICE", "SELLER_INFORMATION", "OFFER_DESCRIPTION", "COUNTRY");
            fputcsv($file, $header);
     
            foreach ($memData as $line){
                fputcsv($file,$line);
            }
     
            fclose($file);
            exit;
        }
    }else{
        $this->session->set_userdata('errors', 'Error on file upload, please try again.');
    }
  }
  
	public function pricefilter()
	{
    $data = array();
    $memData = array();
    $output = array();
    $rowCount = 0;
    $min_price = 0;
    $max_price = 0;
    if(is_uploaded_file($_FILES['csv']['tmp_name'])){
        $csvData = $this->csvreader->parse_csv($_FILES['csv']['tmp_name']);
        if(!empty($csvData)){
            foreach($csvData as $head => $row){ $rowCount++;
              if(isset($csvData[$head - 1]) && in_array($csvData[$head - 1]['SKU'] , $row)){
                array_push($memData[$csvData[$head - 1]['SKU']], round(trim($row['PRICE'], "$")) );
              }
              else{
                $memData[$csvData[$head]['SKU']] = array( round(trim($row['PRICE'], "$")));
              }
            }
            foreach($memData as $key => $val){
              if(count($memData[$key]) >= 2){
                $filter = $this->sorting($memData[$key]);
                $output[] = array(
                  
                  'SKU' => $key,
                  'FIRST_MINIMUM_PRICE' => $filter['min1'],
                  'SECOND_MINIMUM_PRICE' => $filter['min2'],
                );
              }else{
                $output[] = array(
                  'SKU' => $key,
                  'FIRST_MINIMUM_PRICE' => isset($val[0]) ? $val[0] : '',
                  'SECOND_MINIMUM_PRICE' => isset($val[1]) ? $val[1] : '',
                );
              }
            }
            $filename = 'lowestPrice_'.date('Ymdhsi').'.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            $header = array("SKU", "FIRST_MINIMUM_PRICE", "SECOND_MINIMUM_PRICE");
            fputcsv($file, $header);
     
            foreach ($output as $line){
                fputcsv($file,$line);
            }
            fclose($file);
            exit;
        }
    }else{
        $this->session->set_userdata('errors', 'Error on file upload, please try again.');
        redirect('/','refresh');
    }
  }
  
  public function sorting($a){
    $min1 = $a[0];
    $min2 = isset($a[1]) ? $a[1] : 0;
    if ($min2 < $min1)
    {
        $min1 = isset($a[1]) ? $a[1] : 0;
        $min2 = $a[0];
    }
    for ($i = 2; $i < count($a); $i++)
        if ($a[$i] < $min1)
        {
            $min2 = $min1;
            $min1 = $a[$i];
        }
        else if ($a[$i] < $min2)
        {
            $min2 = $a[$i];
        }

    return array('min1' => $min1, 'min2'=> $min2);
  }
}

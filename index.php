<?php
/*
Plugin Name: Nepse Stocks Plugin
Plugin URI: https://bitbucket.org/himalayantechies/stockspluginwp
Description: Displays real time data fetched from nepse (Nepal Stock Exchange)
Author: Himalayan Techies, H.T. Solutions Pvt. Ltd.
Author URI: https://http://himalayantechies.com/
Author email: info@himalayantechies.com
*/

$dirName = dirname(__FILE__);

$dirName = dirname(__FILE__);
$WPdirName = substr($dirName, 0, (strlen($dirName)-34));

require_once( $WPdirName.'/wp-config.php');

?>
<style>
<?php 
	include 'wp-admin-ui/style.css'; 
?>
</style>
<div class="wrap">
	<div id="stocksMarquee">
		<marquee><?php echo getDataforMarquee(); ?></marquee>
	</div>
	<div class="stocksTable">
		<?php   ?>
		<table class="stkTable">
			<?php 
				$tableHeaders = get_tableHeaders_stocksData();
				foreach($tableHeaders as $th){
			?>
				<th class="stkTableHead"><?php echo $th; ?></th>
			<?php	
			}?>
			<?php
				$results = get_stocksData();
				
				foreach($results as $res){
					$CompanyName = $res->CompanyName;
					$Symbol = $res->Symbol;
					$Transactions = $res->Transactions;
					$Difference = $res->Difference;
					$TotalTraded = $res->TotalTraded;
					$ClosingPrice = $res->ClosingPrice;
					$MaxPrice = $res->MaxPrice;
					$MinPrice = $res->MinPrice;
					
					if($Difference < 0){
						$class = 'stkLoss';
						$class_td = 'stkLoss_td';
					}else{
						$class = 'stkGain';
						$class_td = 'stkGain_td';
					}
			?>
				<tr class='IndvStk <?php echo $class; ?>'>
					<td class='stkName'><?php echo $CompanyName; ?></td>
					<td class='stkSymbol'><?php echo $Symbol;	?></td>
					<td class='stkTransactions'><?php echo $Transactions;	?></td>
					<td class='stkDifference <?php echo $class_td; ?>'><?php echo $Difference;	?></td>
					<td class='stkTotalTraded'><?php echo $TotalTraded;	?></td>
					<td class='stkClosingPrice'><?php echo $ClosingPrice; ?></td>
					<td class='stkMaxPrice'><?php echo $MaxPrice; ?></td>
					<td class='stkMinPrice'><?php echo $MinPrice; ?></td>	
				</tr>
			<?php
			}?>
		</table>
		
	</div>
</div>
<?php

function getDataforMarquee(){
	global $wpdb;
	$sqlGetMarqueeData = "SELECT 
			NS.CompanyName,NSI.CompanySymbol,
			NS.closingPrice,
			NS.tradedShares, NS.difference 
		FROM wp_nepse_stocks NS

		LEFT JOIN wp_nepse_stocks_info NSI
			ON NS.CompanyName = NSI.CompanyName";
	$Companies = $wpdb->get_results($sqlGetMarqueeData);
	$stocksMarquee = "";
	foreach($Companies as $Company){
		if($Company->CompanySymbol != NULL){
			if($Company->difference < 0){
				$stocksMarquee .= "<span class='stkSymbol' style='color:red'>".$Company->CompanySymbol ."</span>";
				$stocksMarquee .= "<span class='stkPrice' style='color:red'>(".$Company->closingPrice .")</span>";
				$stocksMarquee .= "<span class='stktradedShares' style='color:red'>".$Company->tradedShares ."</span>";
				$stocksMarquee .= '<span class="stkDifferenceGreen"><i  style="color:red">'.$Company->difference .'</i></span>';
			}else{
				$stocksMarquee .= "<span class='stkSymbol' style='color:green'>".$Company->CompanySymbol ."</span>";
				$stocksMarquee .= "<span class='stkPrice' style='color:green'>(".$Company->closingPrice .")</span>";
				$stocksMarquee .= "<span class='stktradedShares' style='color:green'>".$Company->tradedShares ."</span>";
				$stocksMarquee .= '<span class="stkDifferenceRed"><i  style="color:green">'.$Company->difference .'</i></span>';
			}
			$stocksMarquee .= "|";
		}
	}
	return $stocksMarquee;
	exit;
}

function get_stocksData(){
	global $wpdb;
	$sql = "SELECT NS.CompanyName AS 'CompanyName', 
						NSI.CompanySymbol AS 'Symbol', 
						NS.`transactions` AS 'Transactions',
						NS.`difference` AS 'Difference', 
						
						NS.`tradedShares`AS 'TotalTraded', 
						NS.`closingPrice` AS 'ClosingPrice',
						NS.`maxPrice` AS 'MaxPrice', 
						NS.`minPrice` AS 'MinPrice'

				FROM `wp_nepse_stocks` NS
				LEFT JOIN wp_nepse_stocks_info NSI
					ON NS.CompanyName = NSI.CompanyName
					
				WHERE 1";
	$results = $wpdb->get_results($sql);
	return ($results );
	
}

function get_tableHeaders_stocksData(){
	$tableHeaders = array(	'Company Name', 
						'Symbol', 
						'Transactions', 
						'Difference', 
						'Total traded', 
						'Closing price', 
						'Max. Price', 
						'Min. price'
					);
	return $tableHeaders;
	
}



 exit;

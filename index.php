<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AAVE</title>
	<link href="style.css" rel="stylesheet">
	<link rel="icon" href="img/favicon.png" type="image/x-icon"> 
</head>
<body>
<div id="header" class="header">
	<div><img src="logo.png" height="150px" width="150px" /></div>
</div>
<h2 style="text-align:center;">Report</h2>
<hr>
<div class="main">
<div class="data">
<?php
// Get total value and display
function getTvl(){
	
	$api = 'http://aave-api-v2.aave.com';
	$qTotalValue = '/data/tvl';
	$data = json_decode(file_get_contents($api.$qTotalValue));

	$valueUSD = $data->totalTvl->tvlInUsd;
	$price = $valueUSD;
	$new_USD_price = number_format($price);

	$valueETH = $data->totalTvl->tvlInEth;
	$price = $valueETH;
	$new_ETH_price = number_format($price);

	echo('<h3>Total value in USD</h3><h5> $'.$new_USD_price.'</h5>');
	echo('');
	echo('<h3>Total value in Ethereum</h3><h5> '.$new_ETH_price.'</h5>');
	
}

// Build api query, get liquidity and display 
function getLiquidity(){

	$api = 'https://aave-api-v2.aave.com';
	$qLiquidity = '/data/liquidity/v2';
	$poolId = 'poolId=0xb53c1a33016b2dc2ff3653530bff1848a515c8c5';
	$date = 'date=01-01-2022';

	$query = $api.$qLiquidity.'?'.$poolId.'&'.$date;

	$data = json_decode(file_get_contents($query));

	$holdValues = array();

	foreach($data as $d){

		$tq = number_format($d->totalLiquidity);
		$aq = number_format($d->availableLiquidity);
		$holdValues[] = '<li><span><b>Symbol</b>: '.$d->symbol.'</span><span><b>Liquidity</b>: '.$tq.'</span><span><b>Available Liquidity</b>: '.$aq.'</span></li>';
	 
	}

	return $holdValues;
}

$symbolValues = getLiquidity();
$totalValues = getTvl();
// Begin data wrapper 
echo('</div></div><div style="padding:2em;text-align:center"><h3>Supported Crypto</h3></div>');
echo('<div class="data-2-column">');
echo('<div class="flex-item"><ul>');

$cValues = count($symbolValues);

for($i=0;$i < $cValues;$i++){
	
	echo($symbolValues[$i]);

	// split results into 2 sections 
	if($i == round($cValues/2)){
	echo('</ul></div><div class="flex-item"><ul>');
	}
}
echo('</ul></div>');
// End data wrapper
?>
</div>
<div id="footer"><p> &copy; SeanF </p></div>
</body>
</html>
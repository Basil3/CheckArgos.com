<html>
<head>

<style type="text/css">
#clearance
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
border-collapse:collapse;
empty-cells: hide;
}
#clearance td, #clearance th 
{
font-size:1em;
border:1px solid #2CBED8;
padding:3px 7px 2px 7px;
}
#clearance th 
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#09B2D1;
color:#ffffff;
}
#clearance tr.alt td 
{
color:#000000;
background-color:#EAF2D3;
}
</style>

<script type="text/javascript">

//Using a method for handling multiple XMLHTTPREquests as found
//here: http://drakware.com/?e=3

var xmlreqs = new Array();

function CXMLReq(freed)
{
	this.freed = freed;
	this.xmlhttp = false;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		this.xmlhttp=new XMLHttpRequest();
	}
	else
	{
		this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
}

function updateStock(productId, storeId, rowCount)
{
	var pos = -1;
	for (var i=0; i<xmlreqs.length; i++) 
	{
		if (xmlreqs[i].freed == 1) 
		{ 
		pos = i; break; 
		}
	}
	if (pos == -1) 
	{ 
		pos = xmlreqs.length; xmlreqs[pos] = new CXMLReq(1); 
	}
	if (xmlreqs[pos].xmlhttp) 
	{
		xmlreqs[pos].freed = 0;
		xmlreqs[pos].xmlhttp.open("GET",'StockCheckBackground.php?NI=false&checkProduct=true&productId='+productId+'&storeId='+storeId,true);
		xmlreqs[pos].xmlhttp.onreadystatechange = function()
		{
			if (typeof(xmlhttpChange) != 'undefined') 
			{ 
				xmlhttpChange(pos, storeId, productId, rowCount); 
			}
		}
		
		xmlreqs[pos].xmlhttp.send();
	}
}
  
function xmlhttpChange(pos, storeId, productId, rowCount) 
{
	if (typeof(xmlreqs[pos]) != 'undefined' && xmlreqs[pos].freed == 0 && xmlreqs[pos].xmlhttp.readyState == 4) 
	{
		if (xmlreqs[pos].xmlhttp.status == 200 || xmlreqs[pos].xmlhttp.status == 304) 
		{
			var elementId = "product";
			var span = "span";
			var tableId = "clearance";
			var td = "td";
			
			if (xmlreqs[pos].xmlhttp.responseText.search("In stock") >= 0)
			{
				document.getElementById(span.concat(productId)).innerHTML="Yes";
				document.getElementById(td.concat(productId)).style.background= '#A7C942';
			}
			else if (xmlreqs[pos].xmlhttp.responseText.search("ordered") >= 0)
			{
				document.getElementById(span.concat(productId)).innerHTML="Order";
				document.getElementById(td.concat(productId)).style.background= '#FBBA00';
			}
			else if (xmlreqs[pos].xmlhttp.responseText.search("Unkown") >= 0)
			{
				document.getElementById(span.concat(productId)).innerHTML="?";
				document.getElementById(td.concat(productId)).style.background= '#E42528';
			}
			else
			{				
				var table = document.getElementById(tableId);
				var row = document.getElementById(elementId.concat(productId));
				table.deleteRow(row.rowIndex);           
			}
			
		} 

		xmlreqs[pos].freed = 1;
	}
}
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25647037-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script src="js/sorttable.js"></script>

</head>
<body>


<?php

	$stores = array(
					"Arklow" => 4101,
					"Ashbourne+Retail+Park" => 943,
					"Athlone" => 262,
					"Blanchardstown+Shopping+Centre" => 398,
					"Blanchardstown+West+End" => 669,
					"Carlow" => 4130,
					"Castlebar" => 807,
					"Cavan" => 814,
					"Clonmel" => 4214,
					"Cork+Mahon" => 4113,
					"Cork+Queens+Old+Castle" => 45,
					"Cork+Retail+Park" => 801,
					"Drogheda" => 875,
					"Dun+Laoghaire" => 200,
					"Dundalk+Retail+Park" => 931,
					"Dundrum" => 817,
					"Galway" => 547,
					"Ilac+Centre+(Dublin)" => 394,
					"Jervis+Street+(Dublin)" => 397,
					"Kilkenny" => 201,
					"Killarney" => 899,
					"Letterkenny" => 793,
					"Liffey+Valley" => 687,
					"Limerick+Childers+Road" => 915,
					"Limerick+Cruises+Street" => 393,
					"Limerick+The+Crescent" => 583,
					"Longford" => 880,
					"Monaghan" => 945,
					"Naas" => 4218,
					"Navan" => 832,
					"Nutgrove" => 392,
					"Omni+Park+(Dublin)" => 4150,
					"Portlaoise" => 4125,
					"Sligo" => 4146,
					"St.+Stephens+Green+(Dublin)" => 584,
					"Swords" => 581,
					"Tallaght" => 395,
					"Tralee" => 11,
					"Tullamore" => 879,
					"Waterford" => 396,
					"Wexford" => 826
					);

	$storeList = array(
					"Arklow" ,
					"Ashbourne+Retail+Park" ,
					"Athlone" ,
					"Blanchardstown+Shopping+Centre" ,
					"Blanchardstown+West+End" ,
					"Carlow" ,
					"Castlebar" ,
					"Cavan" ,
					"Clonmel" ,
					"Cork+Mahon" ,
					"Cork+Queens+Old+Castle" ,
					"Cork+Retail+Park" ,
					"Drogheda" ,
					"Dun+Laoghaire" ,
					"Dundalk+Retail+Park" ,
					"Dundrum" ,
					"Galway" ,
					"Ilac+Centre+(Dublin)" ,
					"Jervis+Street+(Dublin)" ,
					"Kilkenny" ,
					"Killarney" ,
					"Letterkenny" ,
					"Liffey+Valley" ,
					"Limerick+Childers+Road" ,
					"Limerick+Cruises+Street" ,
					"Limerick+The+Crescent" ,
					"Longford" ,
					"Monaghan" ,
					"Naas" ,
					"Navan" ,
					"Nutgrove" ,
					"Omni+Park+(Dublin)" ,
					"Portlaoise" ,
					"Sligo" ,
					"St.+Stephens+Green+(Dublin)" ,
					"Swords" ,
					"Tallaght" ,
					"Tralee" ,
					"Tullamore" ,
					"Waterford" ,
					"Wexford"
					);
					
	$sectionList = array(
					"All+Sections",
					"Kitchen+and+laundry",
					"Home+and+furniture",
					"Garden+and+DIY",
					"Sports+and+leisure",
					"Health+and+personal+care",
					"Home+entertainment+and+sat+nav",
					"Video+games",
					"Photography",
					"Office%2C+PCs+and+phones",
					"Toys+and+games",
					"Nursery",
					"Jewellery+and+watches",
					"Gifts"
					);
					
	$sectionNumber = array(
					"Kitchen+and+laundry" => "14418476",
					"Home+and+furniture" => "14417894",
					"Garden+and+DIY" => "14418702",
					"Sports+and+leisure" => "14419152",
					"Health+and+personal+care" => "14418350",
					"Home+entertainment+and+sat+nav" => "14419512",
					"Video+games" => "14419738",
					"Photography" => "14419436",
					"Office%2C+PCs+and+phones" => "14418968",
					"Toys+and+games" => "14417629",
					"Nursery" => "14417537",
					"Jewellery+and+watches" => "14416987",
					"Gifts" => "14417351"
					);
					
	$clearanceNumber = array(
					"Kitchen+and+laundry" => "14520894",
					"Home+and+furniture" => "14520317",
					"Garden+and+DIY" => "14519703",
					"Sports+and+leisure" => "14520980",
					"Health+and+personal+care" => "14520139",
					"Home+entertainment+and+sat+nav" => "14520847",
					"Video+games" => "14521085",
					"Photography" => "14520956",
					"Office%2C+PCs+and+phones" => "14520934",
					"Toys+and+games" => "14521005",
					"Nursery" => "14520914",
					"Jewellery+and+watches" => "14520873",
					"Gifts" => "14519943"
					);
					
					
					
					
					
$storeName = $_GET["storeName"];
//Check is it in the array
//$storeName = validateProductId($storeName);

//######################
//Get rid of this!
//#######################
$productsPerPage = 80;
$searchPreference = "Price%3A+Low+-+High";


//Get Min Max price

$minPrice = $_GET["minPrice"];
//$minPrice = validatePrice($minPrice);


$maxPrice = $_GET["maxPrice"];
//$maxPrice = validatePrice($maxPrice);

$sectionSelected = $_GET["section"];
//$sectionSelected = validatePrice($sectionSelected);

$infoFileName = "clearance.csv";
require_once('ListOfProductsDisplayFunctions.php');
include_once('header.php');


echo '<font face="Arial" size="6">Clearance Checker:</font>';
echo "<br />";
echo 'Select a store and a price range to view a list of each store\'s clearance stock.';

echo "<br />";
echo "<br />";
echo '<form name="input" action="'.$_SERVER['PHP_SELF'].'" method="get">
			<table id="inputs" width="800">
				<tr>
					<td> Select Store: </td>
					<td><select name="storeName">';
			
foreach ($storeList as $shop)
{
	if ($shop == $storeName)
		echo '					<option selected="true" value="'. $shop.'">'. str_replace("+", " ", $shop).'</option>';
	else
		echo '					<option value="'. $shop.'">'. str_replace("+", " ", $shop).'</option>';
}

	echo '			</td>
					<td> Min Price: </td>
					<td><input value="'.$minPrice.'" size="7" type="text" name="minPrice" /></td>
					<td> Max Price: </td>
					<td><input value="'.$maxPrice.'" size="7" type="text" name="maxPrice" /></td>
				</tr>
				<tr>
					<td> Section: </td>
					<td><select name="section">';
			
foreach ($sectionList as $section)
{
	if ($section == $sectionSelected)
		echo '					<option selected="true" value="'. $section.'">'. str_replace("%2C",",",str_replace("+", " ", $section)).'</option>';
	else
		echo '					<option value="'. $section.'">'. str_replace("%2C",",",str_replace("+", " ", $section)).'</option>';
}

	echo '			</td>
				</tr>
			</table>
			<br />
			<input type="submit" value="Submit" />
		</form>';

	echo "<br /><br />";
$error="";
if ($storeName == "" || $storeName == "invalid")
{
	$error = " select a store";
}
if ($minPrice == "" || $minPrice == "invalid")
{
	if ($error != "")
		$error = $error.",";
	$error = $error." set a minimum price";
}
if ($maxPrice == "" || $maxPrice == "invalid")
{
	if ($error != "")
		$error = $error.",";
	$error = $error." set a maximum price";
}

if ($error != "")
{
	echo "Please".$error;
	
}		
else
{	

	$infoFile = fopen($infoFileName,"a+");
	fputcsv ($infoFile , array(time(), $storeName, $minPrice, $maxPrice, $sectionSelected), ',');
	fclose ($infoFile);
	
	if ($sectionSelected == "All+Sections")
	{
		
		$totalNumProducts = 0;
		$countProduct = 1;
		do
		{
			$clearancePage = file_get_contents("http://www.argos.ie/static/Browse/ID72/17503661/c_1/2|category_root|Limited+stock+clearance|17503661/p/".$countProduct."/pp/".$productsPerPage."/r_001/1|Store|".$storeName."|1/r_003/3|Price|".$minPrice."+%3C%3D++%3C%3D+".$maxPrice."|2/s/".$searchPreference.".htm");
			$items = explode ("<li class=\"producttitle\">", $clearancePage);
			
			if ($totalNumProducts == 0 )
			{
				preg_match('/of\s\<span\>([0-9]*)<\/span\>/', $items[0], $match);
				$totalNumProducts = $match[1];
				$products = array_slice($items, 1);
			}
			else
			{
				array_splice($products, count($products), 0, array_slice($items, 1));
			}
			$countProduct = $countProduct + $productsPerPage;
		}while ($countProduct <=  $totalNumProducts);
	}
	else
	{
		
		$totalNumProducts = 0;
		$countProduct = 1;
		do
		{
			$clearancePage = file_get_contents("http://www.argos.ie/static/Browse/c_1/1|category_root|".$sectionSelected."|".$sectionNumber[$sectionSelected]."/c_2/2|".$sectionNumber[$sectionSelected]."|Clearance+".$sectionSelected."|".$clearanceNumber[$sectionSelected]."/p/".$countProduct."/pp/".$productsPerPage."/r_001/4|Price|".$minPrice."+%3C%3D++%3C%3D+".$maxPrice."|2/s/".$searchPreference.".htm");
			$items = explode ("<li class=\"producttitle\">", $clearancePage);
			
			if ($totalNumProducts == 0 )
			{
				preg_match('/of\s\<span\>([0-9]*)<\/span\>/', $items[0], $match);
				$totalNumProducts = $match[1];
				$products = array_slice($items, 1);
			}
			else
			{
				array_splice($products, count($products), 0, array_slice($items, 1));
			}
			
			$countProduct += $productsPerPage;
		}while ($countProduct <=  $totalNumProducts);
	}
		
	$storeId = $stores[$storeName];

	drawListOfStockTable($products, $storeId);
}
	
require_once("footer.php");	

?>
</body>
</html>

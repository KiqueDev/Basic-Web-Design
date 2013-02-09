<?php   
	
	/*
		11/29/2011. David Book david@buzztouch.com
		This script outputs HTML formatted to look like a native iOS UITableView
	*/
	
	//Adjust the websiteBaseURL as needed.
	$websiteBaseURL = "http://www.montesino.at";
	
	if($websiteBaseURL == ""){
		echo "Website Base URL required";
		exit();
	}
	
	//this function get the URL for the first image found in the HTML description
   	function fnGetFirstImage($html){
		if(stripos($html, '<img') !== false){
            $imgsrc_regex = '#<\s*img [^\>]*src\s*=\s*(["\'])(.*?)\1#im';
            preg_match($imgsrc_regex, $html, $matches);
            unset($imgsrc_regex);
            unset($html);
            if (is_array($matches) && !empty($matches)) {
                return $matches[2];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
	
	//this function cleans up the HTML description for display..
   	function fnCleanUpDescription($html){
		$ret = $html;
		$ret = strip_tags($ret);
		return $ret;
	}
	
	//this function pulls the content "in between" $startDiv and $endDiv
	function fnGetMainArticle($str, $start, $end){
		$str_low = strtolower($str);
		$pos_start = strpos($str_low, $start);
		$pos_end = strpos($str_low, $end, ($pos_start + strlen($start)));
		if ( ($pos_start !== false) && ($pos_end !== false)){
			$pos1 = $pos_start + strlen($start);
			$pos2 = $pos_end - $pos1;
		}
		
		//remove all hyperlinks...
		$ret = substr($str, $pos1, $pos2);
		$ret = preg_replace('/<a href="([^<]*)">([^<]*)<\/a>/', '', $ret);

		//$ret = preg_replace('/<a href[^<>]+>|<\/a>/s', '', $ret);
		
		return $ret;
	}	
	
	
	//storyId arrives in querystring when we tap a selected story...
	$storyURL = "";
	if(isset($_GET["storyURL"])){
	
		//get everything after storyURL=, we need all the querystring parameters for the story...
  		if($_SERVER["QUERY_STRING"]){
			$storyURL = str_replace("storyURL=", "", $_SERVER["QUERY_STRING"]);
		}
	
	
	}
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html>
	<head>
		<title>Montesino</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=0.35; maximum-scale=1.6; user-scalable=0;"/>
		<meta http-equiv="imagetoolbar" content="no" />
		<meta http-equiv="imagetoolbar" content="false" />
	
    	<style type="text/css">
			body{
				font-family:verdana;
				font-size:8pt;padding:0px;
				margin:0px;
			}
			table{
				margin:0px;
			}
			div{
				padding:0px;
				margin:0px;
			}
			.rounded{
				-moz-border-radius-topright: 6px;
				border-top-right-radius: 6px;		
				-moz-border-radius-topleft: 6px;
				border-top-left-radius: 6px;		
				-moz-border-radius-bottomright: 6px;
				border-bottom-right-radius: 6px;		
				-moz-border-radius-bottomleft: 6px;
				border-bottom-left-radius: 6px;		
			}
			.itemOff{
				padding:5px;
				margin:0px;
				border-bottom:1px solid gray;
				background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FFFFFF), color-stop(1, #CCCCCC));
			}
			.itemOn{
				padding:5px;
				margin:0px;
				border-bottom:1px solid gray;
				background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FFFFFF), color-stop(1, #737072));
			}
			td{
				padding:0px;
				vertical-align:top;
			}
			.imageCell{
				width:65px;
				height:65px;
				overflow:hidden;
			}
			.image{
				width:65px;
				height:65px;
				overflow:hidden;
			}
			.title{
				padding-left:5px;
				padding-right:5px;
				white-space:nowrap;
				color:#85031F;
				font-weight:bold;
				font-size:11pt;
				text-shadow: 0px 1px 0px #fff;
			}
			.description{
				padding-left:5px;
				padding-right:5px;
				margin-top:0px;
				height:30px;
				overflow:hidden;
				font-size:9pt;
			}
			.date{
				padding-left:5px;
				padding-right:5px;
				margin-top:0px;
				color:#999999;
				font-size:8pt;
			}
			.article{
				font-size:10pt;
				margin-bottom:25px;
				padding:10px;
			}
			.createdate{
				color:#999999;
			}
		</style>
        
    	<script type="text/javascript">
			function fnSelected(theElId, linkURL){
				document.getElementById(theElId).className = "itemOn";
				var divs = document.getElementsByTagName('div');
				for(var i = 0; i < divs.length; i++){ 
					if(divs[i].id.indexOf("item_", 0) > -1 && divs[i].id != theElId){
						divs[i].className = "itemOff";
					}
				} 	
				
				//navigate to "linkURL"
				var currentURL = document.location.href;
				document.location.href = currentURL + "?storyURL=" + linkURL;
				
			}
		</script>
    
    </head>
	<body>
 
		<?php 
            
        //if we don't have a storyURL, get the list...
		if($storyURL == ""){
		
			//the URL to the RSS feed.
			$rssURL = "http://www.montesino.at/index.php?format=feed&type=rss&lang=de";
	
			//use built in simplexml methods to load RSS data
			$xml = simplexml_load_file($rssURL);
			if($xml){
				$count = 0;
				foreach ($xml->channel->item as $item) {
					$count++;
		
					//get the src for a possible image in the description. Description is HTML
					$imgSrc = fnGetFirstImage($item->description);
					$title = $item->title;
					$description = $item->description;
					$description = fnCleanUpDescription($description);
					$description = substr($description, 0, 500);
					
					$pubDate = $item->pubDate;
					$link = $item->link;
		
					echo "\n\t<div id='item_" . $count . "' class='itemOff' onClick=\"fnSelected('item_" . $count . "', '" . $link . "');return false;\">";
						echo "\n<table cellspacing='0' cellpadding='0'>";
							echo "<tr>";
								echo "\n<td class='imageCell'><img class='image rounded' src='" . $imgSrc . "'/></td>";
								echo "\n<td>";
									echo "\n<div class='title'>" . $item->title . "</div>";
									echo "\n<div class='description'>" . $description . "</div>";
									echo "\n<div class='date'>" . $pubDate . "</div>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "\n\t</div>";
					
				}//end for
			}//end if xml was loaded...
		
		}//storyURL == ""
		
		//if we do have a storyURL, get the storyContents....
		if($storyURL != ""){
		
			//download all the HTML for the story using CURL..
			$ch = curl_init($storyURL);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			//donwload all the HTML content from the storyURL
			$curlResult = curl_exec($ch);
			curl_close($ch);	

			//format the HTML using our cool function. Function returns the HTML "in-between" the HTML snippets..
			$printHTML = fnGetMainArticle($curlResult, "<div class=\"main-article\">", "<div class=\"clr\"></div>");
			
			//replace /image tags with full URL...
			$printHTML = str_replace("/images/", $websiteBaseURL . "/images/", $printHTML);
			
			//replace all "/index.php" tags with full URL
			$printHTML = str_replace("/index.php", $websiteBaseURL . "/index.php", $printHTML);
			
			//print output...			
			echo "<div class='article'>";
				echo $printHTML;		
			echo "</div>";
			
		}//storyURL != ""
		
							
							
                        
            
        ?>

	</body>
</html>



















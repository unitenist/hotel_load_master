<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Auto Loading Records on Scroll</title>

<style>
.wrapper{width: 500px;margin: 0 auto;font-family: Georgia, "Times New Roman", Times, serif;}
.wrapper > ul#results li{margin-bottom: 1px;background: #f9f9f9;padding: 20px;list-style: none;}
.loading-info{text-align:center;}
</style>
</head>

<body>

<div class="wrapper">
    <ul id="results"><!-- results appear here --></ul>
    <div class="loading-info"><img src="ajax-loader.gif" /></div>
</div>

<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
var track_page = 1; //track user scroll as page number, right now page number is 1
var loading  = false; //prevents multiple loads

load_contents(track_page); //initial content load

$(window).scroll(function() { //detect page scroll
	if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled to bottom of the page
		track_page++; //page number increment
		load_contents(track_page); //load content	
	}
});		
//Ajax load function
function load_contents(track_page){
    if(loading == false){
		loading = true;  //set loading flag on
		$('.loading-info').show(); //show loading animation 
		$.post( 'fetch_pages.php', {'page': track_page}, function(data){
			loading = false; //set loading flag off once the content is loaded
			if(data.trim().length == 0){
				//notify user if nothing to load
				$('.loading-info').html("No more records!");
				return;
			}
			$('.loading-info').hide(); //hide loading animation once data is received
			$("#results").append(data); //append data into #results element
		
		}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
			alert(thrownError); //alert with HTTP error
		})
	}
}
</script>

</body>
</html>

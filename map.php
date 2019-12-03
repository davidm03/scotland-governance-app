<?php include("includes/header.php");?>

<link rel="stylesheet" href="css/map.css">

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>Constituency Map</li>
    </ul>
    <p>
        Our constituency map below, shows a map of Scotland with all Scottish Parliamentary constituencies marked out and coloured with the current elected representatives political party colour.
        <br><br>
        Areas coloured yellow are held by the Scottish National Party, blue are held by the Conservative and Unionist Party, orange by the Liberal Democrats, red by Labour and grey by an independant MSP. 
    </p>
    <center>
    <div class="mapContainer">
        <div id="tooltip" display="none" style="position: absolute; display: none;"></div>
        <?php echo file_get_contents("images/map.svg")?>
    </div>
    </center>
</article>

<!-- <script>
    var panZoomMap = svgPanZoom('#svg10');

    svgPanZoom('#svg10', {
    viewportSelector: '.svg-pan-zoom_viewport'
    , panEnabled: true
    , controlIconsEnabled: true
    , zoomEnabled: true
    , dblClickZoomEnabled: true
    , preventMouseEventsDefault: true
    , zoomScaleSensitivity: 0.2
    , minZoom: 0.5
    , maxZoom: 10
    , fit: true
    , contain: false
    , center: true
    , refreshRate: 'auto'
    });
</script> -->
<script>
    function showTooltip(evt, text) {
  let tooltip = document.getElementById("tooltip");
  tooltip.innerHTML = text;
  tooltip.style.display = "block";
  tooltip.style.left = evt.pageX + 10 + 'px';
  tooltip.style.top = evt.pageY + 10 + 'px';
}

function hideTooltip() {
  var tooltip = document.getElementById("tooltip");
  tooltip.style.display = "none";
}
</script>



<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>
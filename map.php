<?php include("includes/header.php");?>

<link rel="stylesheet" href="css/map.css">

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>Constituency Map</li>
    </ul>
    <h1>Constituency Map</h1>    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum diam risus, lobortis et sem sit amet, auctor pulvinar sapien. Morbi tincidunt cursus ante sit amet dictum. Donec enim urna, eleifend lobortis mauris ac, sodales maximus lorem. </p>
    <div class="mapContainer">
        <div id="tooltip" display="none" style="position: absolute; display: none;"></div>
        <?php echo file_get_contents("images/map.svg")?>
    </div>
</article>

<script>
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
</script>
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
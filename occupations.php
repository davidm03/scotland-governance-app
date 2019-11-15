<?php include("includes/header.php"); ?>

<article class="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>        
        <li>Occupations</li>
    </ul>
    <h1>Occupations</h1>    
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum diam risus, lobortis et sem sit amet, auctor pulvinar sapien. Morbi tincidunt cursus ante sit amet dictum. Donec enim urna, eleifend lobortis mauris ac, sodales maximus lorem.</p>

    <div class="thinborder" style="padding-bottom: 20px;">
    <form id="occupationSearch" type="post" action="#">
      <label style="padding-left: 30px;">Enter job title:</label> 
      <input type="text" name="jobTitleInput" style="margin: 10px 30px 0 30px;"><br>
      <div style="text-align: center; padding: 10px 0;"><input type="submit" value="Submit"></div>
    </form>
    </div>
</article>

<script>
$(function() {
    $( "#occupationSearch" ).submit(function( event ) {
        var url = "http://api.lmiforall.org.uk/api/v1/soc/search?q=";
        var newUrl = url.append.$("#jobTitleInput");
        console.log(newUrl);
        /*
        |var req = $.ajax({
        url: "http://api.lmiforall.org.uk/api/v1/soc/search?q=",
        dataType: "jsonp"
    });
        req.done(function(data) {
        console.log(data);
        });  */                                                                      
    });    
});
</script>

<?php include("includes/aside.php");?>
<?php include("includes/footer.php");?>
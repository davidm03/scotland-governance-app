<?php 
include("includes/header.php");
$search_input = $_POST['postcodeInput'];
?>

<article class="content" id="content">
    <ul class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li><a href="search.php">Search By Postcode</a></li>        
        <li>Search Results</li>
    </ul>
</article>

<script>
$(document).ready(function() {
        var input = '<?php echo $search_input ?>';

        // if the input string contains a blank space 
        if(input.indexOf(' ')>=0) {
            // encode the URI component to replace the blank space with '%20' 
            input = encodeURIComponent(input.trim())
        }

        var requestURL = "https://api.postcodes.io/scotland/postcodes/" + input;

        console.log(requestURL);

        var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
        });
        req.done(function(data){
            console.log(data.result);
            var constit_code = data.result.codes.scottish_parliamentary_constituency;
            console.log(constit_code);
            getConstituency(constit_code);
        });
        
        function getConstituency(constit_code){
            var requestURL = "https://data.parliament.scot/api/constituencies";

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(data){
                $.each(data, function (index, constituency){
                    //console.log(index, constituency);
                    if(constituency.ConstituencyCode == constit_code && constituency.ValidUntilDate == null){
                        console.log(constituency);
                        $('<h1/>',{text: constituency.Name + ' - Area Breakdown'}).appendTo('#content');
                        getPersonID(constituency.ID);
                    }
                });
            });
        }

        function getPersonID(constit_id){
            var requestURL = "https://data.parliament.scot/api/MemberElectionConstituencyStatuses";

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(data){
                $.each(data, function(index, constituency){
                    if(constituency.ConstituencyID == constit_id && constituency.ValidUntilDate == null){
                        console.log(constituency);
                        getMSP(constituency.PersonID); 
                    }
                });
                
            });
        }

        function getMSP(personID){
            var requestURL = "https://data.parliament.scot/api/members?ID=" + personID;

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(msp){
                console.log(msp);                
                $('<p/>',{text: 'MSP: ' + formatMSPName(msp.ParliamentaryName)}).appendTo('#content');
                $('<p/>',{text: 'MSP: ' + formatMSPName(msp.ParliamentaryName)}).appendTo('#content');
                $('<p/>',{text: 'MSP: ' + formatMSPName(msp.ParliamentaryName)}).appendTo('#content');

            });
        }

        function formatMSPName(name){
            name = String(name);
            var index = name.indexOf(", ");
            var secondName = name.substr(0, index);
            var firstName = name.substr(index + 1);

            return firstName + " " + secondName;
        }

});
</script>


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>
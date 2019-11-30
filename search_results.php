<?php 
include("includes/header.php");
$search_input = $_POST['postcodeInput'];
?>

<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.pre-load {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/loading.gif) center no-repeat #fff;
}
</style>

<div class="pre-load"></div>

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
        var ward;
        var mspID;

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
        
        function getConstituency(constit_code) {
            var requestURL = "https://data.parliament.scot/api/constituencies";

            var req = $.ajax({
                url: requestURL,
                dataType: "json"
            });
            req.done(function (data) {
                $.each(data, function (index, constituency) {
                    //console.log(index, constituency);
                    if (constituency.ConstituencyCode == constit_code && constituency.ValidUntilDate == null) {
                        console.log(constituency);
                        $('<h1/>', { text: constituency.Name + ' - Area Breakdown' }).appendTo('#content');
                        ward = constituency.Name;
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
                mspID = msp.PersonID;                
                $('<p/>',{text: 'MSP: ' + formatMSPName(msp.ParliamentaryName)}).appendTo('#content');
                getMemberParty(msp.PersonID);
            });
        }

        function formatMSPName(name){
            name = String(name);
            var index = name.indexOf(", ");
            var secondName = name.substr(0, index);
            var firstName = name.substr(index + 1);

            return firstName + " " + secondName;
        }

        function getMemberParty(personID){
            var requestURL = "https://data.parliament.scot/api/memberparties";

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(memberParty){
                $.each(memberParty, function(index, member){
                    if(member.PersonID == personID && member.ValidUntilDate == null){
                        console.log(member);
                        getParty(member.PartyID);
                    }
                });

            });
        }

        function getParty(partyID){
            var requestURL = "https://data.parliament.scot/api/parties?ID=" + partyID;

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(party){
                $('<p/>',{text: 'MSP Party: ' + party.ActualName}).appendTo('#content');
                getAddress(mspID);
            });
        }

        function getAddress(personID){
            var requestURL = "https://data.parliament.scot/api/addresses";

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(data){
                $.each(data, function(index, address){
                    if(address.PersonID == personID && address.AddressTypeID!=1){
                        console.log(address);
                        $('<p/>',{text: 'MSP Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode}).appendTo('#content');
                        $('<h3/>',{text: ward + ' - Area Statistics'}).appendTo('#content');
                        drawCharts();
                    }
                });             
                
            });
        }

        function drawCharts(){
            $('<div/>',{id: 'chartContainer', class: 'wrapper'}).appendTo('#content');
            $('<div/>',{id: 'one'}).appendTo('#chartContainer');
            $('<div/>',{id: 'two'}).appendTo('#chartContainer');

            var requestURL = "http://api.lmiforall.org.uk/api/v1/census/jobs_breakdown?area=" + input;

            var req = $.ajax({
            url: requestURL,
            dataType: "json"
            });
            req.done(function(data){
                console.log(data.jobsBreakdown);
                var breakdownData = [];
                for(var element in data.jobsBreakdown) {
                    breakdownData.push({y: data.jobsBreakdown[element].percentage, label: data.jobsBreakdown[element].description});
                }

                var chart = new CanvasJS.Chart("one", {
                title: {
                    text: "Job Breakdown", fontFamily: 'Roboto'
                },
                subtitles: [{
                    text: ward,
                    fontSize: 16,
                    fontFamily: 'Roboto'
                }],
                data: [{
                    type: "pie",
                    indexLabelFontSize: 15,
                    radius: 300,
                    indexLabel: "{label} - {y}",
                    yValueFormatString: "###0.0\"%\"",
                    dataPoints: breakdownData
                }]
            });
            chart.render();
            $(".pre-load").fadeOut("slow");                
            });            
        }

});
</script>


<?php 
include("includes/aside.php");
include("includes/footer.php");
?>
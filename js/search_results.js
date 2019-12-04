//JS FILE CONTAINING FUNCTIONS USED ON SEARCH_RESULTS.PHP

//FUNCTION TO INITIATE POSTCODE LOOKUP
function lookupPostcode(searchInput, mapInput) {

    //if search input is not empty
    if (searchInput != "") {
        //if user input is not a valid postcode
        if (isValidPostcode(searchInput) == false) {
            //display no results found and throw javascript error
            noResultsFound();
            throw new Error('This is not an error. This is just to abort javascript');
        }

        // search input is not null and is not blank
        if (searchInput != null && searchInput.indexOf(' ') >= 0) {
            // encode the URI component to replace the blank space with '%20' 
            searchInput = encodeURIComponent(searchInput.trim())
        }

        //create the API request URL
        var requestURL = "https://api.postcodes.io/scotland/postcodes/" + searchInput;

        //ajax call to perform API request
        var req = $.ajax({
            url: requestURL,
            dataType: "json"
        });
        //when ajax call is complete
        req.done(function (data) {
            //if returned data is status 200 (RESULTS RETURNED)
            if (data.status == 200) {
                //get constituency code
                var constit_code = data.result.codes.scottish_parliamentary_constituency;
                //call get constituency function
                getConstituency(constit_code);
            }
            else {
                //display no results found message
                noResultsFound();
            }
        });
    }
    //if search input is empty - then user input is from map.php
    else {
        //no need to lookup postcode - call get constituency function and pass in mapInput (constituency code)
        getConstituency(mapInput);
    }
}


//GET CONSTITUENCY FROM API
function getConstituency(constit_code) {
    //construct request URL
    var requestURL = "https://data.parliament.scot/api/constituencies";

    //perform ajax request
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        //loop through returned data
        $.each(data, function (index, constituency) {
            //if constituency code matches and constituency is valid
            if (constituency.ConstituencyCode == constit_code && constituency.ValidUntilDate == null) {
                //draw constituency name on screen
                $('<h1/>', { text: constituency.Name + ' - Area Breakdown' }).appendTo('#content');
                //set ward variable
                ward = constituency.Name;
                //call get person ID function
                getPersonID(constituency.ID);
            }
        });
    });
}

//GET MSP PERSON ID FOR SELECTED CONSTITUENCY
function getPersonID(constit_id) {
    //construct request URL
    var requestURL = "https://data.parliament.scot/api/MemberElectionConstituencyStatuses";

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        //loop through returned data
        $.each(data, function (index, constituency) {
            //if constituency ID matches and constituency is valid
            if (constituency.ConstituencyID == constit_id && constituency.ValidUntilDate == null) {
                //call get MSP function
                getMSP(constituency.PersonID);
            }
        });

    });
}

//GET MSP DETAILS USING PERSON ID
function getMSP(personID) {
    //construct request URL
    var requestURL = "https://data.parliament.scot/api/members?ID=" + personID;

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (msp) {
        //set mspID variable
        mspID = msp.PersonID;
        //draw msp information to screen
        $('<h3/>', { id: 'mspHeading', text: 'MSP Details' }).appendTo('#content');
        $('<div/>', { id: 'mspContainer', class: 'wrapper' }).appendTo('#content');
        $('<div/>', { id: 'one' }).appendTo('#mspContainer');
        $('<div/>', { id: 'two' }).appendTo('#mspContainer');
        $('<p/>', { text: 'Name: ' + formatMSPName(msp.ParliamentaryName) }).appendTo('#one');
        $('<img/>', { src: msp.PhotoURL, style: 'width: 500px; height: 300px;', id: 'mspPhoto', title: 'MSP' + formatMSPName(msp.ParliamentaryName) + ' Photo' }).appendTo('#two');
        //call get member party function
        getMemberParty(msp.PersonID);
    });
}

//FORMAT MSP NAME
function formatMSPName(name) {
    //parse input variable to string
    name = String(name);
    //find the comma and space within name
    var index = name.indexOf(", ");
    //extract the msp surname
    var secondName = name.substr(0, index);
    //extract msp first name
    var firstName = name.substr(index + 1);

    //return formatted first and second name
    return firstName + " " + secondName;
}

//GET THE PARTY ID OF MSP
function getMemberParty(personID) {
    //construct request URL
    var requestURL = "https://data.parliament.scot/api/memberparties";

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (memberParty) {
        //loop through returned data
        $.each(memberParty, function (index, member) {
            //if person ID matches and member is valid
            if (member.PersonID == personID && member.ValidUntilDate == null) {
                //call get party function
                getParty(member.PartyID);
            }
        });
    });
}

//GET THE ASSOCIATED POLITICAL PARTY
function getParty(partyID) {
    //construct request URL
    var requestURL = "https://data.parliament.scot/api/parties?ID=" + partyID;

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (party) {
        //draw member political party to screen
        $('<p/>', { text: 'Political Party: ' + party.ActualName }).appendTo('#one');
        //call get address function
        getAddress(mspID);
    });
}

//GET MSP ADDRESS
function getAddress(personID) {
    //construct request URL
    var requestURL = "https://data.parliament.scot/api/addresses";

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        //initialise address found as false
        var addressFound = false;
        //loop through all addresses
        $.each(data, function (index, address) {
            //if MSP person ID matches, address has not already been found and address is type 2 (personal address ID)
            if (address.PersonID == personID && addressFound == false && address.AddressTypeID == 2) {
                //draw address info to screen
                $('<p/>', { text: 'Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode }).appendTo('#one');
                $('<h3/>', { id: 'areaStatsHeading', text: 'Occupations Statistics' }).appendTo('#content');
                //set address found to true and call draw charts function
                addressFound = true;
                drawCharts(address.PostCode);
            }
        });

        //if address has not been found after the first iteration of address
        //then the MSP does not have a personal address - we can use the Scottish Parliament office address
        if (addressFound == false) {
            //loop through addresses
            $.each(data, function (index, address) {
                //if MSP person ID matches, address has not already been found and address is type 1 (Scottish Parliament office address)
                if (address.PersonID == personID && addressFound == false && address.AddressTypeID == 1) {
                    $('<p/>', { text: 'MSP Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode }).appendTo('#one');
                    $('<h3/>', { id: 'areaStatsHeading', text: 'Occupations Statistics' }).appendTo('#content');
                    addressFound = true;
                    drawCharts(address.PostCode);
                }
            });
        }

    });
}

//DRAW JOBS BREAKDOWN CHART ONTO SCREEN
//AVAILABLE FROM - https://canvasjs.com/html5-javascript-pie-chart/
function drawCharts(postcode) {
    //draw chart container div to screen
    $('<div/>', { id: 'chartContainer', style: 'padding-bottom: 500px;' }).appendTo('#content');

    //construct request URL
    var requestURL = "http://api.lmiforall.org.uk/api/v1/census/jobs_breakdown?area=" + postcode;

    //perform ajax call
    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        //initialise empty array to store chart data
        var breakdownData = [];
        //loop through returned data from api request
        for (var element in data.jobsBreakdown) {
            //insert data returned from api into chart array
            breakdownData.push({ y: data.jobsBreakdown[element].percentage, label: data.jobsBreakdown[element].description });
        }

        //construct chart
        var chart = new CanvasJS.Chart("chartContainer", {
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

        //draw additional page information displayed under chart
        $('<center/>', { id: 'btnCenter' }).appendTo('#content');
        $('<input/>', { id: 'btnOccupations', type: 'submit', value: 'Search Occupations', style: 'margin-right: 10px;' }).appendTo('#btnCenter');
        //on btnOccupations click - redirect to occupations.php
        document.getElementById('btnOccupations').onclick = function () {
            location.href = 'occupations.php';
        }
        $('<input/>', { id: 'btnFindVacancies', type: 'submit', value: 'Find Vacancies In ' + ward, style: 'margin-left: 10px;' }).appendTo('#btnCenter');
        //on btnFindVacancies click
        document.getElementById('btnFindVacancies').onclick = function () {
            //create hidden form - to redirect to vacancies.php
            var hiddenForm = document.createElement('form');
            hiddenForm.action = 'vacancies.php';
            hiddenForm.method = 'POST';

            //create hidden input with value = area postcode
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'postcode';
            input.value = postcode;

            //add input to form
            hiddenForm.appendChild(input);

            //add form to document and submit
            document.body.appendChild(hiddenForm);
            hiddenForm.submit();
        }

        //draw additional information to screen to display under chart
        $('<h3/>', { text: 'Schooling Statistics' }).appendTo('#content');
        $('<h4/>', { text: 'Coming Soon', style: 'text-align: center;' }).appendTo('#content');
        $('<h3/>', { text: 'Health Statistics' }).appendTo('#content');
        $('<h4/>', { text: 'Coming Soon', style: 'text-align: center;' }).appendTo('#content');
        $('<h3/>', { text: 'Social Care Statistics' }).appendTo('#content');
        $('<h4/>', { text: 'Coming Soon', style: 'text-align: center;' }).appendTo('#content');

        //once javascript has loaded - fade out loading animation
        $(".pre-load").fadeOut("slow");
    });
}
//END
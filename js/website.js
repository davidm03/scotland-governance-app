//JAVASCRIPT FILE CONTAINING VARIOUS FUNCTIONS USED THROUGHOUT THE WEBSITE

//FUNCTION TO DISPLAY NO RESULTS FOUND MESSAGE
function noResultsFound() {
    $('<h1/>', { text: 'Sorry - No Results Could Be Found' }).appendTo('#content');
    $('<p/>', { id: 'txtError', text: 'You can return home by clicking the link ' }).appendTo('#content');
    $('<a/>', { text: 'here' }).appendTo('#txtError');
    $(".pre-load").fadeOut("slow");
}

//BEGIN FUNCTIONS FOR SEARCH_RESULTS.PHP - GETTING AREA BREAKDOWN INFORMATION
//GET CONSTITUENCY FROM API
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

//GET MSP PERSON ID FOR SELECTED CONSTITUENCY
function getPersonID(constit_id) {
    var requestURL = "https://data.parliament.scot/api/MemberElectionConstituencyStatuses";

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        $.each(data, function (index, constituency) {
            if (constituency.ConstituencyID == constit_id && constituency.ValidUntilDate == null) {
                console.log(constituency);
                getMSP(constituency.PersonID);
            }
        });

    });
}

//GET MSP DETAILS USING PERSON ID
function getMSP(personID) {
    var requestURL = "https://data.parliament.scot/api/members?ID=" + personID;

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (msp) {
        console.log(msp);
        mspID = msp.PersonID;
        $('<h3/>', { id: 'mspHeading', text: 'MSP Details' }).appendTo('#content');
        $('<div/>', { id: 'mspContainer', class: 'wrapper' }).appendTo('#content');
        $('<div/>', { id: 'one' }).appendTo('#mspContainer');
        $('<div/>', { id: 'two' }).appendTo('#mspContainer');
        $('<p/>', { text: 'Name: ' + formatMSPName(msp.ParliamentaryName) }).appendTo('#one');
        $('<img/>', { src: msp.PhotoURL, style: 'width: 500px; height: 300px;', id: 'mspPhoto', title: 'MSP' + formatMSPName(msp.ParliamentaryName) + ' Photo' }).appendTo('#two');
        getMemberParty(msp.PersonID);
    });
}

//FORMAT MSP NAME
function formatMSPName(name) {
    name = String(name);
    var index = name.indexOf(", ");
    var secondName = name.substr(0, index);
    var firstName = name.substr(index + 1);

    return firstName + " " + secondName;
}

//GET THE PARTY ID OF MSP
function getMemberParty(personID) {
    var requestURL = "https://data.parliament.scot/api/memberparties";

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (memberParty) {
        $.each(memberParty, function (index, member) {
            if (member.PersonID == personID && member.ValidUntilDate == null) {
                console.log(member);
                getParty(member.PartyID);
            }
        });
    });
}

//GET THE ASSOCIATED POLITICAL PARTY
function getParty(partyID) {
    var requestURL = "https://data.parliament.scot/api/parties?ID=" + partyID;

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (party) {
        $('<p/>', { text: 'Political Party: ' + party.ActualName }).appendTo('#one');
        getAddress(mspID);
    });
}

//GET MSP ADDRESS
function getAddress(personID) {
    var requestURL = "https://data.parliament.scot/api/addresses";

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
                console.log(address);
                $('<p/>', { text: 'Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode }).appendTo('#one');
                $('<h3/>', { id: 'areaStatsHeading', text: 'Area Statistics' }).appendTo('#content');
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
                    console.log(address);
                    $('<p/>', { text: 'MSP Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode }).appendTo('#one');
                    $('<h3/>', { id: 'areaStatsHeading', text: 'Area Statistics' }).appendTo('#content');
                    addressFound = true;
                    drawCharts(address.PostCode);
                }
            });
        }

    });
}

//DRAW JOBS BREAKDOWN CHART ONTO SCREEN
function drawCharts(postcode) {
    $('<div/>', { id: 'chartContainer', style: 'padding-bottom: 500px;' }).appendTo('#content');
    //$('<div/>', { id: 'one' }).appendTo('#chartContainer');

    var requestURL = "http://api.lmiforall.org.uk/api/v1/census/jobs_breakdown?area=" + postcode;

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        console.log(data.jobsBreakdown);
        var breakdownData = [];
        for (var element in data.jobsBreakdown) {
            breakdownData.push({ y: data.jobsBreakdown[element].percentage, label: data.jobsBreakdown[element].description });
        }

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

        $('<center/>', { id: 'btnCenter' }).appendTo('#content');
        $('<input/>', { id: 'btnOccupations', type: 'submit', value: 'Search Occupations', style: 'margin-right: 10px;' }).appendTo('#btnCenter');
        document.getElementById('btnOccupations').onclick = function () {
            location.href = 'occupations.php';
        }
        $('<input/>', { id: 'btnFindVacancies', type: 'submit', value: 'Find Vacancies In ' + ward, style: 'margin-left: 10px;' }).appendTo('#btnCenter');
        document.getElementById('btnFindVacancies').onclick = function () {
            findVacancies(postcode);
        }
        $(".pre-load").fadeOut("slow");
    });
}

function findVacancies(postcode) {
    var hiddenForm = document.createElement('form');
    hiddenForm.action = 'vacancies.php';
    hiddenForm.method = 'POST';

    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'postcode';
    input.value = postcode;

    hiddenForm.appendChild(input);

    document.body.appendChild(hiddenForm);
    hiddenForm.submit();
}
//END SEARCH_RESULTS.PHP FUNCTIONS

//CHECK IF USER INPUT IS VALID POSTCODE
function isValidPostcode(p) {
    var postcodeRegEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return postcodeRegEx.test(p);
}

//BEGIN FUNCTIONS FOR VACANCIES_RESULTS.PHP
//GET VACANCIES FOR USER SELECTED JOB AND/OR POSTCODE
function getVacancies(postcode, job) {
    // if the input string contains a blank space 
    if (job.indexOf(' ') >= 0) {
        // encode the URI component to replace the blank space with '%20' 
        job = encodeURIComponent(job.trim())
    }

    if (postcode == "") {
        var requestURL = "http://api.lmiforall.org.uk/api/v1/vacancies/search?keywords=" + job;
    }
    else {
        // if the input string contains a blank space 
        if (postcode.indexOf(' ') >= 0) {
            // encode the URI component to replace the blank space with '%20' 
            postcode = encodeURIComponent(postcode.trim())
        }
        var requestURL = "http://api.lmiforall.org.uk/api/v1/vacancies/search?location=" + postcode + "&keywords=" + job;
    }

    console.log(requestURL);

    var req = $.ajax({
        url: requestURL,
        dataType: "jsonp"
    });
    req.done(function (data) {
        if (data && data.length > 0) {
            console.log(data);
            $('<p/>', { text: '(' + data.length + ') vacancies results found.' }).appendTo('#content');
            displayVacancies(data);
        }
        else {
            noResultsFound();
        }

    });

    //DISPLAY VACANCIES ON SCREEN
    function displayVacancies(vacancies) {
        for (var i = 0; i < vacancies.length; i++) {
            $('<div/>', { class: 'vacancy', id: 'vacancy' + i }).appendTo('#content');
            $('<p/>', { text: 'Job ID: ' + vacancies[i].id }).appendTo('#vacancy' + i);
            $('<p/>', { text: 'Job Title: ' + vacancies[i].title }).appendTo('#vacancy' + i);
            $('<p/>', { text: 'Company: ' + vacancies[i].company }).appendTo('#vacancy' + i);
            $('<p/>', { text: 'Location: ' + vacancies[i].location.location }).appendTo('#vacancy' + i);
            $('<p/>', { text: 'Job Description: ' }).appendTo('#vacancy' + i);
            $('<p/>', { text: vacancies[i].summary }).appendTo('#vacancy' + i);
            $('<center/>', { id: 'center' + i }).appendTo('#vacancy' + i);
            $('<input/>', { type: 'submit', value: 'View', onclick: "location.href=" + "'" + vacancies[i].link + "'" }).appendTo('#center' + i);
        }
        $(".pre-load").fadeOut("slow");
    }
}
//END FUNCTIONS FOR VACANCIES_RESULTS.PHP
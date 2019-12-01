function noResultsFound() {
    $('<h1/>', { text: 'Sorry - No Results Could Be Found' }).appendTo('#content');
    $('<p/>', { id: 'txtError', text: 'You can return home by clicking the link ' }).appendTo('#content');
    $('<a/>', { text: 'here' }).appendTo('#txtError');
    $(".pre-load").fadeOut("slow");
}

//BEGIN FUNCTIONS FOR SEARCH_RESULTS.PHP - GETTING AREA BREAKDOWN INFORMATION
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

function getMSP(personID) {
    var requestURL = "https://data.parliament.scot/api/members?ID=" + personID;

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (msp) {
        console.log(msp);
        mspID = msp.PersonID;
        $('<p/>', { text: 'MSP: ' + formatMSPName(msp.ParliamentaryName) }).appendTo('#content');
        getMemberParty(msp.PersonID);
    });
}

function formatMSPName(name) {
    name = String(name);
    var index = name.indexOf(", ");
    var secondName = name.substr(0, index);
    var firstName = name.substr(index + 1);

    return firstName + " " + secondName;
}

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

function getParty(partyID) {
    var requestURL = "https://data.parliament.scot/api/parties?ID=" + partyID;

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (party) {
        $('<p/>', { text: 'MSP Party: ' + party.ActualName }).appendTo('#content');
        getAddress(mspID);
    });
}

function getAddress(personID) {
    var requestURL = "https://data.parliament.scot/api/addresses";

    var req = $.ajax({
        url: requestURL,
        dataType: "json"
    });
    req.done(function (data) {
        $.each(data, function (index, address) {
            if (address.PersonID == personID) {
                if (address.AddressType = 2) {
                    console.log(address);
                    $('<p/>', { text: 'MSP Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode }).appendTo('#content');
                    $('<h3/>', { text: ward + ' - Area Statistics' }).appendTo('#content');
                    drawCharts(address.PostCode);
                }
                else if (address.AddressType = 1) {
                    console.log(address);
                    $('<p/>', { text: 'MSP Address: ' + address.Line1 + ", " + address.Line2 + " " + address.PostCode }).appendTo('#content');
                    $('<h3/>', { text: ward + ' - Area Statistics' }).appendTo('#content');
                    drawCharts(address.PostCode);
                }

            }
        });

    });
}

function drawCharts(postcode) {
    $('<div/>', { id: 'chartContainer', class: 'wrapper' }).appendTo('#content');
    $('<div/>', { id: 'one' }).appendTo('#chartContainer');
    $('<div/>', { id: 'two' }).appendTo('#chartContainer');

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
//END SEARCH_RESULTS.PHP FUNCTIONS

function isValidPostcode(p) {
    var postcodeRegEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return postcodeRegEx.test(p);
}

//BEGIN FUNCTIONS FOR VACANCIES_RESULTS.PHP
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
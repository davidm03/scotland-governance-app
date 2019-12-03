//JS FILE CONTANING FUNCTIONS USED ON VACANCIES_RESULTS.PHP

//GET VACANCIES FOR USER SELECTED JOB AND/OR POSTCODE
function getVacancies(postcode, job) {

    if (job != null) {
        // if the input string contains a blank space 
        if (job.indexOf(' ') >= 0) {
            // encode the URI component to replace the blank space with '%20' 
            job = encodeURIComponent(job.trim())
        }
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
//END
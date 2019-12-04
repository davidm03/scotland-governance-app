//JS FILE CONTAINING ANY FUNCTIONS THAT ARE REUSED THROUGHOUT THE WEBSITE

//FUNCTION TO DISPLAY NO RESULTS FOUND MESSAGE
function noResultsFound() {
    //display no results found message on webpage
    $('<h1/>', { text: 'Sorry - No Results Could Be Found' }).appendTo('#content');
    $('<p/>', { id: 'txtError', text: 'You can return home by clicking the link ' }).appendTo('#content');
    $('<a/>', { text: 'here', href: 'index.php' }).appendTo('#txtError');
    $(".pre-load").fadeOut("slow");
}

//CHECK IF USER INPUT IS VALID POSTCODE
function isValidPostcode(p) {
    //validate postcode is in the correct format
    var postcodeRegEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return postcodeRegEx.test(p);
}
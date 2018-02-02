/*functions for making ajax user admin page */

// Return current user ID
function museumId() {
    return $('#museum_id_value').val();
}

// Set the current user ID
var setMuseumId = function setMuseumId(id) {
    $('#museum').attr('action', Router.generatePath('dime.api.museum.item', { id: id }));
};

// Call API to fetch user details
var fetchMuseumActor = function (id) {
    clearPageAlert();
    $('#museum').clearForm();
    var path = Router.generatePath('dime.api.museum.item', { id: id });
    if (path === undefined) {
        return;
    }
    $.ajax(path).fail(function (response) {
        $('#museum').clearForm();
        setPageAlert(response.status, response.message, 5000);
    }).done(function (response) {
        FormMapper.mapDataToForm(response, $('#museum')[0]);
        setMuseumId(id);
    });
};

// AJAX Form Submission
function museumFormSubmit(data, form, options) {
    clearPageAlert();
    return museumId() ? true : false;
}

// AJAX Form post-submit callback
function museumFormSuccess(response) {
    setPageAlert(response.status, response.message, 5000);
}

var museumSelected = function (e) {
    e.preventDefault();
    e.stopPropagation();
    var target = $(e.target).is('tr') ? $(e.target) : $(e.target).closest('tr');
    fetchMuseumActor(target.attr('data-unique-id'));
};

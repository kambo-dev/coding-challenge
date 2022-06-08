var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;

let header_tabs_container = `network_header_tabs_container`;
let suggestions_btn = `get_suggestions_btn`;
let sent_requests_btn = `get_sent_requests_btn`;
let received_requests_btn = `get_received_requests_btn`;
let connections_btn = `get_connections_btn`;
let load_more_btn_parent = `load_more_btn_parent`;
let load_more_btn = `load_more_btn`;


function getRequests(mode) {
    event.preventDefault();
    let target = $(`#get_${mode}_requests_btn`);

    getData("/requests/data", {
        type: mode,
        perPage: takeAmount
    }, target);
}

function getMoreRequests(mode) {
    event.preventDefault();
    let target = $(`#get_${mode}_requests_btn`);

    let next_page = $(`#${load_more_btn}`).data('url');

    appendData(next_page, {
        type: mode,
        perPage: takeAmount
    }, target);
}

function getConnections() {
  // your code here...
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnectionsInCommon(userId, connectionId) {
  // your code here...
}

function getMoreConnectionsInCommon(userId, connectionId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getSuggestions() {
    event?.preventDefault();
    let target = $(`#${suggestions_btn}`);

    getData("users/suggestions", {}, target);
}

function getMoreSuggestions() {
    event.preventDefault();
    let target = $(`#${suggestions_btn}`);

    let next_page = $(`#${load_more_btn}`).data('url');

    appendData(next_page, {}, target);
}

// create new connection request between $user and $suggestion
function sendRequest(userId, suggestionId) {
    let data = {
        target: suggestionId
    };

    ajax("requests/store", 'POST', (response) => {
        getSuggestions();
    }, data)
}

// remove existing connection request
function deleteRequest(userId, requestId) {
    ajax(`requests/delete/${requestId}`, 'DELETE', (response) => {
        getRequests('sent');
    }, {});
}

// update existing connection request status as "accepted"
function acceptRequest(userId, requestId) {
    let data = {
        status: 'accepted'
    };

    ajax(`requests/update/${requestId}`, 'PUT', (response) => {
          getRequests('received');
    }, data);
}

function removeConnection(userId, connectionId) {
  // your code here...
}

// update counters of suggestions, connections, requests sent and received tabs header
function getHeaderCounters() {
    ajax("requests/counters", 'GET', (response) => {
        if (response.success) {
            $(`#${suggestions_btn}`).text(
                $(`#${suggestions_btn}`).text().replace(/\((.*)\)/g, `(${response.data.count_suggestions})`)
            );
            $(`#${sent_requests_btn}`).text(
                $(`#${sent_requests_btn}`).text().replace(/\((.*)\)/g, `(${response.data.count_sent})`)
            );
            $(`#${received_requests_btn}`).text(
                $(`#${received_requests_btn}`).text().replace(/\((.*)\)/g, `(${response.data.count_received})`)
            );
            $(`#${connections_btn}`).text(
                $(`#${connections_btn}`).text().replace(/\((.*)\)/g, `(${response.data.count_connections})`)
            );
        }
    }, {});
}

$(function () {
    // load counters for each header tab
    getHeaderCounters();

    // load suggestions as the default tab
    getSuggestions();
});

// empty container and rerender data from url
// url - endpoint querying
// data - object of data being submitted
// tabLabel - the tab that is being triggered
function getData(url, data, tabLabel) {
    let content = $(`#${contentId}`);

    content.empty();
    initLoader(content);

    const formData = new FormData();
    Object.keys(data).forEach(key => formData.append(key, data[key]));

    ajax(url, 'GET', (response, target = tabLabel) => {
        if (response.success) {
            // update tab counter
            target.text(target.text().replace(/\((.*)\)/g, `(${response.data.count})`));

            // uncheck all head tab buttons except current tab
            $(`#${header_tabs_container} > input[type="radio"]`).prop("checked", false);
            $(`#${header_tabs_container} > input#${target.prop("for")}[type="radio"]`).prop("checked", true);

            let content = $(`#${contentId}`);
            content.empty();
            content.append(response.data.content);
        } else {
            //@todo handle unsuccessful response and display error message to user
            //@todo use Toastr js to display error messages as popups
        }
    }, data);
}

// load more data from url and append it to bottom of container
// url - endpoint querying
// data - object of data being submitted
// tabLabel - the tab that is being triggered
function appendData(url, data, tabLabel) {
    let content = $(`#${contentId}`);

    // remove load-more button
    let load_more = $(`#${load_more_btn_parent}`);
    load_more.remove();

    initLoader(content);

    ajax(url, 'GET', (response, target = tabLabel) => {
        if (response.success) {
            target.text(target.text().replace(/\((.*)\)/g, `(${response.data.count})`));
            let content = $(`#${contentId}`);
            // remove the loading spinner only
            content.find(`.spinner-border`).parent().remove();
            content.append(response.data.content);
        } else {
            //@todo handle unsuccessful response and display error message to user
            //@todo use Toastr js to display error messages as popups
        }
    }, data);
}

// display content spinner while content is not loaded
// container - element to insert spinner into
function initLoader(container) {
    container.append(`
        <div class="d-flex flex-column align-items-center gap-3 mb-2 text-white bg-dark p-1 shadow">
          <div class="spinner-border spinner-border-md text-primary" role="status" aria-hidden="true"></div>
          <strong class="ms-1 text-primary">Loading...</strong>
        </div>
    `);
}

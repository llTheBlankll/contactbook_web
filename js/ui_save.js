function syncSearchToSelect() {
    var search = document.getElementById("js_search");
    var sortby = document.getElementById("js_sortby");

    search.placeholder = "Search contact by " + sortby.value;
}
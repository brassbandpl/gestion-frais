// app.js

const $ = require('jquery');
// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it
require('bootstrap');
require('../css/global.scss');
require('../css/main.css');
require('../css/util.css');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

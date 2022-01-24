/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import 'alpinejs'
import 'select2';

window.$ = window.jQuery = require('jquery');
window.Swal = require('sweetalert2');

var $ = window.$;

require('../bootstrap');
require('@coreui/coreui');
require('../plugins');

require('./api/index');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

// Plugins
require('../plugins/bootstrap-switch');

require('../plugins/chartist.min');

require('../plugins/bootstrap-notify');

require('../plugins/jquery-jvectormap');

require('../plugins/bootstrap-datetimepicker');

require('../plugins/sweetalert2.min');

// require('paper-dashboard/plugins/plugin-sweetalert2');

require('../plugins/bootstrap-tagsinput');

require('../plugins/nouislider');

require('../plugins/bootstrap-selectpicker');

require('../plugins/jquery.validate.min');

require('../plugins/jquery.bootstrap-wizard');

require('../plugins/bootstrap-table');

require('../plugins/perfect-scrollbar.jquery.min');

require('../plugins/jasny-bootstrap.min');

require('../plugins/jquery.dataTables.min');

require('../plugins/fullcalendar.min');

// template
require('../paper-dashboard');

// custom scripts
require('../scripts/bootstrap-form-validation-setup');

require('../scripts/bootstrap-table-setup');

require('../scripts/bootstrap-datetime-setup');

require('../scripts/live-file-review');

// Vue Setup
window.Vue = require('vue')

//===============================================================================//
//==================ADD THE LINES UNDERNEATH=====================================//
window.Lightbox = require('vue-pure-lightbox').default
window.VueContext = require('vue-context');
Vue.use(Lightbox);
Vue.use(VueContext);

global.VueEventBus = new Vue();
window.UUID = require('../components/admin/utils/UUID').default;

//===================ADD THE LINES ABOVE=========================================//
//===============================================================================//

// require('../../vendor/MediaManager/js/manager.js')

const files = require.context('../', true, /\.vue$/i)
files.keys().map(key => {Vue.component(key.split('/').pop().split('.')[0], files(key).default)});

// const vendorVueFiles = require.context('../../', true, /\.vue$/i)
// vendorVueFiles.keys().map(key => {Vue.component(key.split('/').pop().split('.')[0], files(key).default)});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#admin-app'
});

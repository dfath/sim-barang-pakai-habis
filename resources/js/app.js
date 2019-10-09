
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

window.Buefy = require('buefy');

Vue.use(Buefy);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('example-input', require('./components/ExampleInput.vue').default);
// Vue.component('range-date-picker', require('./components/RangeDatePicker.vue').default);
Vue.component('passport-clients', require('./components/passport/Clients.vue').default);
Vue.component('delete-confirmation', require('./components/DeleteConfirmation.vue').default);
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);
Vue.component('barang-masuk-board', require('./pages/barang-masuk/BarangMasukBoard.vue').default);
Vue.component('barang-masuk-edit', require('./pages/barang-masuk/BarangMasukEdit.vue').default);
Vue.component('unit-kerja-board', require('./pages/unit-kerja/UnitKerjaBoard.vue').default);
Vue.component('satuan-board', require('./pages/satuan/SatuanBoard.vue').default);
Vue.component('kelompok-kegiatan-board', require('./pages/kelompok-kegiatan/KelompokKegiatanBoard.vue').default);
Vue.component('kelompok-barang-board', require('./pages/kelompok-barang/KelompokBarangBoard.vue').default);
Vue.component('barang-board', require('./pages/barang/BarangBoard.vue').default);
Vue.component('perusahaan-board', require('./pages/perusahaan/PerusahaanBoard.vue').default);
Vue.component('volume-dpa-board', require('./pages/volume-dpa/VolumeDpaBoard.vue').default);
Vue.component('barang-keluar-board', require('./pages/barang-keluar/BarangKeluarBoard.vue').default);
Vue.component('barang-masuk-laporan', require('./pages/barang-masuk/BarangMasukLaporan.vue').default);
Vue.component('barang-keluar-laporan', require('./pages/barang-keluar/BarangKeluarLaporan.vue').default);

const app = new Vue({
    el: '#app'
});


// Bulma NavBar Burger Script
document.addEventListener('DOMContentLoaded', function () {
    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(function ($el) {
            $el.addEventListener('click', function () {

                // Get the target from the "data-target" attribute
                let target = $el.dataset.target;
                let $target = document.getElementById(target);

                // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                $el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

            });
        });
    }

});

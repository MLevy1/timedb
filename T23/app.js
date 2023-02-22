import Vue from 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js';
import TimeTracker from 'TimeTracker.vue';

Vue.component('time-tracker', TimeTracker);

new Vue({
    el: '#app'
});
import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import Dashboard from './components/Dashboard';
import Calendar from './components/Calendar';
import Github from './components/Github';
import Instagram from './components/Instagram';
import InternetConnection from './components/InternetConnection';
import Npm from './components/Npm';
import Packagist from './components/Packagist';
import Socks from './components/Socks';
import TimeWeather from './components/TimeWeather';
import Twitter from './components/Twitter';

new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        Calendar,
        Github,
        Instagram,
        InternetConnection,
        Npm,
        Packagist,
        Socks,
        TimeWeather,
        Twitter,
    },

    created() {
        let options = {
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            cluster: window.dashboard.pusherCluster,
        };

        if (window.dashboard.usingNodeServer) {
            options = {
                broadcaster: 'socket.io',
                host: 'http://dashboard.spatie.be:6001',
            };
        }

        this.echo = new Echo(options);
    },
});

<template>
    <tile :position="position" modifiers="overflow">
        <section class="calendar">
            <h1 class="calendar__title">Schedule</h1>
            <ul class="calendar__events">
                <li v-for="event in visibleEvents" class="calendar__event">
                    <h2 class="calendar__event__title">{{ event.name }}</h2>
                    <div class="calendar__event__date">
                        {{ event.isNow ? 'Right now!' : relativeDate(event.date) }}
                    </div>
                </li>
            </ul>
        </section>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import moment from 'moment';
import { relativeDate } from '../helpers';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            events: {},
        };
    },

    mounted() {
        window.setInterval(this.$forceUpdate, 1000);
    },

    computed: {
        visibleEvents() {
            return Object.values(this.events)
                .map(event => ({
                    ...event,
                    isNow: (
                        moment(event.date).isAfter(moment().subtract(1, 'hour')) &&
                        moment(event.date).isBefore(moment())
                    ),
                    isFuture: moment(event.date).isAfter(moment()),
                }))
                .filter(event => event.isNow || event.isFuture);
        }
    },

    methods: {
        relativeDate,

        getEventHandlers() {
            return {
                'Calendar.EventsFetched': response => {
                    this.events = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'calendar',
            };
        },
    },
};
</script>

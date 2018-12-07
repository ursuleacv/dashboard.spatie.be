<template>
    <tile :position="position" no-fade>
        <div
            class="absolute"
            :style="{
                height: '33%',
                bottom: '-2px',
                left: '-2px',
                right: '-2px',
            }"
        >
            <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="forecastGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop
                            offset="0%"
                            style="stop-color: var(--text-accent); stop-opacity: 0.05"
                        />
                        <stop
                            offset="100%"
                            style="stop-color: var(--text-accent); stop-opacity: 0.15"
                        />
                    </linearGradient>
                    <mask id="myMask">
                        <path :d="svgCurve(rainForecastPoints)" fill="white" />
                    </mask>
                </defs>
                <path
                    :d="svgCurve(rainForecastPoints)"
                    fill="url(#forecastGradient)"
                />
            </svg>
        </div>
        <div
            class="grid gap-2 justify-items-center h-full"
            style="grid-template-rows: auto 1fr auto;"
        >
            <div class="markup">
                <h1>{{ date }}</h1>
            </div>
            <div class="align-self-center font-bold text-4xl tracking-wide leading-none">
                {{ time }}
            </div>
            <div class="uppercase">
                <div
                    class="grid gap-4 items-center"
                    style="grid-template-columns: repeat(3, auto);"
                >
                    <span>
                        {{ weather.temperature }}°
                        <span class="text-sm uppercase text-dimmed">out</span>
                    </span>
                    <span>
                        <office-temperature />
                        <span class="text-sm uppercase text-dimmed">in</span>
                    </span>
                    <span class="text-2xl" v-html="weather.icon"></span>
                </div>
                <div class="hidden">{{ weatherCity }}</div>
            </div>
        </div>
    </tile>
</template>

<script>
import { emoji, svgCurve } from '../helpers';
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import moment from 'moment-timezone';
import weather from '../services/weather/Weather';
import OfficeTemperature from './atoms/OfficeTemperature';

export default {
    components: {
        OfficeTemperature,
        Tile,
    },

    mixins: [echo],

    props: {
        weatherCity: {
            type: String,
        },
        dateFormat: {
            type: String,
            default: 'DD-MM-YYYY',
        },
        timeFormat: {
            type: String,
            default: 'HH:mm',
        },
        timeZone: {
            type: String,
        },
        position: {
            type: String,
        },
    },

    data() {
        return {
            date: '',
            time: '',
            weather: {
                temperature: '',
                iconClass: '',
            },
            rainForecasts: [
                { time: '2018-11-29T10:10:00', rain: 2.0 },
                { time: '2018-11-29T10:15:00', rain: 1.0 },
                { time: '2018-11-29T10:20:00', rain: 1.8 },
                { time: '2018-11-29T10:25:00', rain: 0.4 },
                { time: '2018-11-29T10:30:00', rain: 0.4 },
                { time: '2018-11-29T10:35:00', rain: 2.2 },
                { time: '2018-11-29T10:40:00', rain: 1.0 },
                { time: '2018-11-29T10:45:00', rain: 0.2 },
                { time: '2018-11-29T10:50:00', rain: 0.6 },
                { time: '2018-11-29T10:55:00', rain: 1.4 },
                { time: '2018-11-29T11:00:00', rain: 0.4 },
                { time: '2018-11-29T11:05:00', rain: 1.0 },
                { time: '2018-11-29T11:10:00', rain: 1.4 },
            ],
        };
    },

    created() {
        this.refreshTime();
        setInterval(this.refreshTime, 1000);

        this.fetchWeather();
        setInterval(this.fetchWeather, 15 * 60 * 1000);

        setTimeout(() => {
            this.updateRainForecasts([
                { time: '2018-11-29T10:10:00', rain: 1.0 },
                { time: '2018-11-29T10:15:00', rain: 0.5 },
                { time: '2018-11-29T10:20:00', rain: 3.0 },
                { time: '2018-11-29T10:25:00', rain: 0.6 },
                { time: '2018-11-29T10:30:00', rain: 0.7 },
                { time: '2018-11-29T10:35:00', rain: 2.5 },
                { time: '2018-11-29T10:40:00', rain: 0.2 },
                { time: '2018-11-29T10:45:00', rain: 0.3 },
                { time: '2018-11-29T10:50:00', rain: 0.7 },
                { time: '2018-11-29T10:55:00', rain: 1.8 },
                { time: '2018-11-29T11:00:00', rain: 0.1 },
                { time: '2018-11-29T11:05:00', rain: 1.5 },
                { time: '2018-11-29T11:10:00', rain: 1.2 },
            ]);
        }, 2000);
    },

    computed: {
        rainForecastPoints() {
            return this.rainForecasts
                .map((rainForecast, i) => {
                    const rainInMilliMeters = Math.min(rainForecast.rain, 4);
                    const rainPercentage = rainInMilliMeters / 4;
                    const humanizedRainPercentage = rainPercentage ** (1 / 1.5);

                    return [(1 / (this.rainForecasts.length - 1)) * i, 1 - humanizedRainPercentage];
                })
                .map(([x, y]) => [Math.round(x * 100), Math.round(y * 100)]);
        },
    },

    methods: {
        emoji,
        svgCurve,

        refreshTime() {
            this.date = moment()
                .tz(this.timeZone)
                .format(this.dateFormat);
            this.time = moment()
                .tz(this.timeZone)
                .format(this.timeFormat);
        },

        getEventHandlers() {
            return {
                'Buienradar.ForecastsFetched': response => {
                    this.rainForecasts = response.forecasts;
                },
            };
        },

        async fetchWeather() {
            const conditions = await weather.conditions(this.weatherCity);

            let icon;

            switch (parseInt(conditions.code)) {
                case 0:
                case 1:
                case 2:
                    icon = '🌪';
                    break;
                case 3:
                case 4:
                case 37:
                case 38:
                case 39:
                case 45:
                case 47:
                    icon = '⛈';
                    break;
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                case 10:
                case 17:
                case 18:
                    icon = '🌨';
                    break;
                case 11:
                case 12:
                case 35:
                case 40:
                    icon = '☔️';
                    break;
                case 13:
                case 14:
                case 15:
                case 16:
                case 42:
                case 46:
                    icon = '❄️';
                    break;
                case 19:
                case 20:
                case 21:
                case 22:
                    icon = '🌫';
                    break;
                case 23:
                case 24:
                case 25:
                    icon = '💨';
                    break;
                case 26:
                    icon = '☁️';
                    break;
                case 27:
                case 28:
                case 29:
                case 30:
                case 44:
                    icon = '⛅️';
                    break;
                case 31:
                case 33:
                    icon = '🌌';
                    break;
                case 32:
                case 34:
                    icon = '☀️';
                    break;
                case 36:
                    icon = '🌡';
                    break;
                case 41:
                case 43:
                    icon = '⛷';
                    break;
                default:
                    icon = '🧐';
            }

            this.weather.temperature = conditions.temp;
            this.weather.icon = emoji(icon);
        },

        updateRainForecasts(rainForecasts) {
            const animationStart = performance.now();

            const initialRainForecastValues = this.rainForecasts.map(rainForecast => {
                return rainForecast.rain;
            });

            const animate = () => {
                const position = (performance.now() - animationStart) / 1000;

                if (position < 1) {
                    this.rainForecasts = rainForecasts.map((rainForecast, i) => {
                        const initialValue = initialRainForecastValues[i];

                        return {
                            time: rainForecast.time,
                            rain: initialValue + (rainForecast.rain - initialValue) * (position * (2 - position)),
                        }
                    });

                    requestAnimationFrame(animate);
                } else {
                    this.rainForecasts = rainForecasts;
                }
            }

            requestAnimationFrame(animate);
        },
    },
};
</script>

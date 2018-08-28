<template>
    <tile :position="position" modifiers="overflow-visible">
        <svg style="width:100%; height:115%" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 530 1366.75"><defs><mask id="mask" x="38.54" y="116.91" width="438.49" height="1194.37" maskUnits="userSpaceOnUse"><g transform="translate(-265 -169.45)"><path d="M674.2,286.36h0L377.7,306.91h0c-7.4,1.07-12.7,6.67-12,12.9l13.6,132.65c0.6,6.23,6.9,11.12,14.4,11.12l44.9,439a114.16,114.16,0,0,0-8.9,21.26L308.8,1312c-22.3,71.53,28.4,145,113.3,164.15h0c84.8,19.13,171.7-23.4,194-94.93L736.8,982.28a106.28,106.28,0,0,0,2.9-55.07L690.2,443.12c7.4-1.07,12.7-6.67,12-12.9L688.6,297.57C688,291.25,681.8,286.36,674.2,286.36Z" style="fill:#fff"/></g></mask><filter id="luminosity-noclip" x="274.54" y="-8960.45" width="510.98" height="32766" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-color="#fff" result="bg"/><feBlend in="SourceGraphic" in2="bg"/></filter></defs><polygon points="210.9 22.42 253.9 24.11 244.9 184.17 201.9 182.48 210.9 22.42" style="fill:rgba(0,0,0,.1);isolation:isolate"/><polygon points="223.7 31.58 260.3 33.01 251.2 193.06 214.7 191.64 223.7 31.58" style="fill:#a19d90"/><path d="M644.76,287.93h0L347.56,325h0c-7.39,1.49-12.45,7.46-11.45,13.73l20,133.65c0.9,6.28,7.47,10.89,15,10.48l66.06,442.3a117.16,117.16,0,0,0-7.94,22l-103.1,399.9c-19,73.69,35.47,145.37,121.76,160.11h0c86.19,14.74,171.56-33.11,190.58-106.8l102.39-410.8a108.65,108.65,0,0,0,.29-56L668.31,445.89c7.39-1.49,12.45-7.46,11.45-13.73l-20-133.65C658.87,292.14,652.4,287.52,644.76,287.93Z" transform="translate(-265 -169.45)" style="fill:rgba(0,0,0,.1);isolation:isolate"/><path d="M674.2,286.36h0L377.7,306.91h0c-7.4,1.07-12.7,6.67-12,12.9l13.6,132.65c0.6,6.23,6.9,11.12,14.4,11.12l44.9,439a114.16,114.16,0,0,0-8.9,21.26L308.8,1312c-22.3,71.53,28.4,145,113.3,164.15h0c84.8,19.13,171.7-23.4,194-94.93L736.8,982.28a106.28,106.28,0,0,0,2.9-55.07L690.2,443.12c7.4-1.07,12.7-6.67,12-12.9L688.6,297.57C688,291.25,681.8,286.36,674.2,286.36Z" transform="translate(-265 -169.45)" style="fill:#1e3852"/><rect width="530" height="1366.75" style="fill:none"/><g style="mask:url(#mask)"><g style="transform-origin: 50% 100%; transition: transform 3s ease-out" :style="socksTransform"><polygon points="506.7 114.42 9.61 122.88 23.04 1314.09 520.46 1308.35 506.7 114.42" style="fill:var(--red)"/></g></g><text transform="translate(300 512.09) rotate(-4.25)" style="font-size:230px;fill:#fff;font-family:Source Sans Pro;font-weight:900" text-anchor="middle">{{ socksLeft }}</text><text text-anchor="middle" transform="translate(310 589.79) rotate(-4.25)" style="font-size:50px;fill:#fff;font-family:Source Sans Pro;font-weight:600">PAIR{{ socksLeft != 1 ? 'S' : '' }} LEFT</text><polygon points="230.4 28.14 266.9 25.64 281.1 205.14 244.6 207.74 230.4 28.14" style="fill:#b3afa1"/><line x1="85.2" y1="1160.45" x2="288.7" y2="1204.05" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:5.670000076293945px;opacity:0.2"/><line x1="155.5" y1="305.66" x2="407.1" y2="288.23" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:5.670000076293945px;opacity:0.2"/></svg>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';

    export default {
        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: ['position'],

        data() {
            return {
                socksHandedOut: 0,
                totalSocks: 50,
            };
        },

        computed: {
            socksLeft() {
               const socksLeft = this.totalSocks - this.socksHandedOut;
               return socksLeft < 0 ? 0 : socksLeft;
            },
            socksTransform() {
                const socksTransform  = this.socksHandedOut/this.totalSocks;
                return 'transform:scaleY(' + (socksTransform > 1 ? 1 : socksTransform) + ')';
            }
        },

        methods: {
            getEventHandlers() {
                return {
                    'Socks.SocksHandedOut': response => {
                        this.socksHandedOut = response.socksHandedOut;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'socks',
                };
            },
        },
    };
</script>

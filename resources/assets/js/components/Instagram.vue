<template>
    <tile :position="position" modifiers="overflow transparent">
        <section>
            <div v-for="photo in photos">
                <img :src="photo.image_url" style="width: 100%" :alt="photo.description">
                {{ photo.description }}
            </div>
        </section>
    </tile>
</template>
<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';

export default {
    components: {
        Tile,
    },

    mixins: [echo],

    props: ['position', 'initialPhotos'],

    data() {
        return {
            photos: [],
        };
    },

    created() {
        this.photos = this.initialPhotos;

        setInterval(this.processWaitingLine, 1000);
    },

    methods: {
        getEventHandlers() {
            return {
                'Twitter.Mentioned': response => {
                    this.photos.push(response.photo);
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'instagram',
            };
        },
    },

}
</script>

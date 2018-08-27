<template>
    <tile :position="position" modifiers="overflow transparent">
         <section class="feed">
            <div class="feed-item--instagram" v-for="photo in photos">
                <div class="feed-item__attachment--instagram">
                    <img class="feed-item__attachment__image--instagram" :src="photo.image_url" :alt="photo.description"/>
                </div>
                <div class="feed-item__body--instagram ">
                    {{ photo.description }}
                </div>
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

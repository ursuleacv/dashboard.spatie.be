<template>
    <tile :position="position" modifiers="overflow transparent">
        <section class="feed">
            <div class="feed-item" v-for="tweet in onDisplay">
                <div class="feed-item__header">
                    <div class="feed-item__avatar"
                    :style="'background-image: url('+ tweet.authorAvatar +')'"></div>
                    <div class="feed-item__user">
                        <div class="feed-item__user__name h-ellipsis" v-html="tweet.authorName"></div>
                        <div class="feed-item__user__handle h-ellipsis">
                            {{ tweet.authorScreenName }}
                        </div>
                    </div>
                </div>
                <div :class="addClassModifiers('feed-item__body', tweet.displayClass)"
                v-html="tweet.html"></div>
                <div class="feed-item__meta">
                    <relative-date :moment="tweet.date"></relative-date>
                    <span v-if="tweet.hasQuote" class="feed-item__user__handle h-ellipsis">
                        In reply to {{ tweet.quote.authorScreenName }}
                    </span>
                </div>
                <div v-if="tweet.image" class="feed-item__attachment">
                    <img class="feed-item__attachment__image" :src="tweet.image"/>
                </div>
                <div v-if="tweet.hasQuote" class="feed-item--quoted">
                    <div class="feed-item__body feed-item__body--small" v-html="tweet.quote.html"></div>
                </div>
            </div>
        </section>
        <div class="feed__icon h-background-icon" v-if="!onDisplay.length">
        </div>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import RelativeDate from './atoms/RelativeDate';
import Tweet from '../services/twitter/Tweet';
import moment from 'moment';
import { diffInSeconds, addClassModifiers } from '../helpers';

export default {
    components: {
        Tile,
        RelativeDate,
    },

    mixins: [echo],

    props: ['position', 'initialTweets'],

    data() {
        return {
            displayingTopTweetSince: moment(),
            tweets: [],
            waitingLine: [],
            ownScreenName: '@spatie_be',
        };
    },

    created() {
        this.tweets = this.initialTweets.map(tweetProperties => new Tweet(tweetProperties));

        setInterval(this.processWaitingLine, 1000);
    },

    methods: {
        addClassModifiers,

        getEventHandlers() {
            return {
                'Twitter.Mentioned': response => {
                    this.addToWaitingLine(new Tweet(response.tweetProperties));
                },
            };
        },

        addToWaitingLine(tweet) {
            this.waitingLine.push(tweet);
        },

        processWaitingLine() {
            if (this.waitingLine.length === 0) {
                return;
            }

            if (diffInSeconds(this.displayingTopTweetSince) < 5) {
                return;
            }

            this.tweets.unshift(this.waitingLine.shift());

            this.tweets = this.tweets.slice(0, 20);

            this.displayingTopTweetSince = moment();
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'twitter',
            };
        },
    },

    computed: {
        onDisplay() {
            return this.tweets.filter(tweet => {
                return tweet.authorScreenName !== this.ownScreenName && !tweet.isRetweet;
            });
        },
    },
};
</script>

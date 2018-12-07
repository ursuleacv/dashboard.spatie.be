import moment from 'moment';
import twemoji from 'twemoji';

export function emoji(character) {
    return twemoji.parse(character);
}

export function formatNumber(value) {
    if (!value) {
        return 0;
    }

    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

export function formatDuration(start) {
    return moment.duration(moment().diff(start), 'milliseconds').format('d[d] h[h] m[m]');
}

export function withinWeek(value) {
    const date = moment(value);

    if (moment().diff(date, 'days') > -7) {
        return true;
    }

    return false;
}

export function relativeDate(value) {
    const date = moment(value);

    if (moment().isSame(date, 'd')) {
        return 'Today';
    }

    if (
        moment()
            .add(1, 'day')
            .isSame(date, 'd')
    ) {
        return 'Tomorrow';
    }

    if (date.isBetween(moment().add(1, 'day'), moment().add(8, 'days'), 'day')) {
        return date.format('dddd');
    }

    return 'In ' + date.toNow(true);
}

export function relativeDateTime(value) {
    const date = moment(value);

    if (moment().diff(date, 'days') > 5) {
        return 'A long long time ago';
    }

    if (moment().diff(date, 'days') > 1) {
        return `${moment().diff(date, 'days')} days ago`;
    }

    if (moment().diff(date, 'hours') >= 24) {
        return 'A day ago';
    }

    if (moment().diff(date, 'hours') > 1) {
        return `${moment().diff(date, 'hours')} hours ago`;
    }

    if (moment().diff(date, 'minutes') > 59) {
        return 'An hour ago';
    }

    if (moment().diff(date, 'seconds') > 119) {
        return `${moment().diff(date, 'minutes')} minutes ago`;
    }

    if (moment().diff(date, 'seconds') >= 60) {
        return 'A minute ago';
    }

    return 'Just now';
}

export function diffInSeconds(otherMoment) {
    return moment().diff(otherMoment, 'seconds');
}

export function formatTime(value) {
    return moment(value, 'X').format('HH:mm');
}

export function svgCurve(points) {
    const line = (pointA, pointB) => {
        const lengthX = pointB[0] - pointA[0];
        const lengthY = pointB[1] - pointA[1];
        return {
            length: Math.sqrt(Math.pow(lengthX, 2) + Math.pow(lengthY, 2)),
            angle: Math.atan2(lengthY, lengthX),
        };
    };

    const controlPoint = (current, previous, next, reverse) => {
        const p = previous || current;
        const n = next || current;

        const smoothing = 0.2;

        const o = line(p, n);

        const angle = o.angle + (reverse ? Math.PI : 0);
        const length = o.length * smoothing;

        const x = current[0] + Math.cos(angle) * length;
        const y = current[1] + Math.sin(angle) * length;

        return [x, y];
    };

    const command = (point, i, a) => {
        const [cpsX, cpsY] = controlPoint(a[i - 1], a[i - 2], point);
        const [cpeX, cpeY] = controlPoint(point, a[i - 1], a[i + 1], true);

        return `C ${cpsX},${cpsY} ${cpeX},${cpeY} ${point[0]},${point[1]}`;
    };

    return (
        points.reduce(
            (acc, point, i, a) =>
                i === 0 ? `M ${point[0]},${point[1]}` : `${acc} ${command(point, i, a)}`,
            ''
        ) + ' L 100,100 L 0,100 Z'
    );
}

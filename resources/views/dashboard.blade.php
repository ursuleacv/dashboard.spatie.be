<x-dashboard>
    <livewire:twitter-tile position="a1:a14" />

    <livewire:statistics-tile position="a15:a24" />

    <livewire:uptime-robot-tile position="b1:c24" />

{{--    <livewire:team-member-tile--}}
{{--        position="b1:b8"--}}
{{--        name="freek"--}}
{{--        :avatar="gravatar('adriaan@spatie.be')"--}}
{{--        birthday="1995-10-22"--}}
{{--    />--}}


    <livewire:calendar-tile position="e7:e16" :calendar-id="config('google-calendar.calendar_id')" />

{{--    <livewire:velo-tile position="e17:e24" />--}}

{{--    <livewire:belgian-trains-tile position="a1:a24"/>--}}

    <livewire:time-weather-tile position="e1:e6" />
</x-dashboard>

<template>
    <div>
        <h2>Events</h2>
        <ul>
            <li v-for="event in events">{{ event.name }}</li>
        </ul>
        <form @submit.prevent="addEvent">
            <label for="event-name">Event Name:</label>
            <input id="event-name" v-model="newEventName" type="text">
            <button type="submit">Add Event</button>
        </form>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            events: [],
            newEventName: ''
        }
    },
    methods: {
        addEvent: function() {
            this.events.push({
                name: this.newEventName
            });
            this.newEventName = '';
        }
    }
}
</script>

<style>
form {
    display: flex;
    flex-direction: column;
}
</style>

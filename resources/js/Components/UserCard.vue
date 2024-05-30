<script setup>
import { ref } from 'vue';
import { defineProps } from 'vue';

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
    restaurant: {
        type: Array,
        required: true,
    },
    LatAndLong: {
        type: Array,
        required: true,
    },
});
console.log(props.auth);
console.log(props.restaurant);
console.log(props.LatAndLong);
</script>
<template>
    <div>
        <h1>Vue 3</h1>
    </div>
</template>
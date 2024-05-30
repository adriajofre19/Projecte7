<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
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
});

const form = useForm({
    name: props.restaurant.name,
    latitude: props.restaurant.latitude,
    longitude: props.restaurant.longitude,
    description: props.restaurant.description
});

const submit = () => {
    form.post(route('restaurant.update', props.restaurant.id));
};
</script>

<template>

    <form @submit="submit">
        <TextInput v-model="form.name" label="Name" />
        <TextInput v-model="form.latitude" label="Latitude" />
        <TextInput v-model="form.longitude" label="Longitude" />
        <TextInput v-model="form.description" label="Description" />
        <PrimaryButton type="submit">Submit</PrimaryButton>
    </form>

</template>
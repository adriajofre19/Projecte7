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
    review: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    content: props.review.content,
    rating: props.review.rating,
});

const submit = () => {
    form.post(route('review.update', props.review.id));
};
</script>

<template>

    <form @submit="submit">
        <TextInput v-model="form.content" label="Content" />
        <TextInput v-model="form.rating" label="Rating" />
        <PrimaryButton type="submit">Submit</PrimaryButton>
    </form>

</template>
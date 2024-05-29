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
});

const form = useForm({
    name: '',
    latitude: '',
    longitude: '',
    description: ''
});

const submit = () => {
    form.post(route('restaurants.store'));
};

</script>

<template>
    <AuthenticatedLayout>
        <form @submit="submit">

            <Head title="Create Restaurant" />

            <div class="mb-4">
                <TextInput v-model="form.name" label="Name" />
            </div>

            <div class="mb-4">
                <TextInput v-model="form.latitude" label="Latitude" />
            </div>

            <div class="mb-4">
                <TextInput v-model="form.longitude" label="Longitude" />
            </div>

            <div class="mb-4">
                <TextInput v-model="form.description" label="Description" />
            </div>

            <div>
                <PrimaryButton type="submit">Create</PrimaryButton>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
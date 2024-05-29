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
    restaurants: {
        type: Array,
        required: true,
    },
});

function getRatingofRestaurant(restaurant) {
    let totalRating = 0;
    restaurant.reviews.forEach(review => {
        totalRating += review.rating;
    });
    return totalRating / restaurant.reviews.length;
}



const form = useForm({
    rating: '',
    content: '',
    restaurant_id: '',
});



const submit = () => {
    form.post(route('add-review', restaurant.id), {
        dd() {
            console.log('form', form);
        },
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>

<template>
    <AuthenticatedLayout>

        <section>
            <div class="py-16">
                <div class="mx-auto px-6 max-w-6xl text-gray-500">
                    <div class="relative">
                        <div class="relative z-10 grid gap-3 grid-cols-6">
                            <div v-for="restaurant in props.restaurants" :key="restaurant.id"
                                class="col-span-full lg:col-span-6 overflow-hidden relative p-8 rounded-xl bg-white border border-gray-200 dark:border-gray-800 dark:bg-gray-900">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img :src="restaurant.user.avatar" alt="restaurant image"
                                            class="h-10 w-10 object-cover rounded-full">
                                        <div class="ml-4">
                                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                                {{ restaurant.user.name }}
                                            </h2>
                                            <p class="text-sm text-gray-500">
                                                {{ restaurant.user.email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <img src="https://toohotel.com/wp-content/uploads/2022/09/TOO_restaurant_Panoramique_vue_Paris_nuit_v2-scaled.jpg"
                                    alt="restaurant image" class="w-full h-64 object-cover mt-4 rounded-lg">
                                <div class="ml-4 mt-4">

                                    <div class="flex">
                                        <svg v-for="i in Math.floor(getRatingofRestaurant(restaurant))" :key="i"
                                            class="w-6 h-6 text-yellow-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                        </svg>
                                    </div>




                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="ml-4 mt-4">
                                            <h2 class="text-lg font-semibold text-gray-800">
                                                {{ restaurant.name }}
                                            </h2>
                                            <p class="text-sm text-gray-500">
                                                {{ restaurant.description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div v-for="review in restaurant.reviews" :key="review.id">
                                    <div class="flex items-center mt-8">
                                        <img :src="review.user.avatar" alt="restaurant image"
                                            class="h-10 w-10 object-cover rounded-full">
                                        <div class="ml-4">
                                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                                {{ review.user.name }}
                                            </h2>
                                            <p class="text-sm text-gray-500">
                                                {{ review.user.email }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex mt-4">
                                        <svg v-for="i in review.rating" :key="i" class="w-6 h-6 text-yellow-400"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-4">
                                        {{ review.content }}
                                    </p>
                                </div>

                                <form @submit="submit" class="mt-8">
                                    <div class="flex flex-col">
                                        <div class="mb-4">
                                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                            <input v-model="form.rating" type="number" id="rating" name="rating" min="1" max="5"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                                            <textarea v-model="form.content" id="content" name="content" rows="3"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                        </div>
                                        <input type="hidden" v-model="form.restaurant_id" >
                                        <PrimaryButton type="submit">Submit</PrimaryButton>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>
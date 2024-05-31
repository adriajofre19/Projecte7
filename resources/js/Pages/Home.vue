<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Map from '@/Components/Map.vue';
import UserCard from '@/Components/UserCard.vue';
import { computed } from 'vue';

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
    if (restaurant.reviews.length === 0) {
        return 0;
    } else {
        restaurant.reviews.forEach(review => {
            totalRating += review.rating;
        });
        return totalRating / restaurant.reviews.length;
    }
}



import L from 'leaflet';

onMounted(() => {
    // set view to the first restaurant
    const map = L.map('map').setView([props.restaurants[0].latitude, props.restaurants[0].longitude], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    filteredRestaurants.value.forEach(restaurant => {
        L.marker([restaurant.latitude, restaurant.longitude]).addTo(map)
            .bindPopup(restaurant.name)
            .openPopup();
    });
});



const selectedRating = ref('');

const filteredRestaurants = computed(() => {
    return props.restaurants.filter(restaurant => {
        return getRatingofRestaurant(restaurant) >= selectedRating.value;
    });
});







</script>

<template>
    <AuthenticatedLayout>

        <div class="flex items-center justify-center mt-8">
            <select v-model="selectedRating" class="w-1/4 p-2 rounded-lg border border-gray-200 dark:border-gray-800">
                <option value="">All</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <section>

            <div class="py-16">
                <div class="mx-auto px-6 max-w-6xl text-gray-500">
                    <div class="relative">
                        <div class="relative z-10 grid gap-3 grid-cols-6">
                            <div
                                class="col-span-full lg:col-span-6 overflow-hidden relative p-8 rounded-xl bg-white border border-gray-200 dark:border-gray-800 dark:bg-gray-900">
                                <div id="map" ref="mapContainer">
                                    
                                </div>
                            </div>

                            <div v-for="restaurant in filteredRestaurants" :key="restaurant.id"
                                class="col-span-full lg:col-span-6 overflow-hidden relative p-8 rounded-xl bg-white border border-gray-200 dark:border-gray-800 dark:bg-gray-900">

                                <a :href="'/restaurant/' + restaurant.id">

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

                                        <div v-if="getRatingofRestaurant(restaurant) != 0" class="flex">
                                            <svg v-for="i in Math.floor(getRatingofRestaurant(restaurant))" :key="i"
                                                class="w-6 h-6 text-yellow-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                            </svg>
                                        </div>

                                        <div v-else>
                                            <h1 class="text-gray-400">Aquest restaurant no té valoracions</h1>
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
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-4">
                                            {{ review.content }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </AuthenticatedLayout>
</template>

<style>
#map {
    width: 100%;
    height: 500px;
    border-radius: 10px;
}
</style>
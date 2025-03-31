<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        price: number;
        image: { path: string };
    };
    href?: string;
}>();
</script>

<template>
    <Link
        :href="href ? href : '#'"
        class="transform overflow-hidden rounded-lg bg-card shadow transition duration-300 ease-out hover:scale-105 hover:shadow-xl dark:border dark:bg-card"
    >
        <!-- Square image container -->
        <div class="relative aspect-square">
            <img
                :src="product ? product.image.path : 'https://source.unsplash.com/featured/?product'"
                :alt="product.name"
                class="absolute inset-0 h-full w-full object-cover object-center"
            />
        </div>
        <div class="p-4">
            <h3 class="text-center text-lg font-semibold text-card-foreground">
                {{ product.name }}
            </h3>
            <!-- <p class="mt-2 text-sm text-muted-foreground">
                {{ product.description }}
            </p> -->
            <div class="mt-1 flex items-center justify-center">
                <span class="text-xl font-bold text-card-foreground text-primary"> ${{ (product.price / 100).toFixed(2) }} </span>
            </div>
        </div>
    </Link>
</template>

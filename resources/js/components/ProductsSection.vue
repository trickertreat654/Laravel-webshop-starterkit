<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import ProductCard from './ProductCard.vue';

defineProps<{
    title?: string;
}>();

const page = usePage();
</script>

<template>
    <!-- Featured Products Section -->
    <section class="container mx-auto bg-background py-12">
        <h2 class="mb-6 text-2xl font-bold text-foreground">
            {{ title ? title : 'All Products' }}
        </h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <ProductCard
                v-for="product in page.props.products"
                :key="product.id"
                :href="route('products.show', product.id)"
                :product="product"
                class="overflow-hidden rounded-lg bg-card shadow dark:bg-card"
            />
        </div>
    </section>
</template>

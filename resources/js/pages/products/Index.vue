<script setup lang="ts">
import ProductsSection from '@/components/ProductsSection.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Products', href: '/products' }];

const products = usePage().props.products;
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <ProductsSection
            :products="products"
            header-title="Products"
            header-description="Browse through our collection of products."
            empty-state-title="No products found"
            empty-state-description="It seems we don't have any products available at the moment."
        />
    </AppLayout>
</template>

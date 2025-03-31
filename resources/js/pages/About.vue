<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [{ title: 'About', href: '/about' }];
</script>

<template>
    <Head title="About Us" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-8 px-4 py-12">
            <h1 class="text-center text-3xl font-bold text-gray-900 dark:text-gray-100 md:text-4xl">About Us</h1>
            <div class="flex flex-col items-center md:flex-row md:space-x-8">
                <!-- Image Section with Aspect Ratio Container -->
                <div class="md:w-1/2">
                    <div class="relative aspect-[3/2]">
                        <img
                            src="https://picsum.photos/600/400?about"
                            alt="About Us"
                            class="absolute inset-0 h-full w-full rounded-lg object-cover shadow"
                        />
                    </div>
                </div>
                <!-- Text Content -->
                <div class="mt-6 md:mt-0 md:w-1/2">
                    <p class="text-gray-700 dark:text-gray-300">
                        Welcome to our shop! We are passionate about providing quality products that bring joy and convenience to our customers.
                    </p>
                    <p class="mt-4 text-gray-700 dark:text-gray-300">
                        Our journey began with a simple idea: to create a seamless and enjoyable shopping experience for everyone. Our team works
                        tirelessly to curate a diverse range of products that cater to your needs.
                    </p>
                    <p class="mt-4 text-gray-700 dark:text-gray-300">
                        We believe in innovation, quality, and customer satisfaction. Thank you for choosing us as your trusted partner. We look
                        forward to making your experience exceptional.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import HeroCarousel from '@/components/HeroCarousel.vue'; // Ensure you have this component created for the carousel
// import Hero from '@/components/Hero.vue';
import NewsletterSection from '@/components/NewsletterSection.vue';
import ProductsSection from '@/components/ProductsSection.vue';
import TestimonialSection from '@/components/TestimonialSection.vue';
import YouTubeVideo from '@/components/YouTubeVideo.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];
console.log('Welcome page loaded', page.props);
</script>

<template>
    <Head title="Home" />
    <AppLayout class="overflow-x-clip" :breadcrumbs="breadcrumbs">
        <!-- <Hero /> -->
        <HeroCarousel />
        <ProductsSection title="Featured Products" />
        <TestimonialSection />
        <YouTubeVideo
            videoId="your_youtube_video_id"
            title="Watch our introduction video"
            description="Learn more about our platform and what we offer."
        />
        <NewsletterSection />
    </AppLayout>
</template>

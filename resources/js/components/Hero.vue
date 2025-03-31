<script setup lang="ts">
import ButtonLink from './ButtonLink.vue';
interface Props {
    welcome?: string;
    slogan?: string;
    imageUrl?: string; // Optional image URL for the background
    buttonText?: string; // Optional text for the button
    buttonLink?: string; // Optional link for the button
}

const props = withDefaults(defineProps<Props>(), {
    welcome: 'Welcome to Our Store',
    slogan: 'Discover the best products just for you!',
    imageUrl: 'https://picsum.photos/1920/1080?random', // Default random image URL
    buttonText: 'Shop Now', // Default button text
    buttonLink: '/products', // Default button link
});
</script>

<template>
    <section
        class="relative left-1/2 h-[65vh] w-screen -translate-x-1/2 bg-cover bg-center sm:h-[70vh] md:h-[75vh] lg:h-[85vh]"
        :style="{ backgroundImage: `url(${props.imageUrl})` }"
    >
        <!-- Instead of hard-coded colors, consider using theme tokens -->
        <div class="absolute inset-0 bg-background/50 dark:bg-background/50"></div>

        <div class="relative z-10 flex h-full items-center justify-center">
            <div class="px-4 text-center">
                <h1 class="text-3xl font-bold sm:text-4xl md:text-5xl lg:text-6xl">
                    {{ welcome }}
                </h1>
                <p class="my-4 text-base sm:text-lg md:text-xl">
                    {{ slogan }}
                </p>
                <!-- Use props to dynamically set the button's text and link -->
                <ButtonLink size="lg" :href="props.buttonLink">
                    {{ props.buttonText }}
                </ButtonLink>
            </div>
        </div>
    </section>
</template>

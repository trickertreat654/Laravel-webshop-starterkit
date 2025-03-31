<script setup lang="ts">
import { Carousel, type CarouselApi, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import Autoplay from 'embla-carousel-autoplay';
import { ref } from 'vue';
import ButtonLink from './ButtonLink.vue';

interface HeroSlide {
    welcome?: string;
    slogan?: string;
    imageUrl?: string;
    buttonText?: string;
    buttonLink?: string;
}

const props = defineProps<{
    slides?: HeroSlide[];
}>();

// Provide multiple default slides if none are supplied
const defaultSlides: HeroSlide[] = [
    {
        welcome: 'Welcome to Our Store',
        slogan: 'Discover the best products just for you!',
        imageUrl: 'https://picsum.photos/1920/1080?random=1',
        buttonText: 'Shop Now',
        buttonLink: '/products',
    },
    {
        welcome: 'Exclusive Deals',
        slogan: 'Save big on your favorite items.',
        imageUrl: 'https://picsum.photos/1920/1080?random=2',
        buttonText: 'View Deals',
        buttonLink: '/deals',
    },
    {
        welcome: 'New Arrivals',
        slogan: 'Check out our latest collection.',
        imageUrl: 'https://picsum.photos/1920/1080?random=3',
        buttonText: 'Explore Now',
        buttonLink: '/new-arrivals',
    },
];

const slides = props.slides && props.slides.length ? props.slides : defaultSlides;

const emblaApi = ref<CarouselApi>();

const plugin = Autoplay({
    delay: 6000,
    stopOnMouseEnter: true,
    stopOnInteraction: false,
});
</script>

<template>
    <Carousel
        class="relative left-1/2 w-screen -translate-x-1/2 overflow-hidden"
        :plugins="[plugin]"
        @mouseenter="plugin.stop"
        @mouseleave="[plugin.reset(), plugin.play(), console.log('Running')]"
        @init-api="(val) => (emblaApi = val)"
    >
        <CarouselContent>
            <CarouselItem v-for="(slide, index) in slides" :key="index" class="flex justify-center">
                <section
                    class="relative left-1/2 h-[65vh] w-screen -translate-x-1/2 sm:h-[70vh] md:h-[75vh] lg:h-[85vh]"
                    :style="{
                        backgroundImage: `url(${slide.imageUrl})`,
                        backgroundSize: 'cover',
                        backgroundPosition: 'center',
                    }"
                >
                    <div class="absolute inset-0 bg-black bg-opacity-50 dark:bg-gray-800 dark:bg-opacity-50"></div>
                    <div class="relative z-10 flex h-full items-center justify-center">
                        <div class="px-4 text-center">
                            <h1 class="text-3xl font-bold text-white sm:text-4xl md:text-5xl lg:text-6xl">
                                {{ slide.welcome }}
                            </h1>
                            <p class="my-4 text-base text-gray-200 sm:text-lg md:text-xl">
                                {{ slide.slogan }}
                            </p>
                            <ButtonLink size="lg" :href="slide.buttonLink">
                                {{ slide.buttonText }}
                            </ButtonLink>
                        </div>
                    </div>
                </section>
            </CarouselItem>
        </CarouselContent>
        <!-- Arrow buttons positioned over the edges of the picture -->
        <CarouselPrevious class="absolute left-4 top-1/2 z-20 -translate-y-1/2 transform" />
        <CarouselNext class="absolute right-4 top-1/2 z-20 -translate-y-1/2 transform" />
    </Carousel>
</template>

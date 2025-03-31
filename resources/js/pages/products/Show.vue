<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Carousel, type CarouselApi, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import { Toaster } from '@/components/ui/toast';
import { useToast } from '@/components/ui/toast/use-toast';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import { watchOnce } from '@vueuse/core';
import { ref } from 'vue';

const { toast } = useToast();

const page = usePage(); // Access the page props to get the product details
// Import shadcn form components
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

// Import shadcn accordion components
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';

const props = defineProps<{ product: any }>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Products', href: '/products' }];

const form = useForm({
    product_id: props.product.id,
    variant: '',
});

// Carousel logic
const emblaMainApi = ref<CarouselApi>();
const emblaThumbnailApi = ref<CarouselApi>();
const selectedIndex = ref(0);

function onSelect() {
    if (!emblaMainApi.value || !emblaThumbnailApi.value) return;
    selectedIndex.value = emblaMainApi.value.selectedScrollSnap();
    emblaThumbnailApi.value.scrollTo(emblaMainApi.value.selectedScrollSnap());
}

function onThumbClick(index: number) {
    if (!emblaMainApi.value) return;
    emblaMainApi.value.scrollTo(index);
}

watchOnce(emblaMainApi, (api) => {
    if (!api) return;
    onSelect();
    api.on('select', onSelect);
    api.on('reInit', onSelect);
});

const submit = () => {
    if (!form.variant) {
        alert('Please select a variant');
        return;
    }
    form.post(route('items.store'), {
        preserveScroll: true,
        onFinish: (response) => {
            // Handle success response
            toast({
                title: 'Product Added to Cart',
                description: `"${props.product.name}" has been added to your cart successfully.`,
            });
        },
        onError: (errors) => {
            // Handle error response
            toast({
                title: 'Error Adding to Cart',
                description:
                    errors.variant === 'The selected variant is not available.'
                        ? 'Please select a valid product variant.'
                        : 'There was an issue adding the product to your cart. Please try again later.',
                variant: 'destructive',
            });
        },
    });
};

// Accordion content for FAQs
const defaultValue = 'item-1';
const accordionItems = [
    {
        value: 'item-1',
        title: 'What sizes do you offer?',
        content: 'Our collection includes sizes from XS to XXL, with detailed sizing guides available on each product page.',
    },
    {
        value: 'item-2',
        title: 'What materials are your clothes made from?',
        content: 'We source high-quality fabrics such as organic cotton, linen, and recycled polyester to ensure comfort and sustainability.',
    },
    {
        value: 'item-3',
        title: 'What is your return policy?',
        content: 'Enjoy hassle-free returns within 30 days of purchase, provided items are in their original condition with tags attached.',
    },
];
</script>

<template>
    <Head title="Product Details" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h1 class="mb-4 pt-4 text-2xl font-bold text-foreground">{{ page.props.product.name }}</h1>
        <Toaster />

        <Link :href="route('products.index')" class="mb-4 inline-block text-primary"> ← Continue Shopping </Link>
        <div class="container mx-auto max-w-7xl pt-4">
            <div class="flex flex-col gap-8 md:flex-row">
                <!-- Image Gallery Section with Carousel -->
                <div class="overflow-hidden md:w-1/2">
                    <!-- Main Carousel with arrows contained inside -->
                    <Carousel class="relative w-full" @init-api="(val) => (emblaMainApi = val)">
                        <CarouselContent>
                            <CarouselItem v-for="(img, index) in props.product.images" :key="img.id">
                                <!-- Square image container for main carousel -->
                                <div class="relative aspect-square">
                                    <img :src="img.path" :alt="`Product Image ${index + 1}`" class="absolute inset-0 h-full w-full object-cover" />
                                </div>
                            </CarouselItem>
                        </CarouselContent>
                        <CarouselPrevious />
                        <CarouselNext />
                    </Carousel>
                    <!-- Thumbnail Row Carousel -->
                    <Carousel class="relative mt-4 w-full max-w-xs" @init-api="(val) => (emblaThumbnailApi = val)">
                        <CarouselContent class="flex justify-start gap-1">
                            <CarouselItem
                                v-for="(img, index) in props.product.images"
                                :key="img.id"
                                class="basis-1/8 shrink-0 cursor-pointer"
                                @click="onThumbClick(index)"
                            >
                                <div class="h-16 w-16 p-1" :class="index === selectedIndex ? '' : 'opacity-50'">
                                    <img :src="img.path" :alt="`Thumbnail ${index + 1}`" class="h-full w-full rounded object-cover" />
                                </div>
                            </CarouselItem>
                        </CarouselContent>
                    </Carousel>
                </div>
                <!-- Product Details & Variant Form Section -->
                <div class="flex flex-col md:w-1/2">
                    <h1 class="mb-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ props.product.name }}
                    </h1>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">
                        {{ props.product.description }}
                    </p>
                    <p class="mb-4 font-bold text-gray-900 dark:text-gray-100">Price: ${{ (props.product.price / 100).toFixed(2) }}</p>
                    <!-- Updated form using shadcn components -->
                    <form @submit.prevent="submit" class="flex flex-col gap-4">
                        <FormField v-slot="{ field }" name="variant">
                            <FormItem>
                                <FormLabel>Select Variant</FormLabel>
                                <Select v-bind="field" v-model="form.variant">
                                    <FormControl>
                                        <SelectTrigger>
                                            <SelectValue placeholder="Please select" />
                                        </SelectTrigger>
                                    </FormControl>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem v-for="variant in props.product.variants" :key="variant.id" :value="variant.id">
                                                {{ variant.color }} - {{ variant.size }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <FormMessage v-if="form.errors.variant">
                                    {{ form.errors.variant }}
                                </FormMessage>
                            </FormItem>
                        </FormField>
                        <Button variant="default" type="submit" :disabled="form.processing"> Add to Cart </Button>
                    </form>
                    <!-- Accordion for FAQs -->
                    <div class="mt-8">
                        <Accordion type="single" class="w-full" collapsible :default-value="defaultValue">
                            <AccordionItem v-for="item in accordionItems" :key="item.value" :value="item.value">
                                <AccordionTrigger>{{ item.title }}</AccordionTrigger>
                                <AccordionContent>
                                    {{ item.content }}
                                </AccordionContent>
                            </AccordionItem>
                        </Accordion>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

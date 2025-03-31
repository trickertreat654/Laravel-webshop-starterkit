<script setup lang="ts">
interface Testimonial {
    id: number;
    quote: string;
    name: string;
    role?: string;
    avatar?: string;
}
interface Props {
    testimonials?: Testimonial[];
}

const props = withDefaults(defineProps<Props>(), {
    testimonials: [
        {
            id: 1,
            quote: 'I absolutely love the quality and service! This shop never disappoints, and the products always exceed my expectations.',
            name: 'Jane Smith',
            role: 'Happy Customer',
            avatar: 'https://picsum.photos/seed/testimonial/100',
        },
        {
            id: 1,
            quote: 'I absolutely love the qsfdsfdf dsdfs fsd sfd fds sd fsd sdfdsffdsf uality and service! This shop never disappoints, and the products always exceed my expectations.',
            name: 'Jane Smith',
            role: 'Happy Customer',
            avatar: 'https://picsum.photos/seed/testimonial/100',
        },
    ],
});
</script>

<template>
    <!-- Testimonial Section -->
    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-secondary py-12">
        <div class="container mx-auto">
            <h2 class="mb-8 text-center text-2xl font-bold text-foreground">What Our Customers Say</h2>
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 md:grid-cols-2">
                <div
                    v-for="(testimonial, index) in props.testimonials"
                    :key="testimonial.id || index"
                    class="col-span-full rounded-lg bg-background p-6 shadow"
                    :class="
                        props.testimonials.length === 1
                            ? 'col-span-full'
                            : props.testimonials.length === 2
                              ? 'col-span-1 md:col-span-1'
                              : 'col-span-1 lg:col-span-1'
                    "
                >
                    <p class="italic text-muted-foreground">"{{ testimonial.quote }}"</p>
                    <div class="mt-4 flex items-center">
                        <img
                            class="h-12 w-12 rounded-full object-cover"
                            :src="testimonial.avatar || 'https://picsum.photos/seed/testimonial/100'"
                            :alt="testimonial.name + ' avatar'"
                        />
                        <div class="ml-4">
                            <p class="font-bold text-card-foreground">{{ testimonial.name }}</p>
                            <p class="text-sm text-muted-foreground">
                                {{ testimonial.role || 'Happy Customer' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

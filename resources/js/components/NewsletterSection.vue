<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Toaster } from '@/components/ui/toast';
import { useToast } from '@/components/ui/toast/use-toast';
import { useForm } from '@inertiajs/vue3';
const { toast } = useToast();
const form = useForm({
    email: '', // Initialize the email field
});

const onSubmit = () => {
    form.post(route('newsletter.subscribe'), {
        preserveScroll: true, // Preserve the scroll position after submission
        onSuccess: () => {
            // Handle success
            toast({
                title: 'Subscription successful',
                description: 'You have successfully subscribed to our newsletter.',
                duration: 5000,
            });
        },
        onError: (errors) => {
            // Handle error
            toast({
                title: 'Subscription failed',
                description:
                    errors.email === 'The email has already been taken.'
                        ? 'This email is already subscribed to our newsletter.'
                        : 'There was an issue, try again later.',
                variant: 'destructive',
            });
        },
    });
};
</script>

<template>
    <!-- Newsletter Signup Section -->
    <Toaster />
    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-secondary py-12">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="flex flex-col items-center lg:flex-row">
                <div class="mb-8 w-full lg:mb-0 lg:w-1/2">
                    <h2 class="mb-4 text-2xl font-bold text-card-foreground">Stay in the Loop</h2>
                    <p class="mb-6 text-muted-foreground">Sign up for our newsletter to receive the latest news and exclusive offers.</p>
                    <form class="space-y-6" @submit.prevent="onSubmit">
                        <Input name="email" type="email" placeholder="Your email address" v-model="form.email" />
                        <Button :disabled="form.processing" type="submit">Subscribe</Button>
                    </form>
                </div>
                <div class="w-full lg:w-1/2 lg:pl-8">
                    <img src="https://picsum.photos/600/400?newsletter" alt="Newsletter" class="w-full rounded-lg object-cover" />
                </div>
            </div>
        </div>
    </section>
</template>

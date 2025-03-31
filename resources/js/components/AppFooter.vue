<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Drawer, DrawerClose, DrawerContent, DrawerDescription, DrawerFooter, DrawerHeader, DrawerTitle } from '@/components/ui/drawer';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const drawerOpen = ref(false);
const activeResource = ref('');

const openResource = (resource: string) => {
    activeResource.value = resource;
    drawerOpen.value = true;
};

const resourceContent = () => {
    switch (activeResource.value) {
        case 'faq':
            return {
                title: 'FAQ',
                description: 'Frequently Asked Questions content goes here. You can include common questions and answers that help your users.',
            };
        case 'blog':
            return {
                title: 'Blog',
                description: 'Our latest blog posts and articles are featured here. Stay updated with our news and insights.',
            };
        case 'privacy':
            return {
                title: 'Privacy Policy',
                description: 'This is our privacy policy. It explains how we collect, use, and protect your information.',
            };
        case 'terms':
            return {
                title: 'Terms & Conditions',
                description: 'These are the terms and conditions that govern your use of our site and services.',
            };
        default:
            return {
                title: '',
                description: '',
            };
    }
};
</script>

<template>
    <!-- Footer Section -->
    <footer class="bg-background py-12 text-muted-foreground dark:text-muted-foreground">
        <div class="container mx-auto max-w-7xl border-t border-border p-4">
            <div class="flex flex-col md:flex-row md:space-x-8">
                <!-- Branding Column -->
                <div class="mb-4 md:mb-0 md:w-1/4">
                    <h4 class="text-xl font-bold text-card-foreground">Ecommerce Shop</h4>
                    <p class="mt-2 text-sm text-muted-foreground">Your one-stop shop for amazing products.</p>
                </div>
                <!-- Quick Links Column -->
                <div class="mb-4 md:mb-0 md:w-1/4">
                    <h5 class="font-semibold text-card-foreground">Quick Links</h5>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <Link href="/" class="text-muted-foreground hover:text-foreground">Home</Link>
                        </li>
                        <li>
                            <Link href="/products" class="text-muted-foreground hover:text-foreground">Products</Link>
                        </li>
                        <li>
                            <Link href="/about" class="text-muted-foreground hover:text-foreground">About Us</Link>
                        </li>
                        <li>
                            <Link :href="route('orders.help')" class="text-muted-foreground hover:text-foreground">Contact</Link>
                        </li>
                    </ul>
                </div>
                <!-- Resources Column -->
                <div class="mb-4 md:mb-0 md:w-1/4">
                    <h5 class="font-semibold text-card-foreground">Resources</h5>
                    <ul class="mt-2 space-y-1">
                        <li>
                            <button type="button" @click="openResource('faq')" class="w-full text-left text-muted-foreground hover:text-foreground">
                                FAQ
                            </button>
                        </li>
                        <li>
                            <button type="button" @click="openResource('blog')" class="w-full text-left text-muted-foreground hover:text-foreground">
                                Blog
                            </button>
                        </li>
                        <li>
                            <button
                                type="button"
                                @click="openResource('privacy')"
                                class="w-full text-left text-muted-foreground hover:text-foreground"
                            >
                                Privacy Policy
                            </button>
                        </li>
                        <li>
                            <button type="button" @click="openResource('terms')" class="w-full text-left text-muted-foreground hover:text-foreground">
                                Terms &amp; Conditions
                            </button>
                        </li>
                    </ul>
                </div>
                <!-- Social Media Column -->
                <div class="md:w-1/4">
                    <h5 class="font-semibold text-card-foreground">Follow Us</h5>
                    <ul class="mt-2 flex space-x-4">
                        <li>
                            <a href="#" class="hover:text-foreground">
                                <!-- Facebook Icon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-facebook-icon lucide-facebook"
                                >
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-foreground">
                                <!-- Twitter Icon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-twitter-icon lucide-twitter"
                                >
                                    <path
                                        d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"
                                    />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-foreground">
                                <!-- YouTube Icon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-youtube-icon lucide-youtube"
                                >
                                    <path
                                        d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"
                                    />
                                    <path d="m10 15 5-3-5-3z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-foreground">
                                <!-- Instagram Icon -->
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-instagram-icon lucide-instagram"
                                >
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Copyright -->
            <div class="mt-8 border-t border-border pt-4 text-center text-sm text-muted-foreground">
                &copy; 2025 Ecommerce Shop. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Drawer for Resource Content -->
    <Drawer v-model:open="drawerOpen">
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle>{{ resourceContent().title }}</DrawerTitle>
                <DrawerDescription>{{ resourceContent().description }}</DrawerDescription>
            </DrawerHeader>
            <DrawerFooter>
                <DrawerClose>
                    <Button variant="outline">Close</Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>

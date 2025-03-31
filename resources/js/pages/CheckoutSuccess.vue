<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Order Confirmation', href: '#' }];

const props = defineProps<{
    order: any;
}>();

// Parse the addresses if they are stored as JSON strings.
const billingAddress = typeof props.order.billing_address === 'string' ? JSON.parse(props.order.billing_address) : props.order.billing_address;

const shippingAddress = typeof props.order.shipping_address === 'string' ? JSON.parse(props.order.shipping_address) : props.order.shipping_address;
</script>

<template>
    <Head title="Order Confirmation" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto px-4 py-12">
            <!-- Thank You Banner -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-primary md:text-4xl">Thank You for Your Order!</h1>
                <p class="mt-2 text-muted-foreground">Your order #{{ order.id }} has been successfully placed.</p>
            </div>

            <!-- Order Details Card -->
            <div class="rounded-lg bg-secondary p-6 shadow">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Order Summary -->
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-foreground">Order Summary</h2>
                        <p class="text-muted-foreground"><span class="font-semibold">Order ID:</span> {{ order.id }}</p>
                        <p class="text-muted-foreground"><span class="font-semibold">Date:</span> {{ order.created_at }}</p>
                        <p class="text-muted-foreground">
                            <span class="font-semibold">Subtotal:</span> ${{ (order.amount_subtotal / 100).toFixed(2) }}
                        </p>
                        <p class="text-muted-foreground"><span class="font-semibold">Tax:</span> ${{ (order.amount_tax / 100).toFixed(2) }}</p>
                        <p class="text-muted-foreground">
                            <span class="font-semibold">Shipping:</span> ${{ (order.amount_shipping / 100).toFixed(2) }}
                        </p>
                        <p class="text-muted-foreground">
                            <span class="font-semibold">Discount:</span> ${{ (order.amount_discount / 100).toFixed(2) }}
                        </p>
                        <p class="text-lg text-foreground"><span class="font-semibold">Total:</span> ${{ (order.amount_total / 100).toFixed(2) }}</p>
                    </div>

                    <!-- Addresses -->
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-foreground">Addresses</h2>
                        <!-- Billing Address -->
                        <div class="mb-4">
                            <h3 class="font-semibold text-foreground">Billing Address</h3>
                            <p class="text-muted-foreground">{{ billingAddress.name }}</p>
                            <p class="text-muted-foreground">{{ billingAddress.line1 }}</p>
                            <p v-if="billingAddress.line2" class="text-muted-foreground">
                                {{ billingAddress.line2 }}
                            </p>
                            <p class="text-muted-foreground">
                                {{ billingAddress.city }}, {{ billingAddress.state }} {{ billingAddress.postal_code }}
                            </p>
                            <p class="text-muted-foreground">{{ billingAddress.country }}</p>
                        </div>
                        <!-- Shipping Address -->
                        <div>
                            <h3 class="font-semibold text-foreground">Shipping Address</h3>
                            <p class="text-muted-foreground">{{ shippingAddress.name }}</p>
                            <p class="text-muted-foreground">{{ shippingAddress.line1 }}</p>
                            <p v-if="shippingAddress.line2" class="text-muted-foreground">
                                {{ shippingAddress.line2 }}
                            </p>
                            <p class="text-muted-foreground">
                                {{ shippingAddress.city }}, {{ shippingAddress.state }} {{ shippingAddress.postal_code }}
                            </p>
                            <p class="text-muted-foreground">{{ shippingAddress.country }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items Table -->
                <div class="mt-8">
                    <h2 class="mb-4 text-xl font-semibold text-foreground">Order Items</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-background">
                            <thead class="bg-muted">
                                <tr>
                                    <th class="border-b px-4 py-2 text-left text-foreground dark:border-border">Product</th>
                                    <th class="border-b px-4 py-2 text-left text-foreground dark:border-border">Description</th>
                                    <th class="border-b px-4 py-2 text-right text-foreground dark:border-border">Price</th>
                                    <th class="border-b px-4 py-2 text-right text-foreground dark:border-border">Quantity</th>
                                    <th class="border-b px-4 py-2 text-right text-foreground dark:border-border">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in order.items" :key="item.id" class="border-b dark:border-border">
                                    <!-- Combined Product Cell: Image + Name -->
                                    <td class="px-4 py-2 text-muted-foreground">
                                        <div class="flex items-center space-x-3">
                                            <img :src="item.image?.path" alt="Product Image" class="h-12 w-12 rounded object-cover" />
                                            <span>{{ item.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-muted-foreground">
                                        {{ item.description }}
                                    </td>
                                    <td class="px-4 py-2 text-right text-muted-foreground">${{ (item.price / 100).toFixed(2) }}</td>
                                    <td class="px-4 py-2 text-right text-muted-foreground">
                                        {{ item.quantity }}
                                    </td>
                                    <td class="px-4 py-2 text-right text-muted-foreground">${{ (item.amount_total / 100).toFixed(2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

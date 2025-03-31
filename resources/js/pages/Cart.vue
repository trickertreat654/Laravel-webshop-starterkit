<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="container mx-auto max-w-7xl py-4">
            <h1 class="mb-4 text-2xl font-bold text-foreground">Your Cart</h1>
            <Link :href="route('products.index')" class="mb-4 inline-block text-primary"> ← Continue Shopping </Link>

            <div v-if="cart && cart.items && cart.items.length > 0">
                <div class="space-y-4">
                    <div v-for="item in cart.items" :key="item.id" class="flex items-center rounded border border-border p-4">
                        <img :src="item.image?.path" alt="Product Image" class="mr-4 h-24 w-24 object-cover" />
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-card-foreground">
                                {{ item.product.name }}
                            </h2>
                            <p class="text-muted-foreground">
                                {{ item.product.description }}
                            </p>
                            <p class="mt-2 text-muted-foreground">Variant: {{ item.variant.color }} - {{ item.variant.size }}</p>
                            <div class="mt-2 flex items-center">
                                <!-- Decrement Button -->
                                <button class="rounded bg-muted px-2 py-1" @click="updateItemQuantity(item, item.quantity - 1)">-</button>
                                <span class="mx-2 text-foreground">{{ item.quantity }}</span>
                                <!-- Increment Button -->
                                <button class="rounded bg-muted px-2 py-1" @click="updateItemQuantity(item, item.quantity + 1)">+</button>
                            </div>
                            <p class="mt-2 font-bold text-card-foreground">Price: ${{ ((item.product.price * item.quantity) / 100).toFixed(2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-card-foreground">Total: ${{ (cartTotal / 100).toFixed(2) }}</h2>
                </div>

                <a :href="route('checkout.create')">
                    <button class="mt-4 rounded bg-primary px-4 py-2 text-primary-foreground">Checkout</button>
                </a>
            </div>

            <div v-else>
                <p class="text-muted-foreground">Your cart is empty.</p>
            </div>
        </div>
    </AppLayout>

    <!-- Alert Dialog for Removing an Item -->
    <AlertDialog v-model:open="isAlertOpen">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Remove Item?</AlertDialogTitle>
                <AlertDialogDescription>
                    Removing this item will set its quantity to zero and remove it from your cart. Are you sure you want to proceed?
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="cancelRemoval">Cancel</AlertDialogCancel>
                <AlertDialogAction @click="confirmRemoval">Yes, remove it</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script setup>
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    cart: Object,
});

// Compute the total cost of items in the cart (assuming product.price is in cents)
const cartTotal = computed(() => {
    if (!props.cart || !props.cart.items) return 0;
    return props.cart.items.reduce((sum, item) => sum + item.product.price * item.quantity, 0);
});

// Reactive variables for managing the alert dialog
const isAlertOpen = ref(false);
const pendingItem = ref(null);

// Function to update the quantity of a specific cart item.
const updateItemQuantity = (item, newQuantity) => {
    if (newQuantity < 0) return;

    // If newQuantity is 0, ask for confirmation to remove the item.
    if (newQuantity === 0) {
        pendingItem.value = item;
        isAlertOpen.value = true;
        return;
    }

    // Otherwise, update immediately.
    router.patch(
        route('items.update', item.id),
        { quantity: newQuantity },
        {
            preserveState: true,
            preserveScroll: true,
            async: true,
        },
    );
};

// Confirm removal for the pending item.
const confirmRemoval = () => {
    if (pendingItem.value) {
        router.patch(
            route('items.destroy', pendingItem.value.id),
            { quantity: 0 },
            {
                preserveState: true,
                preserveScroll: true,
                async: true,
            },
        );
    }
    isAlertOpen.value = false;
    pendingItem.value = null;
};

// Cancel removal; simply close the dialog.
const cancelRemoval = () => {
    isAlertOpen.value = false;
    pendingItem.value = null;
};
</script>

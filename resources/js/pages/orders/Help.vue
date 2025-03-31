<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem, type NavItem } from '@/types';
import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [{ title: 'Orders', href: '/orders/' }];

const customNavItems: NavItem[] = [
    { title: 'Orders', href: '/orders/orders' },
    { title: 'Help', href: '/orders/help' },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Help" />

        <SettingsLayout :sidebarNavItems="customNavItems" headerTitle="Help" headerDescription="Need assistance?">
            <div class="space-y-6">
                <HeadingSmall title="Help" description="We're here to support you." />
                <p class="text-gray-700 dark:text-gray-300">
                    If you require any assistance or have questions regarding your orders, please reach out to us at
                    <a href="mailto:contact@example.com" class="font-semibold text-blue-600 hover:underline dark:text-blue-400">
                        contact@example.com </a
                    >.
                </p>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>

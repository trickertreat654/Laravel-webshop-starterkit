<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem, type NavItem } from '@/types';

import OrdersTable from '@/components/OrdersTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Orders',
        href: '/orders/',
    },
];

const customNavItems: NavItem[] = [
    { title: 'Orders', href: '/orders/orders' },
    { title: 'Help', href: '/orders/help' },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Orders" />

        <SettingsLayout :sidebarNavItems="customNavItems" headerTitle="Orders" headerDescription="Manage your orders and view past transactions.">
            <div class="space-y-6">
                <HeadingSmall title="Orders" description="All past orders" />
                <OrdersTable />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>

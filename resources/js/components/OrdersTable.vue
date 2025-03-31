<script setup lang="ts">
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { usePage } from '@inertiajs/vue3';

// Accept orders as a prop, or default to orders from usePage
const props = defineProps<{ orders?: any[] }>();
const page = usePage();
const orders = props.orders ?? page.props.orders ?? [];
</script>

<template>
    <Table>
        <TableCaption>A list of your recent orders.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[100px]">Order</TableHead>
                <TableHead>Date</TableHead>
                <TableHead>Status</TableHead>
                <TableHead class="text-right">Amount</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="order in orders" :key="order.id">
                <TableCell class="font-medium">#{{ order.id }}</TableCell>
                <TableCell>{{ order.created_at }}</TableCell>
                <TableCell>
                    {{ order.status ? order.status : 'N/A' }}
                </TableCell>
                <TableCell class="text-right"> ${{ (order.amount_total / 100).toFixed(2) }} </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

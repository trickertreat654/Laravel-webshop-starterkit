<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Link } from '@inertiajs/vue3';
import { type PrimitiveProps } from 'radix-vue';
import type { HTMLAttributes } from 'vue';
import { buttonVariants, type ButtonVariants } from './ui/button'; // Adjust the import path as necessary

interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    class?: HTMLAttributes['class'];
    href?: string; // Optional href for the link
}

const props = withDefaults(defineProps<Props>(), {
    as: 'button',
    href: '#', // Default href to prevent errors if not provided
});
</script>

<template>
    <Link :href="props.href" :as="as" :as-child="asChild" :class="cn(buttonVariants({ variant, size }), props.class)">
        <slot />
    </Link>
</template>

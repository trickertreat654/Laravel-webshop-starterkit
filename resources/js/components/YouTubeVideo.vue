<script setup lang="ts">
defineProps<{
    videoId: string;
}>();
</script>

<template>
    <!-- YouTube Video Embed Section -->
    <section class="relative left-1/2 w-screen -translate-x-1/2 bg-background py-12">
        <div class="container mx-auto">
            <h2 class="mb-8 text-center text-2xl font-bold text-foreground">Watch Our Video</h2>
            <div class="mx-auto max-w-4xl">
                <div class="aspect-video rounded-lg bg-background shadow">
                    <iframe
                        class="h-full w-full rounded-lg"
                        :src="`https://www.youtube.com/embed/${videoId}`"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
    </section>
</template>

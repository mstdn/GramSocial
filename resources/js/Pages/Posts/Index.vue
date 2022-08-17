<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import Post from '../Shared/Post.vue';
import Cards from '../Shared/Cards.vue';
import Pagination from '../Shared/Pagination.vue';

let props = defineProps({
  posts: Object,
});


</script>
<template>
    <AppLayout title="Home">
        <template #header>
            Home Feed
        </template>

            <div class="px-4 mx-auto max-w-screen-sm">
                <Post />
            </div>


            <Cards v-bind:posts="posts" />

            <Pagination :links="posts.links" />


    </AppLayout>
</template>

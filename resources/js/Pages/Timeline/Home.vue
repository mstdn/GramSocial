<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import Post from '../Shared/Post.vue';
import Cards from '../Shared/Cards.vue';
import throttle from "lodash/throttle";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Pagination from '../Shared/Pagination.vue';
import PostModal from '../Shared/PostModal.vue';
import Empty from '../Shared/Empty.vue';
import Compose from '../Shared/Compose.vue';

let props = defineProps({
    posts: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(
    search,
    throttle(function (value) {
        Inertia.get(
            "/home",
            { search: value },
            {
                preserveState: true,
                replace: true,
                preserveScroll: true
            }
        );
    }, 500)
);
</script>
<template>
    <AppLayout title="Home">
        <template #header>
            <div class="dropdown dropdown-bottom">
                        <label tabindex="0" class="btn btn-primary btn-sm">Search</label>
                        <div tabindex="0"
                            class="dropdown-content card card-compact w-64 p-2 shadow bg-gray-900 text-white">
                            <div class="card-body">
                                <h3 class="card-title">Search Posts</h3>
                                <input v-model="search" type="text" class="input input-bordered input-info w-full"
                                    placeholder="Search.." />
                            </div>
                        </div>
                    </div>
        </template>

            <!--<Post />-->
            <Compose />

            <div v-if="posts.total === 0">
                <Empty />
            </div>

            <Cards v-bind:posts="posts" />
            <Pagination :links="posts.links" />

    </AppLayout>
</template>

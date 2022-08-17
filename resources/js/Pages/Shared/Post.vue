<template>
    <div>
        <!-- Put this part before </body> tag -->
        <form @submit.prevent="submit">

            <h3 class="font-bold text-lg dark:text-white">Share something {{ $page.props.user.name }}</h3>
            <div class="pt-4">

                <div class="form-control py-2">
                    <textarea v-model="form.description" id="description" name="description"
                        class="textarea textarea-primary dark:bg-gray-800 dark:text-white"
                        placeholder="How meow are you?"></textarea>
                    <p class="mt-2 text-sm text-gray-100">{{ characterCount }}/500</p>
                    <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 mt-1">
                    </div>
                </div>

                <div class="form-control pt-2">
                    <div class="flex flex-col w-full lg:flex-row">
                        <div class="flex justify-start">
                            <label>
                                <div class="
                                    text-red-400
                                    hover:bg-red-50
                                    dark:hover:bg-dim-800
                                    rounded-full
                                    p-2
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                        <path d="M20.4 14.5L16 10 4 20" />
                                    </svg>
                                </div>
                                <input name="image" id="image" type="file" @input="form.image = $event.target.files[0]"
                                    style="display: none" />

                            </label>

                            <label>
                                <div class="
                                text-red-400
                                hover:bg-red-50
                                dark:hover:bg-dim-800
                                rounded-full
                                p-2
                            ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                                        <line x1="7" y1="2" x2="7" y2="22"></line>
                                        <line x1="17" y1="2" x2="17" y2="22"></line>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <line x1="2" y1="7" x2="7" y2="7"></line>
                                        <line x1="2" y1="17" x2="7" y2="17"></line>
                                        <line x1="17" y1="17" x2="22" y2="17"></line>
                                        <line x1="17" y1="7" x2="22" y2="7"></line>
                                    </svg>
                                </div>
                                <input name="video" id="video" type="file" @input="form.video = $event.target.files[0]"
                                    style="display: none" />

                            </label>
                        </div>
                    </div>

                </div>
                <div v-if="form.errors.image" v-text="form.errors.image" class="text-red-500 ml-3"></div>
                <div v-if="form.errors.video" v-text="form.errors.video" class="text-red-500 ml-3"></div>
                <div v-if="form.errors.status" v-text="form.errors.status" class="text-red-500 ml-3"></div>
                <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 ml-3"></div>
            </div>
            <div class="modal-action pb-10">
                <div class="justify-start">
                    <div class="form-control">
                        <label class="label cursor-pointer mt-1">
                            <span class="label-text dark:text-white mr-2">NSFW?</span>
                            <input v-model="form.nsfw" type="checkbox" name="nsfw" id="nsfw" class="checkbox" />
                        </label>
                    </div>
                </div>
                <div class="justify-start">
                    <select v-model="form.status" name="status" id="status"
                        class="select select-bordered w-full max-w-xs">
                        <option disabled value="">Status</option>
                        <option value="public" selected>Public</option>
                        <option value="unlisted">Unlisted</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <button type="submit" :disabled="form.processing" class="btn btn-success gap-2">
                    Publish
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { computed } from 'vue';

const characterCount = computed(() => {
    return form.description.length
})

let form = useForm({
    description: "",
    video: "",
    image: "",
    nsfw: "",
    status: "",
});

let submit = () => {
    form.post("/home", {
        forceFormData: true,
        onSuccess: () => form.reset("description", "video", "nsfw", "image"),
    });
};
</script>

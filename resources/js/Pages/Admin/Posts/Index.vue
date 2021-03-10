<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <breeze-alert
                                v-if="$page.props.flash.message"
                                :message="$page.props.flash.message"
                            ></breeze-alert>
                            <div class="flex justify-between items-center text-center mb-3">
                                <form @submit.prevent="submit">
                                    <breeze-input-search v-model="form.query" />
                                </form>

                                <inertia-link :href="route('admin.posts.create')">
                                    <breeze-button>Create Post</breeze-button>
                                </inertia-link>
                            </div>
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr v-show="showData">
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Post
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Status
                                            </th>
                                            <th
                                                scope="col"
                                                class="relative px-6 py-3"
                                            >
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr
                                            v-for="(post, key) in posts.data"
                                            :key="key"
                                            class="hover:bg-gray-50"
                                        >
                                            <td class="px-6 py-4 ">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img
                                                            class="h-10 w-10 rounded-full"
                                                            :src="post.user.photo_icon"
                                                            alt=""
                                                        >
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-semibold tracking-wider text-gray-900">
                                                            {{ post.title }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            <i
                                                                class="fa fa-user text-gray-300"
                                                                aria-hidden="true"
                                                            ></i> {{ post.user.name }}
                                                            <i
                                                                class="fa fa-clock-o text-gray-300"
                                                                aria-hidden="true"
                                                            ></i> {{ formatDate(post.created_at) }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <breeze-badge :status="post.status" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <inertia-link
                                                    :href="route('admin.posts.show', post)"
                                                    class="mr-2 text-indigo-600 hover:text-indigo-900"
                                                >
                                                    <button>Show</button>
                                                </inertia-link>
                                                <inertia-link
                                                    :href="route('admin.posts.edit', post)"
                                                    class="mr-2 text-indigo-600 hover:text-indigo-900"
                                                >
                                                    <button>Edit</button>
                                                </inertia-link>

                                                <button
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                    @click="destroy(post)"
                                                >Delete</button>
                                            </td>
                                        </tr>
                                        <tr
                                            v-show="!showData"
                                            class="p-20"
                                        >
                                            <td
                                                colspan="3"
                                                class="px-6 py-4 whitespace-nowrap lowercase animate-pulse text-center tracking-widest"
                                            >
                                                Data Not Found
                                            </td>
                                        </tr>

                                        <!-- More items... -->
                                    </tbody>
                                </table>
                                <Pagination :links="posts.links"></Pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import Pagination from "@/Components/Pagination";
import BreezeButton from "@/Components/Button";
import BreezeAlert from "@/Components/Alert";
import BreezeInputSearch from "@/Components/InputSearch";
import BreezeBadge from "@/Components/Badge";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Pagination,
        BreezeButton,
        BreezeAlert,
        BreezeInputSearch,
        BreezeBadge,
    },

    props: {
        posts: Object,
    },

    computed: {
        showData() {
            return this.posts.data.length ? true : false;
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                query: "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.get(route("admin.posts.index"), {
                preserveState: true,
                preserveScroll: true,
                only: ["posts"],
            });
        },

        destroy(post) {
            this.$inertia.delete(route("admin.posts.delete", post), {
                onBefore: () => confirm("Are you sure?"),
                preserveScroll: true,
            });
        },
    },
};
</script>

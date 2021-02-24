<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tag</h2>
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

                                <inertia-link :href="route('admin.tags.create')">
                                    <breeze-button>Create Tag</breeze-button>
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
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                            >
                                                Slug
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
                                            v-for="(tag, key) in tags.data"
                                            :key="key"
                                        >
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ tag.name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ tag.slug }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <inertia-link
                                                    :href="route('admin.tags.edit', tag)"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    <button>Edit</button>
                                                </inertia-link>

                                                <button
                                                    class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                    @click="destroy(tag)"
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
                                <Pagination :links="tags.links"></Pagination>
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

export default {
    components: {
        BreezeAuthenticatedLayout,
        Pagination,
        BreezeButton,
        BreezeAlert,
        BreezeInputSearch,
    },

    props: {
        tags: Object,
    },

    computed: {
        showData() {
            return this.tags.data.length ? true : false;
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
            this.form.get(route("admin.tags.index"), {
                preserveState: true,
                preserveScroll: true,
                only: ["tags"],
            });
        },

        destroy(tag) {
            this.$inertia.delete(route("admin.tags.delete", tag), {
                onBefore: () => confirm("Are you sure?"),
            });
        },
    },
};
</script>

<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Team</h2>
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

                                <inertia-link :href="route('admin.teams.create')">
                                    <breeze-button>Create Team</breeze-button>
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
                                            v-for="(team, key) in teams.data"
                                            :key="key"
                                            class="hover:bg-gray-50"
                                        >
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ team.name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ team.slug }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <inertia-link
                                                    :href="route('admin.teams.edit', team)"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    <button>Edit</button>
                                                </inertia-link>

                                                <button
                                                    class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                    @click="destroy(team)"
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
                                <Pagination :links="teams.links"></Pagination>
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
        teams: Object,
    },

    computed: {
        showData() {
            return this.teams.data.length ? true : false;
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
            this.form.get(route("admin.teams.index"), {
                preserveState: true,
                preserveScroll: true,
                only: ["teams"],
            });
        },

        destroy(team) {
            this.$inertia.delete(route("admin.teams.delete", team), {
                onBefore: () => confirm("Are you sure?"),
            });
        },
    },
};
</script>

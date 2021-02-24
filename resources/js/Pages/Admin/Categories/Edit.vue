<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Category</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-2">
                                <breeze-label for="name">Name</breeze-label>
                                <breeze-input
                                    id="name"
                                    type="text"
                                    v-model="form.name"
                                    autocomplete="off"
                                    class="w-1/2"
                                ></breeze-input>
                                <breeze-input-error
                                    v-if="errors.name"
                                    :message="errors.name"
                                />
                            </div>
                            <breeze-button
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >Update</breeze-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import BreezeButton from "@/Components/Button";
import BreezeLabel from "@/Components/Label";
import BreezeInput from "@/Components/Input";
import BreezeInputError from "@/Components/InputError";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        BreezeLabel,
        BreezeInput,
        BreezeInputError,
    },

    props: {
        errors: Object,
        category: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: "",
            }),
        };
    },

    mounted() {
        this.form = this.$inertia.form(Object.assign({}, this.category));
    },

    methods: {
        submit() {
            this.form.put(this.route("admin.categories.update", this.category), {
                preserveState: true,
                preserveScroll: true,
            });
        },
    },
};
</script>

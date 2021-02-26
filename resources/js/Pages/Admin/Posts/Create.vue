<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Team</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-2">
                                <breeze-label for="title">Title</breeze-label>
                                <breeze-input
                                    id="title"
                                    type="text"
                                    v-model="form.title"
                                    autocomplete="off"
                                    class="w-full"
                                ></breeze-input>
                                <breeze-input-error
                                    v-if="errors.title"
                                    :message="errors.title"
                                />
                            </div>
                            <div class="mb-2">
                                <breeze-label for="thumbnail">Thumbnail</breeze-label>
                                <input
                                    type="file"
                                    ref="thumbnail"
                                    accept="image/*"
                                    @change="updatePhotoPreview"
                                >
                                <div v-show="preview">
                                    <span
                                        class="block w-20 h-20 rounded-full"
                                        :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"
                                    >
                                    </span>
                                </div>
                                <breeze-input-error
                                    v-if="errors.thumbnail"
                                    :message="errors.thumbnail"
                                />
                            </div>
                            <div class="mb-2">
                                <breeze-label for="body">Body</breeze-label>
                                <ckeditor
                                    :editor="editor"
                                    v-model="form.body"
                                    :config="editorConfig"
                                    class="w-full"
                                ></ckeditor>
                                <breeze-input-error
                                    v-if="errors.body"
                                    :message="errors.body"
                                />
                            </div>
                            <div class="mb-2">
                                <breeze-label for="category">Category</breeze-label>
                                <select
                                    v-model="form.category"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(category, key) in categories"
                                        :value="key"
                                        :key="key"
                                    >{{ category }}</option>
                                </select>
                                <breeze-input-error
                                    v-if="errors.category"
                                    :message="errors.category"
                                />
                            </div>
                            <div class="mb-2">
                                <breeze-label for="tag">Tag</breeze-label>
                                <select
                                    multiple
                                    v-model="form.tag"
                                    class="w-full"
                                >
                                    <option
                                        v-for="(tag, key) in tags"
                                        :value="key"
                                        :key="key"
                                    >{{ tag }}</option>
                                </select>
                                <breeze-input-error
                                    v-if="errors.tag"
                                    :message="errors.tag"
                                />
                            </div>
                            <div class="mb-2">
                                <breeze-label for="status">Status</breeze-label>
                                <select
                                    v-model="form.status"
                                    class="w-full"
                                >
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                                <breeze-input-error
                                    v-if="errors.status"
                                    :message="errors.status"
                                />
                            </div>
                            <breeze-button
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >Submit</breeze-button>
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

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
        categories: Object,
        tags: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                title: "",
                thumbnail: null,
                body: "<p>Content of the editor.</p>",
                status: "",
                category: "",
                tag: "",
            }),
            photoPreview: "",
            preview: "",

            editor: ClassicEditor,
            editorConfig: {
                // toolbar: ["bold", "italic", "|", "link"],
            },
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("admin.posts.store"));
        },
        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.preview = e.target.result;
            };
            this.form.thumbnail = this.$refs.thumbnail.files[0];
            console.log(this.form.thumbnail);
            reader.readAsDataURL(this.$refs.thumbnail.files[0]);
        },
    },
};
</script>

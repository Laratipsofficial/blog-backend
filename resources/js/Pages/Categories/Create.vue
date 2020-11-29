<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Add Category
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <form @submit.prevent="saveCategory">
            <div>
              <jet-label for="name"
                         value="Name" />
              <jet-input id="name"
                         type="text"
                         class="mt-1 block w-full"
                         v-model="form.name"
                         autocomplete="name" />
              <jet-input-error :message="form.error('name')"
                               class="mt-2" />
            </div>

            <!-- slug -->
            <div class="mt-4">
              <jet-label for="slug"
                         value="Slug" />
              <jet-input id="slug"
                         type="text"
                         class="mt-1 block w-full"
                         v-model="form.slug"
                         autocomplete="slug" />
              <jet-input-error :message="form.error('slug')"
                               class="mt-2" />
            </div>

            <div class="mt-4">
              <jet-action-message :on="form.recentlySuccessful"
                                  class="mr-3">
                Saved.
              </jet-action-message>

              <jet-button :class="{ 'opacity-25': form.processing }"
                          :disabled="form.processing">
                Save
              </jet-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetButton from "@/Jetstream/Button";
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetActionMessage from "@/Jetstream/ActionMessage";
import { strSlug } from "@/helpers.js";

export default {
  components: {
    AppLayout,
    JetButton,
    JetLabel,
    JetInput,
    JetInputError,
    JetActionMessage,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        slug: "",
      }),
    };
  },

  methods: {
    saveCategory() {
      this.form.post(route('categories.store'));
    }
  },

  watch: {
    "form.name"(name) {
      this.form.slug = strSlug(name);
    }
  }
};
</script>

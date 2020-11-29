<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Categories
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <jet-button :href="route('categories.create')">Add new</jet-button>

        <div class="mt-4 p-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <AppTable :headers="headers">
            <tr v-for="category in categories.data"
                :key="category.id">
              <td>{{ category.name }}</td>
              <td>
                <div class="flex items-center justify-end space-x-2">
                  <EditBtn :url="route('categories.edit', {category: category.id})" />
                  <DeleteBtn :url="route('categories.destroy', {category: category.id})"
                             module-name="category" />
                </div>
              </td>
            </tr>
          </AppTable>

          <div class="mt-4">
            <SimplePagination :prev-url="categories.links.prev"
                              :next-url="categories.links.next" />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import EditBtn from "@/Components/EditBtn";
import DeleteBtn from "@/Components/DeleteBtn";
import SimplePagination from "@/Components/SimplePagination";
import AppTable from "@/Components/Table";
import JetButton from "@/Jetstream/Button";

export default {
  props: {
    categories: {},
  },

  components: {
    AppLayout,
    EditBtn,
    DeleteBtn,
    SimplePagination,
    AppTable,
    JetButton,
  },

  computed: {
    headers() {
      return [
        {
          name: "Name",
        },
        {
          name: "Action",
          class: "text-right",
        }
      ];
    },
  },
};
</script>

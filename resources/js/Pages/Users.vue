<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Table from '@/Components/Table.vue'
import { data } from 'autoprefixer'
import { onMounted, ref } from 'vue'

let tableData = ref([]);

let text = ref('Loading ...')

let getUsersList = (sort = 'default') => {
  tableData.value = [];
  axios.get('/axios/users-list?sort=' + sort)
      .then(response => {
        if (response?.data?.data) {
          tableData.value = response.data.data;
        } else {
          text.value = 'Empty';
        }
      })
      .catch(e => {
        text.value = 'Error';
      })
}

let selectSort = (event) => {
  getUsersList(event.target.value);
}

onMounted(() => {
  getUsersList();
});

</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sort By</label>
                    <select @change="selectSort($event)" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option value="default" selected>Default</option>
                      <option value="lessons">Lessons</option>
                    </select>
                  </div>
                  <Table v-if="tableData.length > 0" :data="tableData" :headers="['Name', 'Email', 'Progress', 'Rank']"></Table>
                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-else>{{text}}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

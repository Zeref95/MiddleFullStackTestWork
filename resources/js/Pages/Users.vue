<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Table from '@/Components/Table.vue'

import { onMounted, ref } from 'vue'
import Modal from '@/Components/Modal.vue'

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
let tableHeaders = ['Name', 'Email', 'Progress', 'Rank'];

let selectSort = (event) => {
  getUsersList(event.target.value);
}

onMounted(() => {
  getUsersList();
});

let userLessons = ref([]);
let openLessonsModal = (userId) => {
  modalUserId.value = userId;
  axios.get('/axios/user-lessons/' + userId)
      .then(response => {
        if (response?.data) {
          userLessons.value = response.data;
        }
      })
}
let modalUserId = ref(null);
const closeModal = () => {
  modalUserId.value = null;
};

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

                  <table v-if="tableData.length > 0" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr v-if="tableHeaders">
                      <th v-for="header in tableHeaders" scope="col" class="px-6 py-3">
                        {{header}}
                      </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, i) in tableData"  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                      <template v-for="(col, key) in row">
                        <template v-if="key === 'id'"></template>
                        <td v-else class="px-6 py-4" @click="openLessonsModal(row.id)">
                          {{col}}
                        </td>
                      </template>
                    </tr>
                    </tbody>
                  </table>

                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-else>{{text}}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal :show="modalUserId" @close="closeModal">
      <ul v-if="userLessons">
        <li v-for="name in userLessons">{{name}}</li>
      </ul>
    </Modal>
</template>

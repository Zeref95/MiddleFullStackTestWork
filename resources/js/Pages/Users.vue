<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Table from '@/Components/Table.vue'
import { data } from 'autoprefixer'
import { onMounted, ref } from 'vue'

let tableData = ref([]);

onMounted(() => {
  axios.get('/axios/users-list')
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
});

let text = ref('Loading ...')

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
                  <Table v-if="tableData.length > 0" :data="tableData" :headers="['Name', 'Email', 'Progress', 'Rank']"></Table>
                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-else>{{text}}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

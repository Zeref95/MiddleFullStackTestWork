<script setup>
defineProps(['headers', 'data']);


</script>

<template>

  <div class="relative overflow-x-auto">
    <table v-if="data" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr v-if="headers">
        <th v-for="header in headers" scope="col" class="px-6 py-3">
          {{header}}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(row, i) in data"  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
        <template v-for="col in row">
          <td class="px-6 py-4">
            {{col}}
          </td>
        </template>
      </tr>
      </tbody>
    </table>
  </div>

</template>
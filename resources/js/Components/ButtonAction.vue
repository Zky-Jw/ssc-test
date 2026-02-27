<script setup>
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
  item: Object,
  editRoute: {
    type: String,
    default: '',
  },
  form: Object,
  deleteRoute: {
    type: String,
    default: '',
  },
  printRoute: {
    type: String,
    default: '',
  },
  showRoute: {
    type: String,
    default: '',
  },
  documentRoute: {
    type: String,
    default: '',
  },
  reminderRoute : {
    type: String,
    default: '',
  }
});

function destroy(id) {
  if (confirm("Are you sure you want to Delete")) {
    props.form.delete(route(props.deleteRoute, id));
  }
}

function submitNotify(id) {
  router.post(route('ticket.notifyOperator', id))
}
</script>

<template>
  <div v-if="editRoute != ''" class="hs-tooltip inline-block [--placement:bottom]">
    <button class="py-2 text-sm rounded mr-2 hs-tooltip-toggle" :href="route(editRoute, item.id)">
      <a :href="route(editRoute, item.id)">
        <Icon class="text-2xl pr-1 hover:text-primary-100" icon="tabler:edit" />
      </a>
      <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible tooltip-ssc" role="tooltip">
        Edit
      </span>
    </button>
  </div>
  <div v-if="deleteRoute != ''" class="hs-tooltip inline-block [--placement:bottom]">
    <button class="py-2 text-sm rounded mr-2 hs-tooltip-toggle" @click="destroy(item.id)">
      <Icon class="text-2xl pr-1 hover:text-primary-100" icon="iconamoon:trash" />
      <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible tooltip-ssc" role="tooltip">
        Delete
      </span>
    </button>
  </div>
  <div v-if="showRoute != ''" class="hs-tooltip inline-block [--placement:bottom]">
    <button class="py-2 text-sm rounded mr-2 hs-tooltip-toggle">
      <a :href="route(showRoute, item.id)">
        <Icon class="text-2xl pr-1 hover:text-primary-100" icon="lucide:eye" />
      </a>
      <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible tooltip-ssc" role="tooltip">
        Show
      </span>
    </button>
  </div>
  <div v-if="printRoute != ''" class="hs-tooltip inline-block [--placement:bottom]">
    <button class="py-2 text-sm rounded mr-2 hs-tooltip-toggle">
      <a :href="route(printRoute, item.id)" target="_blank">
        <Icon class="text-2xl pr-1 hover:text-primary-100"
          icon="streamline:computer-printer-scan-device-electronics-printer-print-computer" />
      </a>
      <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible tooltip-ssc" role="tooltip">
        Print
      </span>
    </button>
  </div>
  <div v-if="documentRoute != ''" class="hs-tooltip inline-block [--placement:bottom]">
    <button class="py-2 text-sm rounded mr-2 hs-tooltip-toggle" v-if="item.status !== 'closed'">
      <a :href="route(documentRoute, item.id)">
        <Icon class="text-2xl pr-1 hover:text-primary-100" icon="lucide:clipboard-paste" />
      </a>
      <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible tooltip-ssc" role="tooltip">
        Generate Document
      </span>
    </button>
  </div>
  <div v-if="reminderRoute != ''" class="hs-tooltip inline-block [--placement:bottom]">
    <button class="py-2 text-sm rounded mr-2 hs-tooltip-toggle" v-if="item.isLate" @click="submitNotify(item.id)">
      <a>
        <Icon class="text-2xl pr-1 hover:text-primary-100" icon="line-md:bell" />
      </a>
      <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible tooltip-ssc" role="tooltip">
        Reminder
      </span>
    </button>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import VueMultiselect from 'vue-multiselect'
import axios from 'axios'
import { debounce } from 'lodash'

const props = defineProps({
  placeholder: String,
  option: {
    type : Array,
    default : () => []
  },
  name: String,
  value: [Object, String, Number],
  apiUrl: String,
  apiField: String,
})

const emit = defineEmits(['update:value', 'selected'])

const isLoading = ref(false)
const options = ref([])
const selectedOption = ref(null)
const additionalLabel = ref({})

// Check if this is a student selection
const isStudentType = computed(() => props.name === 'student')

// Decide if we're doing internal search or not
const internalSearch = computed(() => !props.apiUrl)

function mapOptions(optionsArray) {
  if (!Array.isArray(optionsArray)) return []

  if (isStudentType.value) {
    additionalLabel.value = {}
    optionsArray.forEach(item => {
      additionalLabel.value[item.per_num] = item.person
    })
    return optionsArray.map(item => item.per_num)
  } else {
    return optionsArray.map(item => {
      let label
      switch (props.name) {
        case 'services': label = item.service; break
        case 'person': label = item.person; break
        case 'units': label = item.unit; break
        case 'roles' : label = item.name; break
        case 'title': label = item.title; break
        case 'order':
        case 'time': label = item.category; break
        default: label = item.name; break
      }
      return { id: item.id, name: label }
    }).filter(Boolean)
  }
}

const performSearch = debounce(async (query) => {
  if (!props.apiUrl) return
  isLoading.value = true

  try {
    const params = { search: query }
    if (props.apiField) params.field = props.apiField

    const response = await axios.get(props.apiUrl, { params })
    if (response.data?.code === 200) {
      options.value = mapOptions(response.data.data)
      matchSelectedWithOptions()
    } else {
      options.value = []
    }
  } catch (e) {
    options.value = []
  } finally {
    isLoading.value = false
  }
}, 300)

const formatLabel = (option) => {
  if (option == null) return ''
  return isStudentType.value
    ? `${option} - ${additionalLabel.value[option] || ''}`
    : option.name
}

const matchSelectedWithOptions = () => {
  if (props.value == null) {
    selectedOption.value = null
    return
  }

  if (isStudentType.value) {
    // direct match (string)
    const exists = options.value.includes(props.value)
    selectedOption.value = exists ? props.value : null
  } else {
    const found = options.value.find(opt => opt.id === props.value?.id)
    selectedOption.value = found || null
  }
}

const onSelect = (val) => {
  emit('selected', val)
}

watch(() => props.value, () => {
  matchSelectedWithOptions()
}, { immediate: true, deep: true })

watch(() => selectedOption.value, (newVal) => {
  emit('update:value', newVal)
  if (newVal) emit('selected', newVal)
})

onMounted(() => {
  if (internalSearch.value) {
    options.value = mapOptions(props.option)
    matchSelectedWithOptions()
  } else {
    performSearch('')
  }
})
</script>

<template>
  <VueMultiselect
    class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    v-model="selectedOption"
    :name="name"
    :options="options"
    :custom-label="formatLabel"
    :placeholder="placeholder"
    :track-by="isStudentType ? undefined : 'id'"
    :internal-search="internalSearch"
    :loading="isLoading"
    :preserve-search="true"
    @search-change="performSearch"
    @select="onSelect"
  >
    <template #noResult>
      <span class="multiselect__option">Tidak ada data yang ditemukan</span>
    </template>

    <template #spinner>
      <div class="multiselect__spinner"></div>
    </template>

    <!-- Student custom label -->
    <template v-if="isStudentType" #singleLabel="{ option }">
      <div class="selected-item">
        <span class="mr-2">{{ option }}</span>
      </div>
    </template>

    <template v-if="isStudentType" #option="{ option }">
      <div class="option-item">
        <span>{{ option }} - {{ additionalLabel[option] }}</span>
      </div>
    </template>
  </VueMultiselect>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style>
.multiselect__option--highlight {
  background: rgb(131 74 86);
}
.multiselect__spinner {
  background-color: white;
  height: 2rem;
}
.multiselect__spinner:before,
.multiselect__spinner:after {
  border-color: rgb(131 74 86) transparent transparent;
}
.option-item {
  display: flex;
  align-items: center;
}
</style>

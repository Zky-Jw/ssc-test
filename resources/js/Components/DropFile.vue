
<script setup>
import { ref } from 'vue'

const props = defineProps({
  modelValue: { type: Array, default: () => [] }
})

const emit = defineEmits(['update:modelValue'])

const isDragging = ref(false)
const files = ref([...props.modelValue])
const fileInput = ref(null)

const updateValue = (newFiles) => {
  emit('update:modelValue', newFiles)
}

const remove = (i) => {
  files.value.splice(i, 1)
  updateValue(files.value)
}

const onChange = () => {
  files.value.push(...fileInput.value.files)
  updateValue(files.value)
}

const dragover = (e) => {
  e.preventDefault()
  isDragging.value = true
}

const dragleave = () => {
  isDragging.value = false
}

const drop = (e) => {
  e.preventDefault()
  fileInput.value.files = e.dataTransfer.files
  onChange()
  isDragging.value = false
}

const generateURL = (file) => {
  let fileSrc = URL.createObjectURL(file)
  setTimeout(() => {
    URL.revokeObjectURL(fileSrc)
  }, 1000)
  return fileSrc
}
</script>


<template>
  <div class="main">
    <div class="dropzone-container" @dragover="dragover" @dragleave="dragleave" @drop="drop"
      :style="isDragging && 'border-color: green;'">
      <input type="file" multiple name="file" id="fileInput" class="hidden-input" @change="onChange" ref="fileInput"
        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" />

      <label for="fileInput" class="file-label">
        <Icon icon="tdesign:attach" class="block m-auto text-7xl text-gray-300 mb-2"/>
        <div class="text-center text-base" v-if="isDragging">Release to drop files here.</div>
        <div class="text-center text-base" v-else>Drop files here or <u>click here</u> to upload.</div>
        <div class="text-center text-sm text-gray-400 mt-2">Catatan : Maksimal ukuran file adalah 5 MB</div>
      </label>
      <div class="preview-container flex flex-wrap mt-4" v-if="files.length">
        <div v-for="file in files" :key="file.name" class="preview-card rounded flex-1 m-1 max-w-max">
          <div>
            <img class="preview-img" :src="generateURL(file)" />
            <p class="text-sm">
              {{ file.name }}
            </p>
          </div>
          <div>
            <button class="ml-2" type="button" @click="remove(files.indexOf(file))" title="Remove file">
              <Icon icon="ph:x-bold" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



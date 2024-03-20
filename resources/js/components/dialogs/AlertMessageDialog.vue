
<script setup>
import { computed } from 'vue'

const props = defineProps({
  isVisible: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: '',
  },
  message: {
    type: String,
    default: '',
  },
})

const emit = defineEmits([
  'onOk',
])

const updateModelValue = val => {
  emit('onOk', val)
}

// Define a computed property to map titles to colors and icons
const config = computed(() => {
  const config = {
    'Berhasil!': { color: 'success', icon: 'mdi-check' },
    'Gagal!': { color: 'error', icon: 'mdi-alert' },
  }

  
  return config[props.title] || { color: 'info', icon: 'mdi-information' } // default color & icon
})
</script>

<template>
  <VDialog
    max-width="500"
    :model-value="props.isVisible"
    @update:model-value="updateModelValue"
  >
    <VCard>
      <VCardText class="text-center px-10 py-6">
        <VBtn
          icon
          variant="outlined"
          :color="config.color"
          class="my-4"
          style=" block-size: 88px;inline-size: 88px; pointer-events: none;"
        >
          <span class="text-3xl">
            <VIcon :icon="config.icon" />
          </span>
        </VBtn>

        <h1 class="text-h4 mb-4">
          {{ props.title }}
        </h1>

        <p>{{ props.message }}</p>

        <VBtn
          :color="config.color"
          @click="updateModelValue(false)"
        >
          Ok
        </VBtn>
      </VCardText>
    </VCard>
  </VDialog>
</template>

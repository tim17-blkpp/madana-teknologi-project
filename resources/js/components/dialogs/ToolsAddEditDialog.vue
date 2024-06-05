<script setup>
import { useToolStore } from '@/pages/dashboard/tools/useToolStore'
import { ref, toRaw, watch } from 'vue'

const props = defineProps({
  toolDetails: {
    type: Object,
    required: false,
    default: () => ({
      name: '',
      icon_upload: '',
      show_on_landing_page: '0',
    }),
  },
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
})

const emit = defineEmits([
  'submit',
  'update:isDialogVisible',
  'formSubmitted',
  'alertMsg',
])

const toolDetails = ref(structuredClone(toRaw(props.toolDetails)))

watch(props, () => {
  toolDetails.value = structuredClone(toRaw(props.toolDetails))
})

const formSubmit = async () => {
  const store = useToolStore()


  if (!toolDetails.value.id) {
    // Category baru
    try {
    // Call the createTool action from the store
      const response = await store.createTool(toolDetails.value)

      // Check the status of the HTTP response
      if (response.status === 201) {
      // Category created successfully
        emit('submit', toolDetails.value)
        emit('update:isDialogVisible', false)

        // Emit an event to notify the parent component about the successful submission
        emit('formSubmitted', true)
        emit('alertMsg', ['Berhasil!', response.data.message])
      } else {
      // Handle other response statuses
        console.error('Error creating Category. Unexpected status:', response.status)
      }
    } catch (error) {
    // Handle any errors, e.g., display an error message
      console.error('Error creating Category:', error)
    }
  }
  else {
    // edit Category
    try {
    // Call the updateTool action from the store
      const response = await store.updateTool(toolDetails.value.id, toolDetails.value)

      // Check the status of the HTTP response
      if (response.status === 200) {
      // Category updated successfully
        emit('submit', toolDetails.value)
        emit('update:isDialogVisible', false)

        // Emit an event to notify the parent component about the successful submission
        emit('formSubmitted', true)
        emit('alertMsg', ['Berhasil!', response.data.message])
      } else {
      // Handle other response statuses
        console.error('Error updating Category. Unexpected status:', response.status)
      }
    } catch (error) {
    // Handle any errors, e.g., display an error message
      console.error('Error creating Category:', error)
    }
  }

}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 650"
    :model-value="props.isDialogVisible"
    @update:model-value="val => $emit('update:isDialogVisible', val)"
  >
    <VCard class="pa-5 pa-sm-8">
      <!-- 👉 dialog close btn -->
      <DialogCloseBtn
        variant="text"
        size="small"
        @click="$emit('update:isDialogVisible', false)"
      />

      <!-- 👉 Title -->
      <VCardItem class="text-start">
        <VCardTitle class="text-2xl mb-3">
          {{ props.toolDetails.name ? 'Edit Data' : 'Tambah Data' }}
        </VCardTitle>
        <VCardSubtitle>
          {{ props.toolDetails.name ? 'Edit detail Data' : 'Tambah detail Data' }}
        </VCardSubtitle>
      </VCardItem>

      <VCardText class="mt-6">
        <VForm @submit.prevent="() => {}">
          <VRow>
            <!-- 👉 Tool Name -->
            <VCol cols="12">
              <VTextField
                v-model="toolDetails.name"
                label="Nama"
                placeholder="Masukkan nama"
              />
            </VCol>
            
            <!-- 👉 Show on landing page -->
            <VCol cols="12">
              <VRadioGroup v-model="toolDetails.show_on_landing_page">
                <VRadio
                  :value="1"
                  :color="success"
                >
                  <template #label>
                    <div>
                      <span class="text-success">
                        Tampilkan di Halaman Utama
                      </span>
                    </div>
                  </template>
                </VRadio>

                <VRadio :value="0">
                  <template #label>
                    <div>
                      <span class="text-primary">
                        Jangan tampilkan
                      </span>
                    </div>
                  </template>
                </VRadio>
              </VRadioGroup>
            </VCol>
            
            <!-- 👉 Tool Icon -->
            <VRow class="mb-4">
              <VCol align-self="center">
                <VFileInput
                  v-model="toolDetails.icon_upload"
                  label="Icon"
                  placeholder="Pilih file"
                  accept="image/*"
                />
              </VCol>

              <!-- Preview icon -->
              <VCol
                v-if="toolDetails.icon"
                cols="3"
              >
                <VImg
                  :src="toolDetails.icon"
                  width="100"
                  height="100"
                />
              </VCol>
            </VRow>


            <!-- 👉 Card actions -->
            <VCol
              cols="12"
              class="text-end"
            >
              <VBtn
                class="me-4"
                type="submit"
                @click="formSubmit"
              >
                Simpan
              </VBtn>
              <VBtn
                color="secondary"
                variant="outlined"
                @click="$emit('update:isDialogVisible', false)"
              >
                Batal
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
import { ref, toRaw, watch } from 'vue';
ref, , watch

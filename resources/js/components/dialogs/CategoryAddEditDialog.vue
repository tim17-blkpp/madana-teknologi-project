<script setup>
import { useCategoryStore } from '@/pages/dashboard/projects/categories/useCategoryStore'
import { ref, toRaw, watch } from 'vue'

const props = defineProps({
  categoryDetails: {
    type: Object,
    required: false,
    default: () => ({
      name: '',
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

const categoryDetails = ref(structuredClone(toRaw(props.categoryDetails)))

const nameRules = [
  v => !!v || 'Nama Kategori harus diisi',
]

watch(props, () => {
  categoryDetails.value = structuredClone(toRaw(props.categoryDetails))
})

const formSubmit = async () => {
  const store = useCategoryStore()


  if (!categoryDetails.value.id) {
    // Category baru
    try {
    // Call the createCategory action from the store
      const response = await store.createCategory(categoryDetails.value)

      // Check the status of the HTTP response
      if (response.status === 201) {
      // Category created successfully
        emit('submit', categoryDetails.value)
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
    // Call the updateCategory action from the store
      const response = await store.updateCategory(categoryDetails.value.id, categoryDetails.value)

      // Check the status of the HTTP response
      if (response.status === 200) {
      // Category updated successfully
        emit('submit', categoryDetails.value)
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
          {{ props.categoryDetails.name ? 'Edit Kategori' : 'Tambah Kategori' }}
        </VCardTitle>
        <VCardSubtitle>
          {{ props.categoryDetails.name ? 'Edit detail Kategori' : 'Tambah detail Kategori' }}
        </VCardSubtitle>
      </VCardItem>

      <VCardText class="mt-6">
        <VForm @submit.prevent="() => {}">
          <VRow>
            <!-- 👉 Category Name -->
            <VCol cols="12">
              <VTextField
                v-model="categoryDetails.name"
                label="Nama Kategori"
                placeholder="Masukkan nama kategori"
                :rules="nameRules"
              />
            </VCol>

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

<script setup>
import { useFaqStore } from '@/pages/dashboard/faq/useFaqStore'
import { ref, toRaw, watch } from 'vue'

const props = defineProps({
  faqDetails: {
    type: Object,
    required: false,
    default: () => ({
      question: '',
      answer: '',
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

const faqDetails = ref(structuredClone(toRaw(props.faqDetails)))

watch(props, () => {
  faqDetails.value = structuredClone(toRaw(props.faqDetails))
})

const formSubmit = async () => {
  const store = useFaqStore()

  if (!faqDetails.value.id) {
    // FAQ baru
    try {
    // Call the createFaq action from the store
      const response = await store.createFaq(faqDetails.value)

      // Check the status of the HTTP response
      if (response.status === 201) {
      // FAQ created successfully
        emit('submit', faqDetails.value)
        emit('update:isDialogVisible', false)

        // Emit an event to notify the parent component about the successful submission
        emit('formSubmitted', true)
        emit('alertMsg', ['Berhasil!', response.data.message])
      } else {
      // Handle other response statuses
        console.error('Error creating FAQ. Unexpected status:', response.status)
      }
    } catch (error) {
    // Handle any errors, e.g., display an error message
      console.error('Error creating FAQ:', error)
    }
  }
  else {
    // edit FAQ
    try {
    // Call the updateFaq action from the store
      const response = await store.updateFaq(faqDetails.value.id, faqDetails.value)

      // Check the status of the HTTP response
      if (response.status === 200) {
      // FAQ updated successfully
        emit('submit', faqDetails.value)
        emit('update:isDialogVisible', false)

        // Emit an event to notify the parent component about the successful submission
        emit('formSubmitted', true)
        emit('alertMsg', ['Berhasil!', response.data.message])
      } else {
      // Handle other response statuses
        console.error('Error updating FAQ. Unexpected status:', response.status)
      }
    } catch (error) {
    // Handle any errors, e.g., display an error message
      console.error('Error creating FAQ:', error)
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
          {{ props.faqDetails.question ? 'Edit FAQ' : 'Tambah FAQ' }}
        </VCardTitle>
        <VCardSubtitle>
          {{ props.faqDetails.question ? 'Edit detail Frequently Asked Question' : 'Tambah detail Frequently Asked Question' }}
        </VCardSubtitle>
      </VCardItem>

      <VCardText class="mt-6">
        <VForm @submit.prevent="() => {}">
          <VRow>
            <!-- 👉 Card Number -->
            <VCol cols="12">
              <VTextField
                v-model="faqDetails.question"
                label="Pertanyaan"
                placeholder="Masukkan pertanyaan"
              />
            </VCol>

            <!-- 👉 Card Name -->
            <VCol cols="12">
              <VTextarea
                v-model="faqDetails.answer"
                label="Jawaban"
                placeholder="Masukkan jawaban yang dibutuhkan"
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

<script setup>
import { useClientStore } from '@/pages/dashboard/projects/clients/useClientStore'
import { ref, toRaw, watch } from 'vue'

const props = defineProps({
  clientDetails: {
    type: Object,
    required: false,
    default: () => ({
      name: '',
      address: '',
      email: '',
      phone: '',
      logo_upload: '',
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

const clientDetails = ref(structuredClone(toRaw(props.clientDetails)))

watch(props, () => {
  clientDetails.value = structuredClone(toRaw(props.clientDetails))
})

const phoneRules = [
  v => !!v || 'Nomor telepon wajib diisi',
  v => /^(\+?)([0-9]+)$/.test(v) || 'Nomor telepon hanya boleh berisi angka dan tanda +',
  v => (v && v.length >= 10 && v.length <= 15) || 'Nomor telepon harus memiliki panjang antara 10 dan 15 karakter',
]

const generalRules = msg => [
  v => !!v || msg,
]

const emailRules = [
  v => !!v || 'Email klien wajib diisi',
  v => /.+@.+\..+/.test(v) || 'Email tidak valid',
]

const formSubmit = async () => {
  const store = useClientStore()


  if (!clientDetails.value.id) {
    // Client baru
    try {
    // Call the createClient action from the store
      const response = await store.createClient(clientDetails.value)

      // Check the status of the HTTP response
      if (response.status === 201) {
      // Client created successfully
        emit('submit', clientDetails.value)
        emit('update:isDialogVisible', false)

        // Emit an event to notify the parent component about the successful submission
        emit('formSubmitted', true)
        emit('alertMsg', ['Berhasil!', response.data.message])
      } else {
      // Handle other response statuses
        console.error('Error creating Client. Unexpected status:', response.status)
      }
    } catch (error) {
    // Handle any errors, e.g., display an error message
      console.error('Error creating Client:', error)
    }
  }
  else {
    // edit Client
    try {
    // Call the updateClient action from the store
      const response = await store.updateClient(clientDetails.value.id, clientDetails.value)

      // Check the status of the HTTP response
      if (response.status === 200) {
      // Client updated successfully
        emit('submit', clientDetails.value)
        emit('update:isDialogVisible', false)

        // Emit an event to notify the parent component about the successful submission
        emit('formSubmitted', true)
        emit('alertMsg', ['Berhasil!', response.data.message])
      } else {
      // Handle other response statuses
        console.error('Error updating Client. Unexpected status:', response.status)
      }
    } catch (error) {
    // Handle any errors, e.g., display an error message
      console.error('Error creating Client:', error)
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
          {{ props.clientDetails.name ? 'Edit Klien' : 'Tambah Klien Baru' }}
        </VCardTitle>
        <VCardSubtitle>
          {{ props.clientDetails.name ? 'Edit detail Klien' : 'Tambah detail Klien' }}
        </VCardSubtitle>
      </VCardItem>

      <VCardText class="mt-6">
        <VForm @submit.prevent="() => {}">
          <VRow>
            <!-- 👉 Client Name -->
            <VCol cols="12">
              <VTextField
                v-model="clientDetails.name"
                label="Nama Klien"
                placeholder="Masukkan nama klien"
                :rules="generalRules('Nama klien wajib diisi')"
              />
            </VCol>
            
            <!-- 👉 Client Address -->
            <VCol cols="12">
              <VTextarea
                v-model="clientDetails.address"
                label="Alamat"
                placeholder="Masukkan alamat klien"
                :rules="generalRules('Alamat klien wajib diisi')"
              />
            </VCol>
            
            <!-- 👉 Client Email -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="clientDetails.email"
                label="Email Klien"
                placeholder="Masukkan email klien"
                :rules="emailRules"
              />
            </VCol>
            
            <!-- 👉 Client Phone -->
            <VCol
              cols="12"
              md="6"
            >
              <VTextField
                v-model="clientDetails.phone"
                label="No Telepon"
                placeholder="Masukkan no telepon yang dapat dihubungi"
                :rules="phoneRules"
              />
            </VCol>

            <!-- 👉 Show on landing page -->
            <VCol cols="12">
              <VRadioGroup v-model="clientDetails.show_on_landing_page">
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


            <!-- 👉 Client Logo -->
            <VCol cols="12">
              <VFileInput
                v-model="clientDetails.logo_upload"
                label="Logo Klien"
                accept="image/*"
                placeholder="Pilih file logo klien"
              />
            </VCol>

            <!-- Preview Logo -->
            <VCol cols="12">
              <VImg
                v-if="clientDetails.logo"
                :src="clientDetails.logo"
                width="200px"
                height="200px"
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

<script setup>
import { ref } from 'vue'
import { useKonfigurasiStore } from './useKonfigurasiStore'

const pageTitle = 'Konfigurasi Halaman Web'
const konfigurasi = ref([])
const konfigurasi_logo = ref('')
const konfigurasi_favicon = ref('')
const konfigurasi_portfolio = ref('')

// alert dialog
const alertTitle = ref('')
const alertMsg = ref('')
const isAlertVisible = ref(false)

const showAlertSuccess = () => {
  isAlertVisible.value = true
  closeAlertDelayed(2000)
}

const closeAlertImmediately = () => {
  isAlertVisible.value = false
  alertTitle.value = ''
  alertMsg.value = ''
}

const closeAlertDelayed = delay => {
  setTimeout(() => {
    isAlertVisible.value = false
  }, delay)
  alertTitle.value = ''
  alertMsg.value = ''
}

const formSubmit = async () => {
  const store = useKonfigurasiStore()

  try {
    const response = await store.updateKonfigurasi(
      {
        nama: konfigurasi.value.nama,
        deskripsi: konfigurasi.value.deskripsi,
        alamat: konfigurasi.value.alamat,
        email: konfigurasi.value.email,
        no_telp: konfigurasi.value.no_telp,
        whatsapp: konfigurasi.value.whatsapp,
        google_maps: konfigurasi.value.google_maps,
        facebook: konfigurasi.value.facebook,
        instagram: konfigurasi.value.instagram,
        twitter: konfigurasi.value.twitter,
        linkedin: konfigurasi.value.linkedin,
        logo: konfigurasi_logo.value,
        favicon: konfigurasi_favicon.value,
        portfolio: konfigurasi_portfolio.value,
      },
    )

    // console.log(konfigurasi.value)

    // Check the status of the HTTP response
    if (response.status === 200) {
      handleFormSubmitted(true)
      getSubmitMsg(['Berhasil!', response.data.message])
    } else {
      // Handle other response statuses
      console.error('Error updating Konfigurasi. Unexpected status:', response.status)
    }
  } catch (error) {
    // Handle any errors, e.g., display an error message
    console.error('Error updating Konfigurasi:', error)
  }
}

// Handle form submitted
const handleFormSubmitted = submitted => {
  if (submitted) {
    fetchKonfigurasi()
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

const openPortfolio = () => {
  if (konfigurasi.value.portfolio) {
    window.open(konfigurasi.value.portfolio, '_blank')
  } else {
    console.error('No portfolio URL found')
  }
}


// Fetch roles function with pagination
const fetchKonfigurasi = async () => {
  const konfigurasiStore = useKonfigurasiStore()

  try {
    const response = await konfigurasiStore.fetchKonfigurasi()

    konfigurasi.value = response.data
  } catch (error) {
    console.error(error)
  }
}

onMounted(() => {
  fetchKonfigurasi()
})
</script>


<template>
  <section>
    <VCard
      :title="pageTitle"
      class="mb-6"
    />
    <VCard
      id="cat-list"
      class="px-8 py-4"
    >
      <VForm @submit.prevent="() => {}">
        <VCardItem>
          <VRow>
            <VCol>
              <VCardTitle>Umum</VCardTitle>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.nama"
                label="Nama Perusahaan"
                placeholder="Isi dengan nama perusahaan"
              />
            </VCol>

            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.deskripsi"
                label="Deskripsi Perusahaan"
                placeholder="Isi dengan deskripsi perusahaan"
              />
            </VCol>

            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.alamat"
                label="Alamat Perusahaan"
                placeholder="Isi dengan alamat perusahaan"
              />
            </VCol>
          
            <VCol cols="12">
              <VFileInput
                v-model="konfigurasi_logo"
                label="Logo Perusahaan (Format: .png, .jpg, .jpeg)"
                accept="image/*"
                placeholder="Pilih file logo perusahaan"
              />
            </VCol>

            
            <!-- Preview Logo -->
            <VCol
              v-if="konfigurasi.logo"
              cols="12"
            >
              <VImg
                :src="konfigurasi.logo"
                alt="Logo Perusahaan"
                class="mb-4"
                style="max-width: 100px;"
              />
            </VCol> 
           

            <VCol cols="12">
              <VFileInput
                v-model="konfigurasi_favicon"
                label="Favicon Perusahaan (Format: .ico)"
                accept="image/x-icon"
                placeholder="Pilih file favicon perusahaan"
              />
            </VCol>

            <!-- Preview Favicon -->
            <VCol
              v-if="konfigurasi.favicon"
              cols="12"
            >
              <VImg
                :src="konfigurasi.favicon"
                alt="Favicon Perusahaan"
                class="mb-4"
                style="max-width: 32px;"
              />
            </VCol>

            <!-- Upload portfolio file -->
            <VCol cols="12">
              <VFileInput
                v-model="konfigurasi_portfolio"
                label="Portfolio Perusahaan (Format: .pdf)"
                accept="application/pdf"
                placeholder="Pilih file portfolio perusahaan"
              />
            </VCol>

            <!-- Preview Portfolio -->
            <VCol
              v-if="konfigurasi.portfolio"
              cols="12"
            >
              <VBtn
                color="primary"
                @click="openPortfolio"
              >
                Lihat Portfolio
              </VBtn>
            </VCol>
          </VRow>
        </VCardItem>

        <VCardItem>
          <VRow>
            <VCol>
              <VCardTitle>Kontak</VCardTitle>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.email"
                label="Email Perusahaan"
                type="email"
                placeholder="Isi dengan email perusahaan"
              />
            </VCol>

            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.no_telp"
                label="Nomor Telepon Perusahaan"
                placeholder="Isi dengan nomor telepon perusahaan"
              />
            </VCol>
          
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.whatsapp"
                label="WhatsApp"
                placeholder="Isi dengan media sosial WhatsApp"
              />
            </VCol>
            
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.google_maps"
                label="Google Maps"
                placeholder="Latitude, Longitude"
              />
            </VCol>
          </VRow>
        </VCardItem>
        
        <VCardItem>
          <VRow>
            <VCol>
              <VCardTitle>Media Sosial</VCardTitle>
            </VCol>
          </VRow>
          <VRow>
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.linkedin"
                label="LinkedIn"
                placeholder="Isi dengan media sosial LinkedIn"
              />
            </VCol>
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.facebook"
                label="Facebook"
                placeholder="Isi dengan media sosial Facebook"
              />
            </VCol>
          
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.instagram"
                label="Instagram"
                placeholder="Isi dengan media sosial Instagram"
              />
            </VCol>
          
            <VCol cols="12">
              <VTextField
                v-model="konfigurasi.twitter"
                label="Twitter"
                placeholder="Isi dengan media sosial Twitter"
              />
            </VCol>
          </VRow>
        </VCardItem>
        <VCardItem>
          <VRow>
            <VCol
              cols="12"
              class="text-start mb-2"
            >
              <VBtn
                type="submit"
                @click="formSubmit"
              >
                Simpan Perubahan
              </VBtn>
            </VCol>
          </VRow>
        </VCardItem>
      </VForm>

      
      <!-- 👉 Alert Message Dialog -->
      
      <AlertMessageDialog
        v-model:isVisible="isAlertVisible"
        :title="alertTitle"
        :message="alertMsg"
        @on-ok="closeAlertImmediately"
      />
    </VCard>
  </section>
</template>



<style lang="scss">
#cat-list {
  .cat-list-search {
    inline-size: 12rem;
  }
}
</style>

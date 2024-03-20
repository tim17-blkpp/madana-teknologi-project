<script setup>
import { ref, watchEffect } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import { useFaqStore } from './useFaqStore'

const faqs = ref([])
const isFaqDialogVisible = ref(false)
const selectedFaq = ref(null)

// Meta data - pagination
const currentPage = ref(1)
const totalPages = ref(0)
const perPage = ref(10)
const totalFaqs = ref(0)
const from = ref(0)
const to = ref(0)

// Filtering (search query)
const searchQuery = ref('')

// confirm dialog: DELETE
const isConfirmDialogVisible = ref(false)
const confirmQuestion = 'Apakah Anda yakin ingin menghapus FAQ ini?'

// alert dialog
const alertTitle = ref('')
const alertMsg = ref('')
const isAlertVisible = ref(false)

// table header
const header = [
  {
    title: 'No',
    key: 'no',
    width: '50px',
    align: 'start',
    sortable: false,
  },
  {
    title: 'Pertanyaan',
    key: 'question',
  },
  {
    title: 'Jawaban',
    key: 'answer',
  },
  {
    title: 'Aksi',
    key: 'actions',
    width: '150px',
    align: 'center',
    sortable: false,
  },
]

// Fetch FAQs function with pagination
const fetchFaqs = async (query, page = 1, perPage = 10) => {
  const faqStore = useFaqStore()

  try {
    const response = await faqStore.fetchFaqs({
      search: query,
      page,
      perPage,
    })

    faqs.value = response.data
    currentPage.value = response.data.meta.current_page
    totalPages.value = response.data.meta.last_page
    totalFaqs.value = response.data.meta.total
    from.value = response.data.meta.from
    to.value = response.data.meta.to
  } catch (error) {
    console.error(error)
  }
}

const fetchNextPage = () => {
  fetchFaqs(searchQuery.value, currentPage.value + 1, perPage.value)
}

const fetchPreviousPage = () => {
  fetchFaqs(searchQuery.value, currentPage.value - 1, perPage.value)
}

// Open dialog to add or edit FAQ
const openDialog = item => {
  selectedFaq.value = item.raw
  isFaqDialogVisible.value = true
}

// Show confirm dialog to delete FAQ
const showConfirmDialog = item => {
  selectedFaq.value = item.raw
  isConfirmDialogVisible.value = true
}

// On Delete FAQ
const onDeleteConfirmation = () => {
  const faqStore = useFaqStore()

  if (selectedFaq.value.id) {
    try {
      faqStore.deleteFaq(selectedFaq.value.id).then(response => {
        alertTitle.value = 'Berhasil!'
        alertMsg.value = response.data.message
        fetchFaqs(searchQuery.value, currentPage.value, perPage.value)
      }).catch(error => {
        alertTitle.value = 'Gagal!'
        alertMsg.value = error
      })
    } catch (error) {
      alertMsg.value = 'Gagal menghapus FAQ'
      console.log(error)
    } finally {
      showAlertSuccess()
    }
  }
}

const showAlertSuccess = () => {
  isConfirmDialogVisible.value = false
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

// Handle form submitted
const handleFormSubmitted = submitted => {
  if (submitted) {
    fetchFaqs(searchQuery.value, currentPage.value, perPage.value)
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

fetchFaqs()

// Watch for changes in the search query & pagination
watchEffect(() => {
  fetchFaqs(searchQuery.value, currentPage.value, perPage.value)
})
</script>

<template>
  <section>
    <VCard
      title="Frequently Asked Question"
      class="mb-6"
    />
    <VCard id="faq-list">
      <VCardText class="d-flex align-center flex-wrap gap-4">
        <VSpacer />

        <div class="d-flex align-center flex-wrap gap-4">
          <!-- 👉 Filter Cari FAQ  -->
          <div class="faq-list-search">
            <VTextField
              v-model="searchQuery"
              placeholder="Cari"
              density="compact"
            />
          </div>

          <!-- 👉 Tambah FAQ -->
          <VBtn
            prepend-icon="mdi-plus"
            @click="openDialog({})"
          >
            Tambah FAQ
          </VBtn>
        </div>
      </VCardText>

      <VCardItem>
        <VDataTable
          v-model:items-per-page="perPage"
          :headers="header"
          :items="faqs.data"
          class="rounded-lg effect-1"
        >
          <!-- No -->
          <template #item.no="{ index }">
            <span>{{ (currentPage - 1) * 10 + index + 1 }}</span>
          </template>
          
          <!-- Actions -->
          <template #item.actions="{item}">
            <div class="action-buttons">
              <!-- Button Edit -->
              <VBtn
                icon="mdi-pencil"
                color="warning"
                rounded="sm"
                size="small"
                @click="openDialog(item)"
              />
              <!-- Button Delete -->
              <VBtn
                icon="mdi-delete"
                color="error"
                rounded="sm"
                size="small"
                @click="showConfirmDialog(item)"
              />
            </div>
          </template>

          <!-- Pagination -->
          <template #bottom>
            <VDivider />
            <div class="d-flex gap-x-6 flex-wrap justify-end pa-2">
              <div class="d-flex align-center gap-x-2 text-sm">
                Rows Per Page:
                <VSelect
                  v-model="perPage"
                  variant="plain"
                  class="per-page-select text-high-emphasis"
                  density="compact"
                  :items="[10, 20, 25, 50, 100]"
                />
              </div> 
              
              <div class="d-flex text-sm align-center text-high-emphasis">
                Menampilkan {{ from }}-{{ to }} dari {{ totalFaqs }} data
              </div>

              <div class="d-flex gap-x-2 align-center">
                <VBtn
                  class="flip-in-rtl"
                  icon="mdi-chevron-left"
                  variant="text"
                  density="comfortable"
                  color="default"
                  :disabled="currentPage === 1"
                  @click="fetchPreviousPage"
                />

                <VBtn
                  class="flip-in-rtl"
                  icon="mdi-chevron-right"
                  density="comfortable"
                  variant="text"
                  color="default"
                  :disabled="currentPage === totalPages"
                  @click="fetchNextPage"
                />
              </div>
            </div>
          </template>
        </VDataTable>
      </VCardItem>
      
      <!-- 👉 Add/Edit FAQ dialog -->
      <FaqAddEditDialog
        v-model:isDialogVisible="isFaqDialogVisible"
        :faq-details="selectedFaq"
        @form-submitted="handleFormSubmitted"
        @alert-msg="getSubmitMsg"
      />

      <!-- 👉 Confirm Delete Dialog -->
      <ConfirmDialog
        v-model:isDialogVisible="isConfirmDialogVisible"
        :confirm-question="confirmQuestion"
        :on-confirmation="onDeleteConfirmation"
      />

      <!-- 👉 Alert Success Dialog -->
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
#faq-list {
  .faq-list-search {
    inline-size: 12rem;
  }
  .action-buttons {
    padding-top: 2px;
    padding-bottom: 2px;
    display: flex;
    flex-direction: row;
    gap: 2px; /* Adjust the gap between buttons as needed */
    justify-content: center;
  }
}
</style>

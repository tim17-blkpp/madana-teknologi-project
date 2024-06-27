<script setup>
import { ref, watchEffect } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import CategoryAddEditDialog from '../../../../components/dialogs/CategoryAddEditDialog.vue'
import { useCategoryStore } from './useCategoryStore'

const pageTitle = 'Kategori Proyek'
const categories = ref([])
const selectedCategory = ref(null)
const isDialogVisible = ref(false)

// Meta data - pagination
const currentPage = ref(1)
const totalPages = ref(0)
const perPage = ref(10)
const totalCategories = ref(0)
const from = ref(0)
const to = ref(0)

// Filtering (search query)
const searchQuery = ref('')

// confirm dialog: DELETE
const isConfirmDialogVisible = ref(false)
const confirmQuestion = 'Apakah Anda yakin ingin menghapus kategori ini?'

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
    title: 'Kategori',
    key: 'category_name',
  },
  {
    title: 'Jumlah Proyek Dikerjakan',
    key: 'project_count',
    width: '300px',
    align: 'center',
  },
  {
    title: 'Aksi',
    key: 'actions',
    width: '150px',
    align: 'center',
    sortable: false,
  },
]


// Open dialog to add or edit Kategori
const openDialog = item => {
  selectedCategory.value = item.raw
  isDialogVisible.value = true
}

// Show confirm dialog to delete Kategori
const showConfirmDialog = item => {
  selectedCategory.value = item.raw
  isConfirmDialogVisible.value = true
}

// On Delete Kategori
const onDeleteConfirmation = () => {
  const categoryStore = useCategoryStore()

  if (selectedCategory.value.id) {
    try {
      categoryStore.deleteCategory(selectedCategory.value.id).then(response => {
        alertTitle.value = 'Berhasil!'
        alertMsg.value = response.data.message
        fetchCategories(searchQuery.value, currentPage.value, perPage.value)
      }).catch(error => {
        alertTitle.value = 'Gagal!'
        alertMsg.value = error
      })
    } catch (error) {
      alertMsg.value = 'Gagal menghapus Kategori'
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
    fetchCategories(searchQuery.value, currentPage.value, perPage.value)
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

// Fetch Kategoris function with pagination
const fetchCategories = async (query, page = 1, perPage = 10) => {
  const categoryStore = useCategoryStore()

  try {
    const response = await categoryStore.fetchCategories({
      search: query,
      page,
      perPage,
    })

    categories.value = response.data
    currentPage.value = response.data.meta.current_page
    totalPages.value = response.data.meta.last_page
    totalCategories.value = response.data.meta.total
    from.value = response.data.meta.from
    to.value = response.data.meta.to
  } catch (error) {
    console.error(error)
  }
}

watchEffect(() => {
  fetchCategories(searchQuery.value, currentPage.value, perPage.value)
})
</script>


<template>
  <section>
    <VCard
      :title="pageTitle"
      class="mb-6"
    />
    <VCard id="cat-list">
      <VCardText class="d-flex align-center flex-wrap gap-4">
        <VSpacer />

        <div class="d-flex align-center flex-wrap gap-4">
          <!-- 👉 Filter Cari Kategori  -->
          <div class="cat-list-search">
            <VTextField
              v-model="searchQuery"
              placeholder="Cari"
              density="compact"
            />
          </div>

          <!-- 👉 Tambah Kategori -->
          <VBtn
            prepend-icon="mdi-plus"
            @click="openDialog({})"
          >
            Tambah Kategori
          </VBtn>
        </div>
      </VCardText>

      <VCardItem>
        <VDataTable
          v-model:items-per-page="perPage"
          :headers="header"
          :items="categories.data"
          class="rounded-lg effect-1"
        >
          <!-- No -->
          <template #item.no="{ index }">
            <span>{{ (currentPage - 1) * 10 + index + 1 }}</span>
          </template>

          <!-- Nama kategori -->
          <template #item.category_name="{ item }">
            <p>{{ item.raw.name }}</p>
          </template>

          <!-- Jumlah proyek dikerjakan -->
          <template #item.project_count="{ item }">
            <div class="project-detail">
              <span>{{ item.raw.projects_count }} proyek</span>
              <VBtn
                icon="mdi-arrow-right"
                color="info"
                rounded="sm"
                size="small"
              />
            </div>
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
        </VDataTable>
      </VCardItem>

      
      <!-- 👉 Add/Edit Category dialog -->
      <CategoryAddEditDialog
        v-model:isDialogVisible="isDialogVisible"
        :category-details="selectedCategory"
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
#cat-list {
  .cat-list-search {
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
  .project-detail {
    display: flex;
    flex-direction: row;
    gap: 8px; /* Adjust the gap between buttons as needed */
    justify-content:center;
    align-items: center;
  }
}
</style>

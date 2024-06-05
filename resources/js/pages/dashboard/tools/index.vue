<script setup>
import { ref, watchEffect } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import ToolsAddEditDialog from '../../../components/dialogs/ToolsAddEditDialog.vue'
import { useToolStore } from './useToolStore'

const pageTitle = 'Tools yang Digunakan'
const tools = ref([])
const selectedTool = ref(null)
const isDialogVisible = ref(false)



// Meta data - pagination
const currentPage = ref(1)
const totalPages = ref(0)
const perPage = ref(10)
const totalTools = ref(0)
const from = ref(0)
const to = ref(0)

// Filtering (search query)
const searchQuery = ref('')

// confirm dialog: DELETE
const isConfirmDialogVisible = ref(false)
const confirmQuestion = 'Apakah Anda yakin ingin menghapus tool ini?'

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
    title: 'Tool',
    key: 'tool_name',
    width: '200px',
    align: 'center',
  },
  {
    title: 'Tampil di Halaman Utama',
    key: 'tool_show',
    width: '200px',
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


// Open dialog to add or edit tool
const openDialog = item => {
  selectedTool.value = item.raw
  isDialogVisible.value = true
}

// Show confirm dialog to delete tool
const showConfirmDialog = item => {
  selectedTool.value = item.raw
  isConfirmDialogVisible.value = true
}

// On Delete tool
const onDeleteConfirmation = () => {
  const toolStore = useToolStore()

  if (selectedTool.value.id) {
    try {
      toolStore.deleteTool(selectedTool.value.id).then(response => {
        alertTitle.value = 'Berhasil!'
        alertMsg.value = response.data.message
        fetchTools(searchQuery.value, currentPage.value, perPage.value)
      }).catch(error => {
        alertTitle.value = 'Gagal!'
        alertMsg.value = error
      })
    } catch (error) {
      alertMsg.value = 'Gagal menghapus tool'
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
    fetchTools(searchQuery.value, currentPage.value, perPage.value)
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

// Fetch tools function with pagination
const fetchTools = async (query, page = 1, perPage = 10) => {
  const toolStore = useToolStore()

  try {
    const response = await toolStore.fetchTools({
      search: query,
      page,
      perPage,
    })

    tools.value = response.data
    currentPage.value = response.data.meta.current_page
    totalPages.value = response.data.meta.last_page
    totalTools.value = response.data.meta.total
    from.value = response.data.meta.from
    to.value = response.data.meta.to
  } catch (error) {
    console.error(error)
  }
}

watchEffect(() => {
  fetchTools(searchQuery.value, currentPage.value, perPage.value)
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
          <!-- 👉 Filter Cari Tool  -->
          <div class="cat-list-search">
            <VTextField
              v-model="searchQuery"
              placeholder="Cari"
              density="compact"
            />
          </div>

          <!-- 👉 Tambah Tool -->
          <VBtn
            prepend-icon="mdi-plus"
            @click="openDialog({})"
          >
            Tambah Data
          </VBtn>
        </div>
      </VCardText>

      <VCardItem>
        <VDataTable
          v-model:items-per-page="perPage"
          :headers="header"
          :items="tools.data"
          class="rounded-lg effect-1"
        >
          <!-- No -->
          <template #item.no="{ index }">
            <span>{{ (currentPage - 1) * 10 + index + 1 }}</span>
          </template>

          <!-- Tools -->
          <template #item.tool_name="{ item }">
            <VRow
              align-content="space-between"
              justify="space-evenly"
              class="my-1"
            >
              <VCol align-self="center">
                <img
                  v-if="item.raw.icon"
                  :src="item.raw.icon"
                  alt="item.raw.name"
                  width="100"
                  height="100"
                >
              </VCol>
              <VCol
                align-self="center"
                class="text-start"
              >
                <p>{{ item.raw.name }}</p>
              </VCol>
            </VRow>
          </template>

          <!-- Show on landing page -->
          <template #item.tool_show="{ item }">
            <div class="project-detail">
              <VChip
                v-if="item.raw.show_on_landing_page"
                color="success"
                text-color="white"
                class="text-capitalize"
              >
                <VIcon color="success">
                  mdi-check
                </VIcon>
                <span>&emsp;Ya</span>
              </VChip>
              <VChip
                v-else
                color="error"
                text-color="white"
                class="text-capitalize"
              >
                <VIcon color="error">
                  mdi-close
                </VIcon>
                <span>&emsp;Tidak</span>
              </VChip>
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

      
      <!-- 👉 Add/Edit Tool dialog -->
      <ToolsAddEditDialog
        v-model:isDialogVisible="isDialogVisible"
        :tool-details="selectedTool"
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
</style>./useToolsStore

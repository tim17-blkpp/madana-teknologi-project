<script setup>
import { ref } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import ClientAddEditDialog from '../../../../components/dialogs/ClientAddEditDialog.vue'
import { useClientStore } from './useClientStore'

const pageTitle = 'List Klien'
const clients = ref([])
const selectedClient = ref(null)
const isDialogVisible = ref(false)

// Meta data - pagination
const currentPage = ref(1)
const totalPages = ref(0)
const perPage = ref(10)
const totalClients = ref(0)
const from = ref(0)
const to = ref(0)

// Filtering (search query)
const searchQuery = ref('')

// confirm dialog: DELETE
const isConfirmDialogVisible = ref(false)
const confirmQuestion = 'Apakah Anda yakin ingin menghapus klien ini?'

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
    title: 'Klien',
    key: 'client_name',
  },
  {
    title: 'Alamat',
    key: 'client_address',
  },
  {
    title: 'Jumlah Proyek Terkait',
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


// Open dialog to add or edit Client
const openDialog = item => {
  selectedClient.value = item.raw
  isDialogVisible.value = true
}

// Show confirm dialog to delete Client
const showConfirmDialog = item => {
  selectedClient.value = item.raw
  isConfirmDialogVisible.value = true
}

// On Delete Client
const onDeleteConfirmation = () => {
  const clientStore = useClientStore()

  if (selectedClient.value.id) {
    try {
      clientStore.deleteClient(selectedClient.value.id).then(response => {
        alertTitle.value = 'Berhasil!'
        alertMsg.value = response.data.message
        fetchClients(searchQuery.value, currentPage.value, perPage.value)
      }).catch(error => {
        alertTitle.value = 'Gagal!'
        alertMsg.value = 'Gagal menghapus Klien'
      })
    } catch (error) {
      alertMsg.value = 'Gagal menghapus Klien'
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
    fetchClients(searchQuery.value, currentPage.value, perPage.value)
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

// Fetch Clients function with pagination
const fetchClients = async (query, page = 1, perPage = 10) => {
  const clientStore = useClientStore()

  try {
    const response = await clientStore.fetchClients({
      search: query,
      page,
      perPage,
    })

    clients.value = response.data
    currentPage.value = response.data.meta.current_page
    totalPages.value = response.data.meta.last_page
    totalClients.value = response.data.meta.total
    from.value = response.data.meta.from
    to.value = response.data.meta.to
  } catch (error) {
    console.error(error)
  }
}

watchEffect(() => {
  fetchClients(searchQuery.value, currentPage.value, perPage.value)
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
          <!-- 👉 Filter Cari Client  -->
          <div class="cat-list-search">
            <VTextField
              v-model="searchQuery"
              placeholder="Cari"
              density="compact"
            />
          </div>

          <!-- 👉 Tambah Client -->
          <VBtn
            prepend-icon="mdi-plus"
            @click="openDialog({})"
          >
            Tambah Klien
          </VBtn>
        </div>
      </VCardText>

      <VCardItem>
        <VDataTable
          v-model:items-per-page="perPage"
          :headers="header"
          :items="clients.data"
          class="rounded-lg effect-1"
        >
          <!-- No -->
          <template #item.no="{ index }">
            <span>{{ (currentPage - 1) * 10 + index + 1 }}</span>
          </template>

          <!-- Detail Client -->
          <template #item.client_name="{ item }">
            <p>
              <b>Nama &emsp;&ensp;&nbsp;: </b> {{ item.raw.name }}<br>
              <b>Email &emsp;&emsp;: </b> {{ item.raw.email }}<br>
              <b>Telepon &ensp; : </b> {{ item.raw.phone }}
            </p>
          </template>
          
          <!-- Alamat Client -->
          <template #item.client_address="{ item }">
            <p>
              {{ item.raw.address }}
            </p>
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

      
      <!-- 👉 Add/Edit Client dialog -->
      <ClientAddEditDialog
        v-model:isDialogVisible="isDialogVisible"
        :client-details="selectedClient"
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

<script setup>
import { ref } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import ProjectAddEditDialog from '../../../../components/dialogs/ProjectAddEditDialog.vue'
import { useCategoryStore } from '../categories/useCategoryStore'
import { useClientStore } from '../clients/useClientStore'
import { useProjectStore } from './useProjectStore'

const pageTitle = 'List Proyek'
const projects = ref([])
const selectedProject = ref(null)
const isDialogVisible = ref(false)
const categories = ref([])
const clients = ref([])

// Meta data - pagination
const currentPage = ref(1)
const totalPages = ref(0)
const perPage = ref(10)
const totalProjects = ref(0)
const from = ref(0)
const to = ref(0)

// Filtering (search query)
const searchQuery = ref('')

// confirm dialog: DELETE
const isConfirmDialogVisible = ref(false)
const confirmQuestion = 'Apakah Anda yakin ingin menghapus proyek ini?'

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
    title: 'Gambar',
    key: 'project_thumbnail',
    width: '100px',
    sortable: false,
  },
  {
    title: 'Pesanan',
    key: 'project_info',
  },
  {
    title: 'Deskripsi',
    key: 'project_description',
  },
  {
    title: 'Alamat URL',
    key: 'project_url',
    width: '300px',
    align: 'center',
  },
  {
    title: 'Status',
    key: 'project_status',
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
  selectedProject.value = item.raw

  // selectedProject.value.id = item.id
  // selectedProject.value.name = item.raw.name
  // selectedProject.value.category_id = item.raw.category.id
  // selectedProject.value.client_id = item.raw.client.id
  // selectedProject.value.description = item.raw.description
  // selectedProject.value.url = item.raw.url
  // selectedProject.value.thumbnail = item.raw.thumbnail
  // selectedProject.value.start_date = item.raw.start_date
  // selectedProject.value.end_date = item.raw.end_date
  // selectedProject.value.status = item.raw.status
  // console.log(item.raw)
  isDialogVisible.value = true
}

// Show confirm dialog to delete Client
const showConfirmDialog = item => {
  selectedProject.value = item.raw
  isConfirmDialogVisible.value = true
}

// On Delete Client
const onDeleteConfirmation = () => {
  const projectStore = useProjectStore()

  if (selectedProject.value.id) {
    try {
      projectStore.deleteProject(selectedProject.value.id).then(response => {
        alertTitle.value = 'Berhasil!'
        alertMsg.value = response.data.message
        fetchProjects(searchQuery.value, currentPage.value, perPage.value)
      }).catch(error => {
        alertTitle.value = 'Gagal!'
        alertMsg.value = 'Gagal menghapus Proyek'
      })
    } catch (error) {
      alertMsg.value = 'Gagal menghapus Proyek'
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
    fetchProjects(searchQuery.value, currentPage.value, perPage.value)
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

// Fetch Projects function with pagination
const fetchProjects = async (query, page = 1, perPage = 10) => {
  const projectStore = useProjectStore()

  try {
    const response = await projectStore.fetchProjects({
      search: query,
      page,
      perPage,
    })

    projects.value = response.data
    currentPage.value = response.data.meta.current_page
    totalPages.value = response.data.meta.last_page
    totalProjects.value = response.data.meta.total
    from.value = response.data.meta.from
    to.value = response.data.meta.to

    // console.log(response.data)
  } catch (error) {
    console.error(error)
  }
}

// Fetch projects function with pagination
const fetchCategoriesAndClients = async () => {
  const categoryStore = useCategoryStore()
  const clientStore = useClientStore()

  try {
    const responseCategory = await categoryStore.fetchCategories({
      perPage: 100,
    })

    const responseClient = await clientStore.fetchClients({
      perPage: 100,
    })

    categories.value = responseCategory.data.data.map(category => ({
      id: category.id,
      name: category.name,
    }))
    clients.value = responseClient.data.data.map(client => ({
      id: client.id,
      name: client.name,
    }))
  } catch (error) {
    console.error(error)
  }
}

fetchCategoriesAndClients()

watchEffect(() => {
  fetchProjects(searchQuery.value, currentPage.value, perPage.value)
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
          <!-- 👉 Filter Cari Project  -->
          <div class="cat-list-search">
            <VTextField
              v-model="searchQuery"
              placeholder="Cari"
              density="compact"
            />
          </div>

          <!-- 👉 Tambah Project -->
          <VBtn
            prepend-icon="mdi-plus"
            @click="openDialog({})"
          >
            Tambah Proyek
          </VBtn>
        </div>
      </VCardText>

      <VCardItem>
        <VDataTable
          v-model:items-per-page="perPage"
          :headers="header"
          :items="projects.data"
          class="rounded-lg effect-1"
        >
          <!-- No -->
          <template #item.no="{ index }">
            <span>{{ (currentPage - 1) * 10 + index + 1 }}</span>
          </template>

          <!-- Project Thumbnail -->
          <template #item.project_thumbnail="{ item }">
            <VImg
              v-if="item.raw.thumbnail_path"
              :src="item.raw.thumbnail_path"
              width="100"
              height="100"
              contain
            />
          </template>

          <!-- Informasi Project -->
          <template #item.project_info="{ item }">
            <p>
              <b>Nama &emsp;&ensp;&nbsp;: </b> {{ item.raw.name }}<br>
              <b>Kategori &ensp;: </b> {{ item.raw.category.name }}<br>
              <b>Klien &emsp;&emsp; : </b> {{ item.raw.client.name }}
            </p>
          </template>
          
          <!-- Deskripsi Project -->
          <template #item.project_description="{ item }">
            <p>
              {{ item.raw.description }}
            </p>
          </template>

          <!-- Project URL -->
          <template #item.project_url="{ item }">
            <div class="project-detail">
              <VIcon>mdi-link</VIcon>
              <a
                :href="item.raw.url"
                target="_blank"
                rel="noopener noreferrer"
              >
                {{ item.raw.url }}
              </a>
            </div>
          </template>

          <!-- Status Project -->
          <template #item.project_status="{ item }">
            <VChip
              v-if="item.raw.status === 'Dalam Proses'"
              color="primary"
              text-color="white"
              class="text-capitalize"
            >
              {{ item.raw.status }}
            </VChip>
            <VChip
              v-else-if="item.raw.status === 'Selesai'"
              color="success"
              text-color="white"
              class="text-capitalize"
            >
              {{ item.raw.status }}
            </VChip>
            <VChip
              v-else-if="item.raw.status === 'Dibatalkan'"
              color="error"
              text-color="white"
              class="text-capitalize"
            >
              {{ item.raw.status }}
            </VChip>
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

      
      <!-- 👉 Add/Edit Project dialog -->
      <ProjectAddEditDialog
        v-model:isDialogVisible="isDialogVisible"
        :categories="categories"
        :clients="clients"
        :project="selectedProject"
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
</style>./useProjectStore

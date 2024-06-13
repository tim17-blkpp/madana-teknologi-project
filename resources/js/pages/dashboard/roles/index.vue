<script setup>
import { ref, watchEffect } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import RolesAddEditDialog from '../../../components/dialogs/RolesAddEditDialog.vue'
import { useRoleStore } from './useRoleStore'

const pageTitle = 'Role yang Dimiliki'
const roles = ref([])
const selectedRole = ref(null)
const isDialogVisible = ref(false)

// Meta data - pagination
const currentPage = ref(1)
const totalPages = ref(0)
const perPage = ref(10)
const totalRoles = ref(0)
const from = ref(0)
const to = ref(0)

// Filtering (search query)
const searchQuery = ref('')

// confirm dialog: DELETE
const isConfirmDialogVisible = ref(false)
const confirmQuestion = 'Apakah Anda yakin ingin menghapus role ini?'

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
    title: 'Role',
    key: 'role_name',
    width: '200px',
    align: 'center',
  },
  {
    title: 'Tampil di Halaman Utama',
    key: 'role_show',
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


// Open dialog to add or edit role
const openDialog = item => {
  selectedRole.value = item.raw
  isDialogVisible.value = true
}

// Show confirm dialog to delete role
const showConfirmDialog = item => {
  selectedRole.value = item.raw
  isConfirmDialogVisible.value = true
}

// On Delete role
const onDeleteConfirmation = () => {
  const roleStore = useRoleStore()

  if (selectedRole.value.id) {
    try {
      roleStore.deleteRole(selectedRole.value.id).then(response => {
        alertTitle.value = 'Berhasil!'
        alertMsg.value = response.data.message
        fetchRoles(searchQuery.value, currentPage.value, perPage.value)
      }).catch(error => {
        alertTitle.value = 'Gagal!'
        alertMsg.value = error
      })
    } catch (error) {
      alertMsg.value = 'Gagal menghapus role'
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
    fetchRoles(searchQuery.value, currentPage.value, perPage.value)
    showAlertSuccess()
  }
}

// Get submit message
const getSubmitMsg = msg => {
  alertTitle.value = msg[0]
  alertMsg.value = msg[1]
}

// Fetch roles function with pagination
const fetchRoles = async (query, page = 1, perPage = 10) => {
  const roleStore = useRoleStore()

  try {
    const response = await roleStore.fetchRoles({
      search: query,
      page,
      perPage,
    })

    roles.value = response.data
    currentPage.value = response.data.meta.current_page
    totalPages.value = response.data.meta.last_page
    totalRoles.value = response.data.meta.total
    from.value = response.data.meta.from
    to.value = response.data.meta.to
  } catch (error) {
    console.error(error)
  }
}

watchEffect(() => {
  fetchRoles(searchQuery.value, currentPage.value, perPage.value)
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
          <!-- 👉 Filter Cari Role  -->
          <div class="cat-list-search">
            <VTextField
              v-model="searchQuery"
              placeholder="Cari"
              density="compact"
            />
          </div>

          <!-- 👉 Tambah Role -->
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
          :items="roles.data"
          class="rounded-lg effect-1"
        >
          <!-- No -->
          <template #item.no="{ index }">
            <span>{{ (currentPage - 1) * 10 + index + 1 }}</span>
          </template>

          <!-- Roles -->
          <template #item.role_name="{ item }">
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
                  style="filter: invert(1);"
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
          <template #item.role_show="{ item }">
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

      
      <!-- 👉 Add/Edit Role dialog -->
      <RolesAddEditDialog
        v-model:isDialogVisible="isDialogVisible"
        :role-details="selectedRole"
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
</style>./useRolesStore./useRoleStore

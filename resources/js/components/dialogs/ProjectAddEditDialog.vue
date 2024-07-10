<script setup>
import AppDateTimePicker from '@/@core/components/app-form-elements/AppDateTimePicker.vue'
import { useProjectStore } from '@/pages/dashboard/projects/list/useProjectStore'
import { ref, watch } from 'vue'

const props = defineProps({
  project: {
    type: Object,
    required: false,
    default: () => ({
      name: '',
      category_id: null,
      client_id: null,
      category: {},
      client: {},
      description: '',
      url: '',
      thumbnail: '',
      start_date: '',
      end_date: '',
      status: '',
      show_on_landing_page: '0',
    }),
  },
  isDialogVisible: {
    type: Boolean,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  clients: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits([
  'submit',
  'update:isDialogVisible',
  'formSubmitted',
  'alertMsg',
])

const project = ref(structuredClone(toRaw(props.project)))

const generalRules = msg => [
  v => !!v || msg,
]

const tab = ref('project-info') 
function deepClone(obj) {
  return JSON.parse(JSON.stringify(obj))
}

watch(
  () => props.project,
  newProject => {
    project.value = structuredClone(toRaw(newProject))
  }, { deep: true, immediate: true },
)

// function logFormData(formData) {
//   for (let pair of formData.entries()) {
//     console.log(`${pair[0]}: ${pair[1]}`)
//   }
// }


const formSubmit = async () => {
  const store = useProjectStore()

  // Prepare the project data
  project.value.category_id = project.value.category.id
  project.value.client_id = project.value.client.id

  // Create a FormData object to handle file upload
  const formData = new FormData()

  for (const key in project.value) {
    if (key !== 'category' && key !== 'client')
      formData.append(key, project.value[key])
  }

  if (project.value.thumbnail instanceof File) {
    formData.append('thumbnail', project.value.thumbnail)
  } 

  // logFormData(formData)

  try {
    let response
    if (!project.value.id) {
      // Project baru
      // response = await store.createProject(formData)

      response = await store.createProject(project.value)
    } else {
      // Edit Project
      // response = await store.updateProject(project.value.id, formData)
      response = await store.updateProject(project.value.id, project.value)
    }

    if ((project.value.id && response.status === 200) || (!project.value.id && response.status === 201)) {
      emit('submit', project.value)
      emit('update:isDialogVisible', false)
      emit('formSubmitted', true)
      emit('alertMsg', ['Berhasil!', response.data.message])
    } else {
      console.error('Error processing Project. Unexpected status:', response.status)
    }
  } catch (error) {
    console.error('Error processing Project:', error)
  }
}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 650"
    :model-value="props.isDialogVisible"
    persistent
    no-click-animation
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
          {{ props.project.name ? 'Edit Project' : 'Tambah Project Baru' }}
        </VCardTitle>
        <VCardSubtitle>
          {{ props.project.name ? 'Edit detail Project' : 'Tambah detail Project' }}
        </VCardSubtitle>
      </VCardItem>

      <VCardText class="mt-6">
        <VForm @submit.prevent="() => {}">
          <VRow>
            <!-- 👉 Project Name -->
            <VCol cols="12">
              <VTextField
                v-model="project.name"
                label="Nama"
                placeholder="Masukkan nama proyek"
                :rules="generalRules('Nama proyek harus diisi')"
              />
            </VCol>
            
            <!-- 👉 Project Category -->
            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="project.category.id"
                :items="props.categories"
                item-title="name"
                item-value="id"
                label="Kategori"
                placeholder="Pilih kategori proyek"
                :rules="generalRules('Kategori proyek harus dipilih')"
              />
            </VCol>

            <!-- 👉 Project Client -->
            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="project.client.id"
                :items="props.clients"
                item-title="name"
                item-value="id"
                label="Klien"
                placeholder="Pilih klien proyek"
                :rules="generalRules('Klien proyek harus dipilih')"
              />
            </VCol>
            
            <!-- 👉 Project Description -->
            <VCol cols="12">
              <VTextarea
                v-model="project.description"
                label="Deskripsi"
                placeholder="Masukkan deskripsi proyek"
              />
            </VCol>
            
            <!-- 👉 Project URL -->
            <VCol
              cols="12"
              md="4"
            >
              <VTextField
                v-model="project.url"
                label="URL Proyek"
                placeholder="Masukkan alamat URL proyek"
              />
            </VCol>

            <!-- 👉 Project Start Date -->
            <VCol
              cols="12"
              md="4"
            >
              <AppDateTimePicker
                v-model="project.start_date"
                label="Tanggal Mulai"
                placeholder="Pilih tanggal mulai proyek"
                :config="{ altInput: true, altFormat: 'F j, Y', dateFormat: 'Y-m-d' }"
                @click.stop 
              />
            </VCol>

            <!-- 👉 Project End Date -->
            <VCol
              cols="12"
              md="4"
            >
              <AppDateTimePicker
                v-model="project.end_date"
                label="Tanggal Selesai"
                placeholder="Pilih tanggal selesai proyek"
                :config="{ altInput: true, altFormat: 'F j, Y', dateFormat: 'Y-m-d' }"
                @click.stop 
              />
            </VCol>

            <!-- 👉 Project Status -->
            <VCol
              cols="12"
              md="6"
            >
              <VSelect
                v-model="project.status"
                :items="['Dalam Proses', 'Selesai', 'Dibatalkan']"
                label="Status"
                placeholder="Pilih status proyek"
              />
            </VCol>

            <VCol
              cols="12"
              md="6"
            >
              <VRadioGroup v-model="project.show_on_landing_page">
                <VRadio
                  :value="1"
                  :color="success"
                >
                  <template #label>
                    <div>
                      <span class="text-success">
                        Tampilkan di Landing Page
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

            

            <!-- 👉 Project Thumbnail -->
            <VCol cols="12">
              <VFileInput
                v-model="project.thumbnail"
                label="Unggah Thumbnail Proyek"
                accept="image/*"
                placeholder="Pilih thumbnail proyek"
                @click.stop 
              />
            </VCol>

            <!-- Preview Thumbnail -->
            <VCol cols="12">
              <VImg
                v-if="project.thumbnail_path"
                :src="project.thumbnail_path"
                alt="Thumbnail Proyek"
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

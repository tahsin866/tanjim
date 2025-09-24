<template>
  <AuthenticatedLayout style="font-family: 'SolaimanLipi', sans-serif;">
 <div class="admin-content-wrapper p-4">
    <!-- Card -->
    <div class="card shadow border-0 adminlte-card">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center adminlte-card-header">
        <h3 class="card-title mb-0 text-lg d-flex align-items-center gap-2">
          <i class="pi pi-users mr-2"></i>
          <span>শিক্ষার্থী তালিকা</span>
        </h3>
        <span class="badge badge-pill badge-light text-black px-3 py-2">
          মোট: <span class="font-weight-bold">{{ students.length }}</span> জন
        </span>
      </div>
      <div class="card-body p-3 bg-white adminlte-card-body">
        <DataTable
          :value="students"
          :rows="10"
          paginator
          stripedRows
          showGridlines
          responsiveLayout="scroll"
          class="p-datatable-sm adminlte-table"
          tableStyle="min-width: 60rem"
        >
          <!-- ছবি -->
          <Column header="ছবি" style="width: 90px; text-align:center;">
            <template #body="slotProps">
              <div class="d-flex justify-content-center align-items-center">
                <Avatar
                  :image="getPhotoUrl(slotProps.data.photo)"
                  size="large"
                  shape="circle"
                  class="border border-secondary shadow-sm adminlte-avatar"
                  @error="handleImageError"
                />
              </div>
            </template>
          </Column>
          <!-- পূর্ণ নাম -->
          <Column field="fullNameBangla" header="পূর্ণ নাম (বাংলা)">
            <template #body="slotProps">
              <span class="font-weight-bold text-dark text-nowrap">{{ slotProps.data.fullNameBangla }}</span>
            </template>
          </Column>
          <Column field="fullNameEnglish" header="পূর্ণ নাম (ইংরেজি)">
            <template #body="slotProps">
              <span class="text-secondary text-nowrap">{{ slotProps.data.fullNameEnglish }}</span>
            </template>
          </Column>
          <!-- জন্মতারিখ -->
          <Column field="dateOfBirth" header="জন্মতারিখ" style="width: 140px;">
            <template #body="slotProps">
              <span class="badge badge-info badge-pill border shadow-sm px-3 py-2">
                {{ slotProps.data.dateOfBirth ? formatDate(slotProps.data.dateOfBirth) : '-' }}
              </span>
            </template>
          </Column>
          <!-- পিতার নাম -->
          <Column field="fatherName" header="পিতার নাম">
            <template #body="slotProps">
              <span class="text-dark text-nowrap">{{ slotProps.data.fatherName }}</span>
            </template>
          </Column>
          <!-- ফোন -->
          <Column field="phoneNumber" header="ফোন নম্বর" style="width: 140px;">
            <template #body="slotProps">
              <span class="badge badge-pill badge-secondary px-2 d-inline-flex align-items-center gap-1">
                <i class="pi pi-phone"></i>
                {{ slotProps.data.phoneNumber }}
              </span>
            </template>
          </Column>
          <!-- বিভাগ -->
          <Column header="বিভাগ">
            <template #body="slotProps">
              <div class="d-flex flex-wrap gap-1 align-items-center">
                <span v-if="slotProps.data.dept_takmil" class="badge badge-primary">
                  তাকমিল ({{ slotProps.data.dept_takmil_year_english }})
                </span>
                <span v-if="slotProps.data.dept_ifta" class="badge badge-success">
                  ইফতা ({{ slotProps.data.dept_ifta_year_english }})
                </span>
                <span v-if="slotProps.data.dept_hifz" class="badge badge-purple">
                  হিফজ ({{ slotProps.data.dept_hifz_year_english }})
                </span>
                <span v-if="slotProps.data.dept_qirat" class="badge badge-warning text-dark">
                  কিরাআত ({{ slotProps.data.dept_qirat_year_english }})
                </span>
                <span v-if="slotProps.data.dept_adab" class="badge badge-info text-dark">
                  আদব ({{ slotProps.data.dept_adab_year_english }})
                </span>
                <span v-if="slotProps.data.dept_other" class="badge badge-secondary">
                  অন্যান্য ({{ slotProps.data.dept_other_class }})
                </span>
              </div>
            </template>
          </Column>
          <!-- রেজিস্ট্রেশন -->
          <Column header="রেজিশ্ট্রেশন পেমেন্ট">
            <template #body="slotProps">
              <div>
                <span class="badge badge-light text-dark px-2 py-1 shadow-sm">{{ slotProps.data.examType }}</span>
                <div v-if="slotProps.data.roll_number" class="text-muted small mt-1">
                  <span class="font-weight-bold">রোল:</span> {{ slotProps.data.roll_number }}
                </div>
              </div>
            </template>
          </Column>
          <!-- স্ট্যাটাস -->
          <Column field="status" header="স্ট্যাটাস" style="width: 120px;">
            <template #body="slotProps">
              <span
                :class="{
                  'badge badge-warning text-dark': slotProps.data.status === 'pending',
                  'badge badge-success': slotProps.data.status === 'approved',
                  'badge badge-danger': slotProps.data.status === 'rejected',
                  'badge badge-secondary': slotProps.data.status === 'suspended',
                }"
                class="px-3 py-2"
              >
                {{ slotProps.data.status }}
              </span>
            </template>
          </Column>
          <!-- অ্যাকশন -->
          <Column header="অ্যাকশন" style="width: 150px; text-align:center;">
            <template #body="slotProps">
              <div class="d-flex justify-content-center align-items-center">
                <SplitButton
                  v-if="slotProps.data.status !== 'suspended'"
                  label="অ্যাকশন"
                  :model="getMenuItems(slotProps.data)"
                  class="btn btn-sm btn-outline-dark"
                />
                <span v-else class="text-muted small fst-italic">
                  কোন অ্যাকশন নেই
                </span>
              </div>
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </div>
  </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed, h, render } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Avatar from 'primevue/avatar';
import SplitButton from 'primevue/splitbutton';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Fieldset from 'primevue/fieldset';
import InputText from 'primevue/inputtext';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import StudentRegistrationCard from './StudentRegistrationCard.vue';

// Import html2canvas properly at the top level
import html2canvas from 'html2canvas';

// Props from Inertia
const { props } = usePage();
const students = ref(props.students);

// Modal states
const displayViewModal = ref(false);
const selectedStudent = ref({});

// Address filter states
const divisions = ref(props.divisions || []);
const districts = ref(props.districts || []);
const thanas = ref(props.thanas || []);
const editForm = ref({ division: null, district: null }); // added to support filter

const filteredDistricts = computed(() =>
    districts.value.filter(d => d.division_id === editForm.value.division)
);
const filteredThanas = computed(() =>
    thanas.value.filter(t => t.district_id === editForm.value.district)
);

// Photo URL handler
function getPhotoUrl(photo) {
    if (!photo) {
        return 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
    }
    if (typeof photo === 'string' && (photo.startsWith('http://') || photo.startsWith('https://'))) {
        return photo;
    }
    if (typeof photo === 'string' && photo.startsWith('/')) {
        return photo;
    }
    if (typeof photo === 'string') {
        return `/storage/${photo}`;
    }
    return '';
}
function handleImageError(event) {
    event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjUwIiBjeT0iMzciIHI9IjE4IiBmaWxsPSIjOUI5QjlCIi8+CjxwYXRoIGQ9Ik0yMCA4MEM2IDgwIDM4IDY4IDUwIDY4QzYyIDY4IDk0IDgwIDgwIDgwSDE4WiIgZmlsbD0iIzlCOUI5QiIvPgo8L3N2Zz4=';
}

// Context menu action items based on student status
function getMenuItems(student) {
    const baseItems = [];

    // Approved: view, register, download card
    if (student.status === 'approved') {
        baseItems.push(
            {
                label: 'বিস্তারিত দেখুন',
                icon: 'pi pi-eye',
                command: () => router.visit(route('student.details', student.id)),
            },
            {
                label: 'রেজিস্ট্রেশন করুন',
                icon: 'pi pi-check-circle',
                command: () => {
                    // Registration logic here
                    console.log('রেজিস্ট্রেশন করুন:', student.id);
                },
            },
            {
                label: 'রেজিস্ট্রেশন কার্ড ডাউনলোড',
                icon: 'pi pi-download',
                command: () => downloadRegistrationCard(student.id),
            }
        );
    } else if (student.status === 'suspended') {
        // Suspended: no actions
        return [];
    } else if (student.status === 'rejected') {
        // Rejected: view only
        baseItems.push(
            {
                label: 'বিস্তারিত দেখুন',
                icon: 'pi pi-eye',
                command: () => router.visit(route('student.details', student.id)),
            }
            // If you want edit, uncomment below
            // {
            //     label: 'সম্পাদনা করুন',
            //     icon: 'pi pi-pencil',
            //     command: () => router.visit(route('student.edit', student.id)),
            // }
        );
    } else {
        // Pending or other status: view only
        baseItems.push(
            {
                label: 'বিস্তারিত দেখুন',
                icon: 'pi pi-eye',
                command: () => router.visit(route('student.details', student.id)),
            }
            // If you want edit, uncomment below
            // {
            //     label: 'সম্পাদনা করুন',
            //     icon: 'pi pi-pencil',
            //     command: () => router.visit(route('student.edit', student.id)),
            // }
        );
    }

    return baseItems;
}

// Registration card download logic
async function downloadRegistrationCard(studentId) {
    try {
        // Fetch card data
        const cardRes = await axios.get(`/student/${studentId}/card-data`);
        const cardData = cardRes.data;
        // Fetch QR code SVG
        const qrRes = await axios.get(`/student/${studentId}/card`);
        const qrCodeSvg = qrRes.data;

        // Create a temporary Vue node for the card
        const mountNode = document.createElement('div');
        document.body.appendChild(mountNode);
        const vnode = h(StudentRegistrationCard, {
            name: cardData.name,
            sessionYear: cardData.session_year,
            phone: cardData.phone,
            photoUrl: cardData.photo ? `/storage/${cardData.photo}` : '',
            qrCodeSvg,
        });
        render(vnode, mountNode);
        // Wait for DOM render
        setTimeout(() => {
            const cardEl = mountNode.querySelector('.registration-card');
            if (cardEl) {
                import('jspdf').then(({ default: jsPDF }) => {
                    import('html2canvas').then(({ default: html2canvas }) => {
                        html2canvas(cardEl).then(canvas => {
                            const imgData = canvas.toDataURL('image/png');
                            const pdf = new jsPDF({
                                orientation: 'portrait',
                                unit: 'px',
                                format: [cardEl.offsetWidth, cardEl.offsetHeight]
                            });
                            pdf.addImage(imgData, 'PNG', 0, 0, cardEl.offsetWidth, cardEl.offsetHeight);
                            pdf.save(`registration_card_${studentId}.pdf`);
                            document.body.removeChild(mountNode);
                        });
                    });
                });
            } else {
                document.body.removeChild(mountNode);
            }
        }, 500);
    } catch (err) {
        alert('কার্ড ডাউনলোড করতে সমস্যা হয়েছে!');
    }
}

// Date formatting utility
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('bn-BD', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Modal logic
function viewStudent(student) {
    selectedStudent.value = { ...student };
    displayViewModal.value = true;
}
function closeViewModal() {
    displayViewModal.value = false;
}
</script>


<style>
.admin-content-wrapper {
  background: #f4f6f9;
  min-height: 100vh;
}
.adminlte-card {
  border-radius: 0.6rem;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}
.adminlte-card-header {
  border-radius: 0.6rem 0.6rem 0 0;
  border-bottom: 1px solid #e3e6ef;
  box-shadow: 0 1px 4px rgba(44,62,80,.09);
}
.adminlte-card-body {
  border-radius: 0 0 0.6rem 0.6rem;
}
.adminlte-table .p-datatable-tbody tr {
  transition: background 0.2s;
}
.adminlte-table .p-datatable-tbody tr:hover {
  background: #f0f7fa;
}
.adminlte-avatar {
  background: #ecf0f5;
  box-shadow: 0 1px 3px rgba(44,62,80,.12);
}
.badge-purple {
  background-color: #6f42c1 !important;
  color: #fff !important;
}
.badge {
  border-radius: 0.5em !important;
  font-size: 0.92em !important;
  padding: 0.4em 0.7em !important;
}
.card-title i {
  vertical-align: middle;
}
</style>
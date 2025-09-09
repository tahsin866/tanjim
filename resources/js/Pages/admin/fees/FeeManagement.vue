<template>
  <Head title="ইভেন্ট ব্যবস্থাপনা" />
  
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto mt-8 p-6 bg-white rounded shadow border">
      <h2 class="text-2xl font-bold mb-6 text-center">ইভেন্ট ব্যবস্থাপনা সিস্টেম</h2>

      <!-- Tab Navigation -->
      <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'py-2 px-1 border-b-2 font-medium text-sm',
              activeTab === tab.id
                ? 'border-blue-500 text-blue-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            {{ tab.name }}
          </button>
        </nav>
      </div>

      <!-- Tab 1: মূল ইভেন্ট তৈরি -->
      <div v-show="activeTab === 'main-event'" class="space-y-6">
        <h3 class="text-xl font-semibold mb-4">মূল ইভেন্ট তৈরি করুন</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Event Form -->
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">ইভেন্টের নাম *</label>
              <input
                v-model="newMainEvent.name"
                type="text"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="যেমন: ৭০ সালানা অনুষ্ঠান"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">বিবরণ</label>
              <textarea
                v-model="newMainEvent.description"
                rows="4"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="ইভেন্টের বিস্তারিত বিবরণ লিখুন..."
              ></textarea>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">তারিখ</label>
              <input
                v-model="newMainEvent.date"
                type="date"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">স্থান</label>
              <input
                v-model="newMainEvent.location"
                type="text"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="ইভেন্টের স্থান"
              />
            </div>
            
            <button
              @click="addMainEvent"
              :disabled="!newMainEvent.name"
              class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white px-4 py-2 rounded-md font-medium"
            >
              মূল ইভেন্ট সংরক্ষণ করুন
            </button>
          </div>
          
          <!-- Existing Events List -->
          <div>
            <h4 class="text-lg font-medium mb-3">বিদ্যমান মূল ইভেন্টসমূহ</h4>
            <div class="space-y-2 max-h-96 overflow-y-auto">
              <div
                v-for="event in mainEvents"
                :key="event.id"
                class="p-3 border rounded-md bg-gray-50"
              >
                <div class="flex justify-between items-start">
                  <div>
                    <h5 class="font-medium">{{ event.name }}</h5>
                    <p class="text-sm text-gray-600">{{ event.description }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                      📅 {{ event.date }} | 📍 {{ event.location }}
                    </p>
                  </div>
                  <button
                    @click="deleteMainEvent(event.id)"
                    class="text-red-500 hover:text-red-700 text-sm"
                  >
                    ❌
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 2: সাব-ইভেন্ট তৈরি -->
      <div v-show="activeTab === 'sub-event'" class="space-y-6">
        <h3 class="text-xl font-semibold mb-4">সাব-ইভেন্ট তৈরি করুন</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Sub Event Form -->
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">মূল ইভেন্ট নির্বাচন করুন *</label>
              <select
                v-model="newSubEvent.parent_id"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                <option value="">-- নির্বাচন করুন --</option>
                <option v-for="event in mainEvents" :key="event.id" :value="event.id">
                  {{ event.name }}
                </option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">সাব-ইভেন্টের নাম *</label>
              <input
                v-model="newSubEvent.name"
                type="text"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="যেমন: তাকমিল, হিফজ, কিরাত"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">ফি (টাকায়) *</label>
              <input
                v-model.number="newSubEvent.fee"
                type="number"
                min="0"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="০"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">বিবরণ</label>
              <textarea
                v-model="newSubEvent.description"
                rows="3"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="সাব-ইভেন্টের বিবরণ..."
              ></textarea>
            </div>
            
            <button
              @click="addSubEvent"
              :disabled="!newSubEvent.name || !newSubEvent.parent_id || newSubEvent.fee < 0"
              class="w-full bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white px-4 py-2 rounded-md font-medium"
            >
              সাব-ইভেন্ট সংরক্ষণ করুন
            </button>
          </div>
          
          <!-- Existing Sub Events List -->
          <div>
            <h4 class="text-lg font-medium mb-3">বিদ্যমান সাব-ইভেন্টসমূহ</h4>
            <div class="space-y-2 max-h-96 overflow-y-auto">
              <div
                v-for="subEvent in subEvents"
                :key="subEvent.id"
                class="p-3 border rounded-md bg-blue-50"
              >
                <div class="flex justify-between items-start">
                  <div>
                    <h5 class="font-medium">{{ subEvent.name }}</h5>
                    <p class="text-sm text-blue-600">{{ getMainEventName(subEvent.parent_id) }}</p>
                    <p class="text-sm text-gray-600">{{ subEvent.description }}</p>
                    <p class="text-sm font-medium text-green-600 mt-1">ফি: {{ subEvent.fee }}৳</p>
                  </div>
                  <button
                    @click="deleteSubEvent(subEvent.id)"
                    class="text-red-500 hover:text-red-700 text-sm"
                  >
                    ❌
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 3: ছাড়/ডিসকাউন্ট ব্যবস্থাপনা -->
      <div v-show="activeTab === 'discount'" class="space-y-6">
        <h3 class="text-xl font-semibold mb-4">ছাড়/ডিসকাউন্ট ব্যবস্থাপনা</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Discount Form -->
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">ছাড়ের নাম *</label>
              <input
                v-model="newDiscount.name"
                type="text"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="যেমন: কম্বো ছাড়, আর্লি বার্ড ছাড়"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">ছাড়ের হার (%) *</label>
              <input
                v-model.number="newDiscount.percentage"
                type="number"
                min="0"
                max="100"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="১০"
              />
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">প্রযোজ্য সাব-ইভেন্টসমূহ *</label>
              <div class="space-y-2 max-h-40 overflow-y-auto border rounded-md p-3">
                <div
                  v-for="subEvent in subEvents"
                  :key="subEvent.id"
                  class="flex items-center"
                >
                  <input
                    type="checkbox"
                    :id="'discount-sub-' + subEvent.id"
                    :value="subEvent.id"
                    v-model="newDiscount.applicable_events"
                    class="mr-2"
                  />
                  <label :for="'discount-sub-' + subEvent.id" class="text-sm">
                    {{ subEvent.name }} ({{ getMainEventName(subEvent.parent_id) }}) - {{ subEvent.fee }}৳
                  </label>
                </div>
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">শর্তাবলী</label>
              <textarea
                v-model="newDiscount.conditions"
                rows="3"
                class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="ছাড় পাওয়ার শর্তাবলী..."
              ></textarea>
            </div>
            
            <button
              @click="addDiscount"
              :disabled="!newDiscount.name || !newDiscount.percentage || newDiscount.applicable_events.length === 0"
              class="w-full bg-purple-600 hover:bg-purple-700 disabled:bg-gray-400 text-white px-4 py-2 rounded-md font-medium"
            >
              ছাড় সংরক্ষণ করুন
            </button>
          </div>
          
          <!-- Existing Discounts List -->
          <div>
            <h4 class="text-lg font-medium mb-3">বিদ্যমান ছাড়সমূহ</h4>
            <div class="space-y-2 max-h-96 overflow-y-auto">
              <div
                v-for="discount in discounts"
                :key="discount.id"
                class="p-3 border rounded-md bg-purple-50"
              >
                <div class="flex justify-between items-start">
                  <div>
                    <h5 class="font-medium">{{ discount.name }}</h5>
                    <p class="text-sm text-purple-600 font-medium">{{ discount.percentage }}% ছাড়</p>
                    <p class="text-sm text-gray-600 mt-1">{{ discount.conditions }}</p>
                    <div class="mt-2">
                      <p class="text-xs text-gray-500 mb-1">প্রযোজ্য ইভেন্টসমূহ:</p>
                      <div class="flex flex-wrap gap-1">
                        <span
                          v-for="eventId in discount.applicable_events"
                          :key="eventId"
                          class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded"
                        >
                          {{ getSubEventName(eventId) }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <button
                    @click="deleteDiscount(discount.id)"
                    class="text-red-500 hover:text-red-700 text-sm"
                  >
                    ❌
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab 4: ফি ক্যালকুলেটর -->
      <div v-show="activeTab === 'calculator'" class="space-y-6">
        <h3 class="text-xl font-semibold mb-4">ফি ক্যালকুলেটর</h3>
        
        <div class="max-w-2xl mx-auto">
          <!-- Parent Event Selection -->
          <div class="mb-4">
            <label class="block mb-2 font-semibold">মূল ইভেন্ট নির্বাচন করুন:</label>
            <select v-model="calculator.selectedParent" class="w-full border rounded-md px-3 py-2">
              <option value="">-- নির্বাচন করুন --</option>
              <option v-for="event in mainEvents" :value="event.id" :key="event.id">
                {{ event.name }}
              </option>
            </select>
          </div>

          <!-- Sub Event Checkboxes -->
          <div v-if="calculatorSubEvents.length" class="mb-4">
            <label class="block mb-2 font-semibold">সাব-ক্যাটাগরি নির্বাচন করুন:</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              <div v-for="subEvent in calculatorSubEvents" :key="subEvent.id" class="flex items-center p-2 border rounded">
                <input
                  type="checkbox"
                  :id="'calc-sub-'+subEvent.id"
                  :value="subEvent.id"
                  v-model="calculator.selectedSubs"
                  class="mr-2"
                />
                <label :for="'calc-sub-'+subEvent.id" class="flex-1">
                  {{ subEvent.name }}
                  <span class="text-sm text-green-600 font-medium">({{ subEvent.fee }}৳)</span>
                </label>
              </div>
            </div>
          </div>

          <!-- Discount Selection -->
          <div v-if="calculator.selectedSubs.length" class="mb-4">
            <label class="block mb-2 font-semibold">ছাড়/ডিসকাউন্ট:</label>
            <select v-model="calculator.selectedDiscount" class="w-full border rounded-md px-3 py-2">
              <option value="">-- কোনো ছাড় নেই --</option>
              <option v-for="discount in applicableDiscounts" :value="discount.id" :key="discount.id">
                {{ discount.name }} ({{ discount.percentage }}% ছাড়)
              </option>
            </select>
          </div>

          <!-- Fee Summary -->
          <div v-if="calculator.selectedSubs.length" class="bg-gray-50 border rounded-md p-4 mb-4">
            <h4 class="font-semibold mb-3">ফি সারসংক্ষেপ</h4>
            
            <div class="space-y-2">
              <div v-for="subId in calculator.selectedSubs" :key="subId" class="flex justify-between">
                <span>{{ getSubEventName(subId) }}</span>
                <span>{{ getSubEventFee(subId) }}৳</span>
              </div>
            </div>
            
            <hr class="my-3">
            
            <div class="flex justify-between py-1">
              <span>মোট ফি:</span>
              <span class="font-medium">{{ calculatorTotalFee }}৳</span>
            </div>
            
            <div v-if="calculatorDiscountPercent > 0" class="flex justify-between py-1">
              <span>ছাড় ({{ calculatorDiscountPercent }}%):</span>
              <span class="text-green-700 font-medium">-{{ calculatorDiscountAmount }}৳</span>
            </div>
            
            <hr class="my-2">
            
            <div class="flex justify-between font-bold text-lg">
              <span>পরিশোধযোগ্য মোট ফি:</span>
              <span class="text-blue-600">{{ calculatorFinalFee }}৳</span>
            </div>
          </div>

          <!-- Submit Button -->
          <button
            v-if="calculator.selectedSubs.length"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-bold"
            @click="submitCalculation"
          >
            ফি নিশ্চিত করুন
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/admin/AuthenticatedLayout.vue';

// Tab Management
const activeTab = ref('main-event');
const tabs = [
  { id: 'main-event', name: '১. মূল ইভেন্ট' },
  { id: 'sub-event', name: '২. সাব-ইভেন্ট' },
  { id: 'discount', name: '৩. ছাড় ব্যবস্থাপনা' },
  { id: 'calculator', name: '৪. ফি ক্যালকুলেটর' }
];

// Data Storage
const mainEvents = ref([
  { id: 1, name: '৭০ সালানা অনুষ্ঠান', description: 'বার্ষিক প্রতিযোগিতা', date: '2024-12-31', location: 'মাদরাসা প্রাঙ্গণ' }
]);

const subEvents = ref([
  { id: 1, parent_id: 1, name: 'তাকমিল', fee: 1000, description: 'তাকমিল প্রতিযোগিতা' },
  { id: 2, parent_id: 1, name: 'হিফজ', fee: 800, description: 'হিফজ প্রতিযোগিতা' },
  { id: 3, parent_id: 1, name: 'কিরাত', fee: 900, description: 'কিরাত প্রতিযোগিতা' },
  { id: 4, parent_id: 1, name: 'আদব', fee: 850, description: 'আদব প্রতিযোগিতা' },
  { id: 5, parent_id: 1, name: 'ইফতা', fee: 950, description: 'ইফতা প্রতিযোগিতা' },
  { id: 6, parent_id: 1, name: 'হিতাকাঙ্খি', fee: 700, description: 'হিতাকাঙ্খি বিভাগ' }
]);

const discounts = ref([
  { 
    id: 1, 
    name: 'কম্বো ছাড় (সব ক্যাটাগরি)', 
    percentage: 10, 
    applicable_events: [1, 2, 3, 4, 5, 6],
    conditions: 'সকল ক্যাটাগরিতে অংশগ্রহণ করলে ১০% ছাড়'
  }
]);

// Form Data
const newMainEvent = ref({
  name: '',
  description: '',
  date: '',
  location: ''
});

const newSubEvent = ref({
  parent_id: '',
  name: '',
  fee: 0,
  description: ''
});

const newDiscount = ref({
  name: '',
  percentage: 0,
  applicable_events: [],
  conditions: ''
});

// Calculator Data
const calculator = ref({
  selectedParent: '',
  selectedSubs: [],
  selectedDiscount: ''
});

// Helper Functions
let nextMainEventId = 2;
let nextSubEventId = 7;
let nextDiscountId = 2;

const getMainEventName = (id) => {
  const event = mainEvents.value.find(e => e.id === id);
  return event ? event.name : 'অজানা ইভেন্ট';
};

const getSubEventName = (id) => {
  const event = subEvents.value.find(e => e.id === id);
  return event ? event.name : 'অজানা সাব-ইভেন্ট';
};

const getSubEventFee = (id) => {
  const event = subEvents.value.find(e => e.id === id);
  return event ? event.fee : 0;
};

// Main Event Functions
const addMainEvent = () => {
  if (!newMainEvent.value.name) return;
  
  mainEvents.value.push({
    id: nextMainEventId++,
    ...newMainEvent.value
  });
  
  // Reset form
  newMainEvent.value = {
    name: '',
    description: '',
    date: '',
    location: ''
  };
};

const deleteMainEvent = (id) => {
  if (confirm('এই ইভেন্ট মুছে ফেলতে চান?')) {
    mainEvents.value = mainEvents.value.filter(e => e.id !== id);
    // Also remove related sub events
    subEvents.value = subEvents.value.filter(e => e.parent_id !== id);
  }
};

// Sub Event Functions
const addSubEvent = () => {
  if (!newSubEvent.value.name || !newSubEvent.value.parent_id) return;
  
  subEvents.value.push({
    id: nextSubEventId++,
    ...newSubEvent.value
  });
  
  // Reset form
  newSubEvent.value = {
    parent_id: '',
    name: '',
    fee: 0,
    description: ''
  };
};

const deleteSubEvent = (id) => {
  if (confirm('এই সাব-ইভেন্ট মুছে ফেলতে চান?')) {
    subEvents.value = subEvents.value.filter(e => e.id !== id);
    // Remove from discounts
    discounts.value.forEach(d => {
      d.applicable_events = d.applicable_events.filter(eventId => eventId !== id);
    });
  }
};

// Discount Functions
const addDiscount = () => {
  if (!newDiscount.value.name || !newDiscount.value.percentage || newDiscount.value.applicable_events.length === 0) return;
  
  discounts.value.push({
    id: nextDiscountId++,
    ...newDiscount.value
  });
  
  // Reset form
  newDiscount.value = {
    name: '',
    percentage: 0,
    applicable_events: [],
    conditions: ''
  };
};

const deleteDiscount = (id) => {
  if (confirm('এই ছাড় মুছে ফেলতে চান?')) {
    discounts.value = discounts.value.filter(d => d.id !== id);
  }
};

// Calculator Computed Properties
const calculatorSubEvents = computed(() => {
  return subEvents.value.filter(e => e.parent_id == calculator.value.selectedParent);
});

const calculatorTotalFee = computed(() => {
  return calculator.value.selectedSubs.reduce((sum, subId) => {
    return sum + getSubEventFee(subId);
  }, 0);
});

const applicableDiscounts = computed(() => {
  return discounts.value.filter(discount => {
    return discount.applicable_events.every(eventId => 
      calculator.value.selectedSubs.includes(eventId)
    );
  });
});

const calculatorDiscountPercent = computed(() => {
  const discount = discounts.value.find(d => d.id == calculator.value.selectedDiscount);
  return discount ? discount.percentage : 0;
});

const calculatorDiscountAmount = computed(() => {
  return Math.round((calculatorTotalFee.value * calculatorDiscountPercent.value) / 100);
});

const calculatorFinalFee = computed(() => {
  return calculatorTotalFee.value - calculatorDiscountAmount.value;
});

// Calculator Watchers
watch(() => calculator.value.selectedParent, () => {
  calculator.value.selectedSubs = [];
  calculator.value.selectedDiscount = '';
});

watch(() => calculator.value.selectedSubs, () => {
  if (calculator.value.selectedDiscount && 
      !applicableDiscounts.value.some(d => d.id == calculator.value.selectedDiscount)) {
    calculator.value.selectedDiscount = '';
  }
});

// Submit Function
const submitCalculation = () => {
  const selectedSubNames = calculator.value.selectedSubs.map(id => getSubEventName(id)).join(', ');
  const discountName = discounts.value.find(d => d.id == calculator.value.selectedDiscount)?.name || 'কোনো ছাড় নেই';
  
  alert(`
নির্বাচিত ইভেন্ট: ${getMainEventName(calculator.value.selectedParent)}
নির্বাচিত সাব-ইভেন্ট: ${selectedSubNames}
মোট ফি: ${calculatorTotalFee.value}৳
ছাড়: ${discountName} (-${calculatorDiscountAmount.value}৳)
পরিশোধযোগ্য মোট: ${calculatorFinalFee.value}৳
  `);
  
  // এখানে API call করে ডাটাবেসে সেভ করবেন
};
</script>
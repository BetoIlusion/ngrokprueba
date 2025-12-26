<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import Modal from '@/Components/Modal.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Banner from '@/Components/Banner.vue';
import { ref } from 'vue';

// Modal state
const showModal = ref(false);
const closeModal = () => {
    showModal.value = false;
};

// Banner states for demonstration
const showSuccessBanner = ref(false);
const showDangerBanner = ref(false);
const showInfoBanner = ref(false); // Assuming you might add an 'info' style later

// Filter states
const searchText = ref('');
const selectedStatus = ref('all');
const selectedCategory = ref('all');
const showFeatured = ref(false);

// Loading state
const isLoading = ref(false);
</script>

<template>
    <AppLayout title="Components Demo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Components Demo
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Buttons</h3>
                    <div class="flex space-x-4">
                        <PrimaryButton>Primary</PrimaryButton>
                        <SecondaryButton>Secondary</SecondaryButton>
                        <DangerButton>Danger</DangerButton>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Form Elements</h3>
                        <div class="space-y-4">
                            <div>
                                <InputLabel for="text_input" value="Text Input" />
                                <TextInput id="text_input" type="text" class="mt-1 block w-full" placeholder="Enter text..." />
                                <InputError message="This is an error message." class="mt-2" />
                            </div>
                            <div class="flex items-center">
                                <Checkbox id="checkbox" />
                                <label for="checkbox" class="ml-2 text-sm text-gray-600">Remember me</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dropdown</h3>
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        Dropdown
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink href="#">
                                    Profile
                                </DropdownLink>
                                <DropdownLink href="#">
                                    Settings
                                </DropdownLink>
                                <div class="border-t border-gray-100"></div>
                                <DropdownLink href="#">
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Modal</h3>
                        <PrimaryButton @click="showModal = true">Show Modal</PrimaryButton>
                        <Modal :show="showModal" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Modal Title
                                </h2>

                                <p class="mt-4 text-sm text-gray-600">
                                    This is the modal content. You can put any content here.
                                </p>

                                <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeModal">
                                        Cancel
                                    </SecondaryButton>

                                    <PrimaryButton class="ml-3" @click="closeModal">
                                        Confirm
                                    </PrimaryButton>
                                </div>
                            </div>
                        </Modal>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Banner</h3>
                        <div class="space-y-4">
                            <PrimaryButton @click="showSuccessBanner = true; showDangerBanner = false; showInfoBanner = false;">Show Success Banner</PrimaryButton>
                            <DangerButton @click="showDangerBanner = true; showSuccessBanner = false; showInfoBanner = false;">Show Danger Banner</DangerButton>
                            <!-- You can add an 'info' banner if you extend the Banner component -->
                            <!-- <SecondaryButton @click="showInfoBanner = true; showSuccessBanner = false; showDangerBanner = false;">Show Info Banner</SecondaryButton> -->
                        </div>
                        <Banner v-if="showSuccessBanner" message="¡Operación completada con éxito!" style="success" class="mt-4" />
                        <Banner v-if="showDangerBanner" message="¡Ha ocurrido un error inesperado!" style="danger" class="mt-4" />
                        <!-- <Banner v-if="showInfoBanner" message="Información importante a considerar." style="info" class="mt-4" /> -->
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Examples</h3>
                        <div class="space-y-4 p-4 border rounded-lg bg-gray-50">
                            <!-- Text Search Filter -->
                            <div>
                                <InputLabel for="search_filter" value="Search" />
                                <TextInput
                                    id="search_filter"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="searchText"
                                    placeholder="Search by name or keyword..."
                                />
                            </div>

                            <!-- Status Dropdown Filter -->
                            <div>
                                <InputLabel for="status_filter" value="Status" />
                                <select
                                    id="status_filter"
                                    v-model="selectedStatus"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="all">All</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>

                            <!-- Category Dropdown Filter -->
                            <div>
                                <InputLabel for="category_filter" value="Category" />
                                <select
                                    id="category_filter"
                                    v-model="selectedCategory"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option value="all">All Categories</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="books">Books</option>
                                </select>
                            </div>

                            <!-- Checkbox Filter -->
                            <div class="flex items-center">
                                <Checkbox id="featured_filter" v-model:checked="showFeatured" />
                                <label for="featured_filter" class="ml-2 text-sm text-gray-600">Show Featured Items Only</label>
                            </div>

                            <div class="mt-4 text-sm text-gray-700">
                                <p>Current Filters:</p>
                                <ul>
                                    <li>Search: "{{ searchText }}"</li>
                                    <li>Status: {{ selectedStatus }}</li>
                                    <li>Category: {{ selectedCategory }}</li>
                                    <li>Featured: {{ showFeatured ? 'Yes' : 'No' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Other Useful Components</h3>

                        <!-- Loading Indicator -->
                        <div class="mb-6">
                            <h4 class="text-md font-medium text-gray-800 mb-2">Loading State</h4>
                            <PrimaryButton @click="isLoading = !isLoading">Toggle Loading</PrimaryButton>
                            <div v-if="isLoading" class="mt-2 p-4 bg-blue-100 text-blue-800 rounded-md flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Loading data...</span>
                            </div>
                        </div>

                        <!-- Simple Pagination -->
                        <div>
                            <h4 class="text-md font-medium text-gray-800 mb-2">Pagination</h4>
                            <div class="flex space-x-2">
                                <SecondaryButton>&laquo; Previous</SecondaryButton>
                                <PrimaryButton>1</PrimaryButton>
                                <SecondaryButton>2</SecondaryButton>
                                <SecondaryButton>3</SecondaryButton>
                                <SecondaryButton>Next &raquo;</SecondaryButton>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

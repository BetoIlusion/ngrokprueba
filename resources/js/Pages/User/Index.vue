<template>
    <AppLayout title="Users">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Lista de Empleados
                </h2>
                <PrimaryButton @click="openModal">
                    Nuevo Usuario
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Lista :users="users" @view="handleView" @edit="handleEdit" @message="handleMessage"
                    @permissions="handlePermissions" @delete="handleDelete" />
            </div>
        </div>

        <!-- Create User Modal -->
        <CreateModal :show="showCreateModal" @close="closeModal" />
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Lista from './Components/Lista.vue';
import CreateModal from './Components/CreateModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true,
        default: () => []
    }
});

const showCreateModal = ref(false);

const openModal = () => {
    showCreateModal.value = true;
};

const closeModal = () => {
    showCreateModal.value = false;
};

// Event handlers
const handleView = (userRel) => {
    console.log('Ver usuario:', userRel);
};

const handleEdit = (userRel) => {
    console.log('Editar usuario:', userRel);
};

const handleMessage = (userRel) => {
    console.log('Enviar mensaje a:', userRel);
};

const handlePermissions = (userRel) => {
    console.log('Ver permisos de:', userRel);
};

const handleDelete = (userRel) => {
    if (confirm('¿Estás seguro de que deseas eliminar esta relación de usuario?')) {
        console.log('Eliminar usuario:', userRel);
        // Aquí puedes realizar la llamada a Inertia para eliminar
    }
};
</script>

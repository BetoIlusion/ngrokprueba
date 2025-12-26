<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <!-- Search and Filters -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1">
                    <div class="relative">
                        <input v-model="searchQuery" placeholder="Buscar por nombre o email..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <div class="flex gap-2 items-center">
                    <button @click="clearFilters"
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha Registro
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="userRel in filteredUsers" :key="userRel.id" class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ userRel.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full"
                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(userRel.sub_user?.name || 'Usuario')}&background=random&color=fff`"
                                        :alt="userRel.sub_user?.name || 'Usuario'" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ userRel.sub_user?.name || 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ userRel.sub_user?.email || 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ formatDate(userRel.created_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 rounded text-sm bg-green-50 text-green-700">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Ver detalles button -->
                                <button @click="viewUser(userRel)"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-eye mr-1"></i> Ver
                                </button>

                                <!-- Menu dropdown -->
                                <div class="relative dropdown-container">
                                    <button @click.stop="toggleMenu(userRel.id)"
                                        class="p-2 bg-white border rounded-full hover:shadow-sm transition-shadow">
                                        <i class="fas fa-ellipsis-v text-gray-600"></i>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div v-if="openMenuId === userRel.id"
                                        class="absolute right-0 mt-2 w-44 bg-white border rounded shadow-lg z-50 text-left">
                                        <button @click="editUser(userRel)"
                                            class="w-full text-left px-3 py-2 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-edit mr-2 text-gray-600"></i>
                                            Editar
                                        </button>
                                        <button @click="sendMessage(userRel)"
                                            class="w-full text-left px-3 py-2 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-envelope mr-2 text-gray-600"></i>
                                            Enviar mensaje
                                        </button>
                                        <button @click="viewPermissions(userRel)"
                                            class="w-full text-left px-3 py-2 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-shield-alt mr-2 text-gray-600"></i>
                                            Permisos
                                        </button>
                                        <div class="border-t my-1"></div>
                                        <button @click="deleteUser(userRel)"
                                            class="w-full text-left px-3 py-2 text-rose-600 hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-trash mr-2"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Empty state -->
                    <tr v-if="filteredUsers.length === 0">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                            <p>No se encontraron usuarios</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination info -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">{{ filteredUsers.length }}</span> de
                    <span class="font-medium">{{ users.length }}</span> usuarios
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        required: true,
        default: () => []
    }
});

const searchQuery = ref('');
const openMenuId = ref(null);

const filteredUsers = computed(() => {
    const query = searchQuery.value.toLowerCase().trim();

    if (!query) {
        return props.users;
    }

    return props.users.filter(userRel => {
        const name = (userRel.sub_user?.name || '').toLowerCase();
        const email = (userRel.sub_user?.email || '').toLowerCase();
        const id = String(userRel.id);

        return name.includes(query) ||
            email.includes(query) ||
            id === query;
    });
});

const toggleMenu = (id) => {
    openMenuId.value = openMenuId.value === id ? null : id;
};

const clearFilters = () => {
    searchQuery.value = '';
};

const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

// Emits for actions
const emit = defineEmits(['view', 'edit', 'message', 'permissions', 'delete']);

const viewUser = (userRel) => {
    emit('view', userRel);
    openMenuId.value = null;
};

const editUser = (userRel) => {
    emit('edit', userRel);
    openMenuId.value = null;
};

const sendMessage = (userRel) => {
    emit('message', userRel);
    openMenuId.value = null;
};

const viewPermissions = (userRel) => {
    emit('permissions', userRel);
    openMenuId.value = null;
};

const deleteUser = (userRel) => {
    emit('delete', userRel);
    openMenuId.value = null;
};

const closeMenu = (e) => {
    if (!e.target.closest('.dropdown-container')) {
        openMenuId.value = null;
    }
};

onMounted(() => {
    if (typeof document !== 'undefined') {
        document.addEventListener('click', closeMenu);
    }
});

onUnmounted(() => {
    if (typeof document !== 'undefined') {
        document.removeEventListener('click', closeMenu);
    }
});
</script>

<style scoped>
.transition-colors {
    transition: background-color 0.2s ease, color 0.2s ease;
}

.transition-shadow {
    transition: box-shadow 0.2s ease;
}

.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

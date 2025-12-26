<template>
    <Modal :show="show" @close="close">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Añadir Nuevo Usuario
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="username" value="ID del Usuario (Ej: secretario-123)" />
                    <TextInput id="username" v-model="form.username" type="text" class="mt-1 block w-full"
                        placeholder="Nombre de usuario" required />
                    <InputError :message="form.errors.username" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full"
                        placeholder="Contraseña" required />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="role" value="Rol" />
                    <select id="role" v-model="form.role"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>
                        <option value="" disabled>Seleccione un rol</option>
                        <option value="admin">Administrador</option>
                        <option value="secretario">Secretario</option>
                        <option value="gerente">Gerente</option>
                        <option value="operario">Operario</option>
                    </select>
                    <InputError :message="form.errors.role" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <SecondaryButton @click="close">
                        Cancelar
                    </SecondaryButton>

                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    show: Boolean,
});

const emit = defineEmits(['close']);

const form = useForm({
    username: '',
    password: '',
    role: '',
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            close();
            form.reset();
        },
    });
};

const close = () => {
    emit('close');
};
</script>

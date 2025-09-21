<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    cnpj: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

const togglePasswordConfirmation = () => {
    showPasswordConfirmation.value = !showPasswordConfirmation.value;
};

// Função para formatar CNPJ
const formatCNPJ = (value) => {
    const numbers = value.replace(/\D/g, '');
    return numbers.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
};

const handleCNPJInput = (event) => {
    const formatted = formatCNPJ(event.target.value);
    form.cnpj = formatted;
    event.target.value = formatted;
};
</script>

<template>
    <Head title="Cadastro de Empresa" />
    
    <div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-8">
                <!-- Título -->
                <h1 class="text-3xl font-semibold text-white text-center mb-8">
                    Cadastro de Empresa
                </h1>

                <!-- Formulário -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Campo CNPJ -->
                    <div>
                        <label for="cnpj" class="block text-sm font-medium text-gray-300 mb-2">
                            CNPJ *
                        </label>
                        <input
                            id="cnpj"
                            type="text"
                            v-model="form.cnpj"
                            @input="handleCNPJInput"
                            class="input-field w-full"
                            placeholder="00.000.000/0000-00"
                            maxlength="18"
                            required
                            autofocus
                        />
                        <div v-if="form.errors.cnpj" class="mt-2 text-sm text-red-400">
                            {{ form.errors.cnpj }}
                        </div>
                    </div>

                    <!-- Campo Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Senha *
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                v-model="form.password"
                                class="input-field w-full pr-12"
                                placeholder="Digite sua senha"
                                required
                                autocomplete="new-password"
                            />
                            <button
                                type="button"
                                @click="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors"
                            >
                                <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <div v-if="form.errors.password" class="mt-2 text-sm text-red-400">
                            {{ form.errors.password }}
                        </div>
                    </div>

                    <!-- Campo Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                            Confirmar Senha *
                        </label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                :type="showPasswordConfirmation ? 'text' : 'password'"
                                v-model="form.password_confirmation"
                                class="input-field w-full pr-12"
                                placeholder="Confirme sua senha"
                                required
                                autocomplete="new-password"
                            />
                            <button
                                type="button"
                                @click="togglePasswordConfirmation"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors"
                            >
                                <svg v-if="!showPasswordConfirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        <div v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-400">
                            {{ form.errors.password_confirmation }}
                        </div>
                    </div>

                    <!-- Botão Sign Up -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="btn-primary w-full"
                        :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                    >
                        Cadastrar Empresa
                    </button>

                    <!-- Link para Login -->
                    <div class="text-center text-sm text-gray-400 mt-4">
                        Já tem uma conta? 
                        <Link :href="route('login')" class="text-white hover:underline">
                            Fazer Login
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

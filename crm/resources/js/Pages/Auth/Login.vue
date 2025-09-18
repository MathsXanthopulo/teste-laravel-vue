<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};

// Função para formatar CNPJ
const formatCNPJ = (value) => {
    const numbers = value.replace(/\D/g, '');
    return numbers.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
};

const handleLoginInput = (event) => {
    const value = event.target.value;
    // Se parece com CNPJ (números), formata como CNPJ
    if (/^\d/.test(value.replace(/\D/g, ''))) {
        const formatted = formatCNPJ(value);
        form.login = formatted;
        event.target.value = formatted;
    } else {
        form.login = value;
    }
};
</script>

<template>
    <Head title="Sign in" />
    
    <div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
        <div class="w-full max-w-6xl bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="flex h-[600px]">
                <!-- Seção Esquerda - Formulário -->
                <div class="flex-1 bg-gray-800 p-12 flex flex-col justify-center">
                    <div class="max-w-md mx-auto w-full">
                        <!-- Título -->
                        <h1 class="text-3xl font-semibold text-white text-center mb-12">
                            Sign in
                        </h1>

                        <!-- Mensagem de Status -->
                        <div v-if="status" class="mb-6 p-4 bg-green-600 text-white rounded-lg text-center">
                            {{ status }}
                        </div>

                        <!-- Formulário -->
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Campo Login (Email ou CNPJ) -->
                            <div>
                                <label for="login" class="block text-sm font-medium text-gray-300 mb-2">
                                    E-mail ou CNPJ
                                </label>
                                <input
                                    id="login"
                                    type="text"
                                    v-model="form.login"
                                    class="input-field w-full"
                                    placeholder="Digite seu e-mail ou CNPJ"
                                    required
                                    autofocus
                                />
                                <div v-if="form.errors.login" class="mt-2 text-sm text-red-400">
                                    {{ form.errors.login }}
                                </div>
                            </div>

                            <!-- Campo Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        :type="showPassword ? 'text' : 'password'"
                                        v-model="form.password"
                                        class="input-field w-full pr-12"
                                        placeholder="Enter your password"
                                        required
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
                            </div>

                            <!-- Botão Sign In -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="btn-primary w-full"
                                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                            >
                                Sign in
                            </button>

                            <!-- Links -->
                            <div class="text-center">
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm text-gray-400 hover:text-white transition-colors"
                                >
                                    Forget password?
                                </Link>
                            </div>

                            <div class="text-center text-sm text-gray-400">
                                Don't have an account? 
                                <Link :href="route('register')" class="text-white hover:underline">
                                    Sign up
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Seção Direita - Visual Espacial -->
                <div class="w-1/3 space-bg relative overflow-hidden">
                    <!-- Elementos visuais espaciais -->
                    <div class="absolute inset-0">
                        <!-- Linhas de luz verticais -->
                        <div class="absolute left-1/4 top-0 w-px h-full bg-white opacity-20"></div>
                        <div class="absolute left-3/4 top-0 w-px h-full bg-white opacity-15"></div>
                        <div class="absolute left-1/2 top-0 w-px h-full bg-white opacity-10"></div>
                        
                        <!-- Estrelas -->
                        <div class="absolute top-20 left-8 w-1 h-1 bg-white rounded-full opacity-60"></div>
                        <div class="absolute top-32 left-16 w-1 h-1 bg-white rounded-full opacity-40"></div>
                        <div class="absolute top-48 left-12 w-1 h-1 bg-white rounded-full opacity-80"></div>
                        <div class="absolute top-64 left-20 w-1 h-1 bg-white rounded-full opacity-50"></div>
                        <div class="absolute top-80 left-6 w-1 h-1 bg-white rounded-full opacity-70"></div>
                        <div class="absolute top-96 left-14 w-1 h-1 bg-white rounded-full opacity-30"></div>
                        <div class="absolute top-40 left-24 w-1 h-1 bg-white rounded-full opacity-60"></div>
                        <div class="absolute top-72 left-18 w-1 h-1 bg-white rounded-full opacity-45"></div>
                        
                        <!-- Planeta maior (centro inferior) -->
                        <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full shadow-2xl shadow-blue-500/50"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-300 to-blue-500 rounded-full opacity-60 blur-sm"></div>
                        </div>
                        
                        <!-- Planeta menor (canto superior direito) -->
                        <div class="absolute top-16 right-8">
                            <div class="w-12 h-12 bg-gradient-to-br from-white to-gray-300 rounded-full shadow-xl shadow-white/30"></div>
                            <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-200 rounded-full opacity-40 blur-sm"></div>
                        </div>
                    </div>
                    
                    <!-- Logo -->
                    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
                        <div class="text-white text-2xl font-bold tracking-wider">
                            comet
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    cnpj: '',
    company_name: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    zip_code: '',
    password: '',
    password_confirmation: '',
    user_type: 'company',
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

// Função para formatar CEP
const formatCEP = (value) => {
    const numbers = value.replace(/\D/g, '');
    return numbers.replace(/^(\d{5})(\d{3})$/, '$1-$2');
};

const handleCEPInput = (event) => {
    const formatted = formatCEP(event.target.value);
    form.zip_code = formatted;
    event.target.value = formatted;
};

// Função para formatar telefone
const formatPhone = (value) => {
    const numbers = value.replace(/\D/g, '');
    if (numbers.length <= 10) {
        return numbers.replace(/^(\d{2})(\d{4})(\d{4})$/, '($1) $2-$3');
    } else {
        return numbers.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
    }
};

const handlePhoneInput = (event) => {
    const formatted = formatPhone(event.target.value);
    form.phone = formatted;
    event.target.value = formatted;
};
</script>

<template>
    <Head title="Cadastro de Empresa" />
    
    <div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
        <div class="w-full max-w-7xl bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="flex min-h-[800px]">
                <!-- Seção Esquerda - Formulário -->
                <div class="flex-1 bg-gray-800 p-6 flex flex-col justify-start overflow-y-auto">
                    <div class="max-w-2xl mx-auto w-full py-8">
                        <!-- Título -->
                        <h1 class="text-3xl font-semibold text-white text-center mb-12">
                            Cadastro de Empresa
                        </h1>

                        <!-- Formulário -->
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Dados Pessoais -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Campo Nome -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                        Nome Completo *
                                    </label>
                                    <input
                                        id="name"
                                        type="text"
                                        v-model="form.name"
                                        class="input-field w-full"
                                        placeholder="Digite seu nome completo"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                    <div v-if="form.errors.name" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Campo Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                        E-mail *
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        v-model="form.email"
                                        class="input-field w-full"
                                        placeholder="Digite seu e-mail"
                                        required
                                        autocomplete="username"
                                    />
                                    <div v-if="form.errors.email" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.email }}
                                    </div>
                                </div>
                            </div>

                            <!-- Dados da Empresa -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                    />
                                    <div v-if="form.errors.cnpj" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.cnpj }}
                                    </div>
                                </div>

                                <!-- Campo Nome da Empresa -->
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">
                                        Razão Social *
                                    </label>
                                    <input
                                        id="company_name"
                                        type="text"
                                        v-model="form.company_name"
                                        class="input-field w-full"
                                        placeholder="Digite a razão social da empresa"
                                        required
                                    />
                                    <div v-if="form.errors.company_name" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.company_name }}
                                    </div>
                                </div>
                            </div>

                            <!-- Contato -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Campo Telefone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                                        Telefone *
                                    </label>
                                    <input
                                        id="phone"
                                        type="text"
                                        v-model="form.phone"
                                        @input="handlePhoneInput"
                                        class="input-field w-full"
                                        placeholder="(00) 00000-0000"
                                        maxlength="15"
                                        required
                                    />
                                    <div v-if="form.errors.phone" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.phone }}
                                    </div>
                                </div>

                                <!-- Campo CEP -->
                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-300 mb-2">
                                        CEP *
                                    </label>
                                    <input
                                        id="zip_code"
                                        type="text"
                                        v-model="form.zip_code"
                                        @input="handleCEPInput"
                                        class="input-field w-full"
                                        placeholder="00000-000"
                                        maxlength="9"
                                        required
                                    />
                                    <div v-if="form.errors.zip_code" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.zip_code }}
                                    </div>
                                </div>
                            </div>

                            <!-- Endereço -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-300 mb-2">
                                    Endereço *
                                </label>
                                <input
                                    id="address"
                                    type="text"
                                    v-model="form.address"
                                    class="input-field w-full"
                                    placeholder="Rua, número, bairro"
                                    required
                                />
                                <div v-if="form.errors.address" class="mt-2 text-sm text-red-400">
                                    {{ form.errors.address }}
                                </div>
                            </div>

                            <!-- Cidade e Estado -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-300 mb-2">
                                        Cidade *
                                    </label>
                                    <input
                                        id="city"
                                        type="text"
                                        v-model="form.city"
                                        class="input-field w-full"
                                        placeholder="Cidade"
                                        required
                                    />
                                    <div v-if="form.errors.city" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.city }}
                                    </div>
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-300 mb-2">
                                        Estado *
                                    </label>
                                    <input
                                        id="state"
                                        type="text"
                                        v-model="form.state"
                                        class="input-field w-full"
                                        placeholder="UF"
                                        maxlength="2"
                                        required
                                    />
                                    <div v-if="form.errors.state" class="mt-2 text-sm text-red-400">
                                        {{ form.errors.state }}
                                    </div>
                                </div>
                            </div>

                            <!-- Senhas -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

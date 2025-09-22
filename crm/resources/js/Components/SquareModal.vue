<script setup>
import { computed } from 'vue';
import { X } from 'lucide-vue-next';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: ''
    },
    size: {
        type: String,
        default: 'md', // sm, md, lg, xl
        validator: (value) => ['sm', 'md', 'lg', 'xl'].includes(value)
    },
    closable: {
        type: Boolean,
        default: true
    },
    persistent: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['close', 'update:show']);

const modalSize = computed(() => {
    const sizes = {
        sm: 'max-w-sm',
        md: 'max-w-md',
        lg: 'max-w-lg',
        xl: 'max-w-xl'
    };
    return sizes[props.size] || sizes.md;
});

const closeModal = () => {
    if (!props.persistent) {
        emit('close');
        emit('update:show', false);
    }
};

const handleBackdropClick = (event) => {
    if (event.target === event.currentTarget && !props.persistent) {
        closeModal();
    }
};

// Fechar com ESC
const handleKeydown = (event) => {
    if (event.key === 'Escape' && !props.persistent) {
        closeModal();
    }
};
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-50 overflow-y-auto"
                @click="handleBackdropClick"
                @keydown="handleKeydown"
                tabindex="-1"
            >
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
                
                <!-- Modal Container -->
                <div class="flex min-h-full items-center justify-center p-4">
                    <Transition
                        enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100 scale-100"
                        leave-to-class="opacity-0 scale-95"
                    >
                        <div
                            v-if="show"
                            :class="[
                                'relative w-full bg-gray-800 rounded-2xl shadow-2xl border border-gray-700',
                                modalSize
                            ]"
                        >
                            <!-- Header -->
                            <div v-if="title || closable" class="flex items-center justify-between p-6 border-b border-gray-700">
                                <h3 v-if="title" class="text-xl font-semibold text-white">
                                    {{ title }}
                                </h3>
                                <button
                                    v-if="closable"
                                    @click="closeModal"
                                    class="ml-auto p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-colors"
                                >
                                    <X :size="20" />
                                </button>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <slot></slot>
                            </div>
                            
                            <!-- Footer -->
                            <div v-if="$slots.footer" class="flex items-center justify-end gap-3 p-6 border-t border-gray-700">
                                <slot name="footer"></slot>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
/* Garantir que o modal fique no topo */
.z-50 {
    z-index: 50;
}
</style>

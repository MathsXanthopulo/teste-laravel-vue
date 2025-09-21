<template>
  <div 
    class="space-card"
    :class="[
      `space-card--${variant}`,
      { 'space-card--interactive': interactive }
    ]"
  >
    <!-- Header -->
    <div v-if="$slots.header || title" class="space-card__header">
      <slot name="header">
        <div class="space-card__title-section">
          <h3 v-if="title" class="space-card__title">{{ title }}</h3>
          <p v-if="subtitle" class="space-card__subtitle">{{ subtitle }}</p>
        </div>
        <div v-if="icon" class="space-card__icon">
          {{ icon }}
        </div>
      </slot>
    </div>

    <!-- Content -->
    <div class="space-card__content">
      <slot />
    </div>

    <!-- Footer -->
    <div v-if="$slots.footer" class="space-card__footer">
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: ''
  },
  subtitle: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    default: ''
  },
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'primary', 'success', 'warning', 'danger', 'info'].includes(value)
  },
  interactive: {
    type: Boolean,
    default: false
  }
})
</script>


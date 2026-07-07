<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  value: { type: Number, default: 0 },
  label: { type: String, default: '' },
  prefix: { type: String, default: '' },
  suffix: { type: String, default: '' },
  icon: { type: String, default: '' },
})

const displayValue = ref(0)
const animated = ref(false)
let observer = null
const el = ref(null)

onMounted(() => {
  observer = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting && !animated.value) {
      animated.value = true
      animateValue()
      observer.disconnect()
    }
  }, { threshold: 0.3 })
  if (el.value) observer.observe(el.value)
})

onUnmounted(() => {
  if (observer) observer.disconnect()
})

function animateValue() {
  const duration = 1500
  const steps = 30
  const increment = props.value / steps
  let current = 0
  const timer = setInterval(() => {
    current += increment
    if (current >= props.value) {
      displayValue.value = props.value
      clearInterval(timer)
    } else {
      displayValue.value = Math.floor(current)
    }
  }, duration / steps)
}
</script>

<template>
  <div ref="el" class="relative group bg-dark-900/60 border border-gold/20 rounded-2xl p-6 card-hover overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-gold/5 via-transparent to-blue-accent/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
    <div v-if="icon" class="text-2xl mb-2">{{ icon }}</div>
    <div class="text-3xl md:text-4xl font-extrabold text-gold mb-1 tracking-tight">
      {{ prefix }}<span class="tabular-nums">{{ displayValue }}</span>{{ suffix }}
    </div>
    <div class="text-text-muted text-sm font-medium">{{ label }}</div>
    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gold/40 via-gold/20 to-transparent scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left" />
  </div>
</template>

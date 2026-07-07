<script setup>
import { computed } from 'vue'
import WhatsAppButton from './WhatsAppButton.vue'

const props = defineProps({
  account: { type: Object, required: true },
})

const formattedPrice = computed(() =>
  new Intl.NumberFormat('id-ID', {
    style: 'currency', currency: 'IDR',
    minimumFractionDigits: 0, maximumFractionDigits: 0,
  }).format(props.account.price)
)
</script>

<template>
  <div class="group relative bg-dark-900/60 border border-gold/20 rounded-2xl p-5 card-hover overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-gold/3 via-transparent to-blue-accent/3 opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
    <div class="absolute -top-12 -right-12 w-32 h-32 bg-gold/5 rounded-full blur-2xl group-hover:bg-gold/10 transition-all duration-500" />

    <div class="relative space-y-4">
      <div class="flex items-start justify-between">
        <div>
          <div class="flex items-center gap-2 mb-1">
            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse" />
            <span class="text-xs text-green-400 font-medium uppercase tracking-wider">Tersedia</span>
          </div>
          <span class="text-gold font-mono font-bold text-xl tracking-wider">{{ account.unique_code }}</span>
          <p class="text-text-muted text-xs mt-0.5">{{ account.game?.name }}</p>
        </div>
      </div>

      <p v-if="account.description" class="text-text-muted text-sm line-clamp-2 leading-relaxed">
        {{ account.description }}
      </p>

      <div class="pt-4 border-t border-gold/10 flex items-center justify-between">
        <div>
          <span class="text-text-muted text-xs">Harga</span>
          <div class="text-xl font-extrabold text-white tracking-tight">{{ formattedPrice }}</div>
        </div>
        <WhatsAppButton :game-name="account.game?.name" :code="account.unique_code" />
      </div>
    </div>
  </div>
</template>

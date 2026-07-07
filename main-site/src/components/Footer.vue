<script setup>
const year = new Date().getFullYear()
</script>

<template>
  <footer class="relative border-t border-gold/10 bg-dark-950/80">
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gold/40 to-transparent" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-gold to-gold-dark flex items-center justify-center">
            <span class="text-dark-950 font-extrabold text-xs">JM</span>
          </div>
          <div>
            <span class="text-base font-bold text-gradient">Japran</span>
            <span class="text-base font-bold text-white">Market</span>
          </div>
        </div>

        <p class="text-text-muted/60 text-xs">
          &copy; {{ year }} Japran Market. All rights reserved.
        </p>
      </div>
    </div>
  </footer>
</template>

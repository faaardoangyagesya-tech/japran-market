<script setup>
const whatsappNumber = import.meta.env.VITE_WHATSAPP_NUMBER || '6281234567890'
</script>

<template>
  <div class="pt-28 pb-20 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gold/20 bg-gold/5 text-gold text-xs font-medium mb-4">
          Tentang Kami
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
          <span class="text-gradient">Japran Market</span>
        </h1>
        <p class="text-text-muted text-lg max-w-2xl mx-auto">
          Toko akun game terpercaya dengan ribuan pelanggan puas
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="group relative bg-dark-900/60 border border-gold/20 rounded-2xl p-7 card-hover overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-gold/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
          <div class="relative">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gold/20 to-gold/5 border border-gold/20 flex items-center justify-center text-xl mb-4">
              👋
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Siapa Kami?</h3>
            <p class="text-text-muted leading-relaxed">
              Japran Market adalah platform jual beli akun game yang aman dan terpercaya.
              Kami menyediakan berbagai akun game populer seperti Roblox, Minecraft,
              Free Fire, Mobile Legends, dan masih banyak lagi.
            </p>
          </div>
        </div>

        <div class="group relative bg-dark-900/60 border border-gold/20 rounded-2xl p-7 card-hover overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-gold/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
          <div class="relative">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gold/20 to-gold/5 border border-gold/20 flex items-center justify-center text-xl mb-4">
              ⭐
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Kenapa Pilih Kami?</h3>
            <ul class="space-y-3">
              <li v-for="item in ['Akun original dan aman', 'Harga terjangkau dan bersaing', 'Proses cepat via WhatsApp', 'Pelayanan ramah dan responsif']" :key="item" class="flex items-start gap-3 text-text-muted">
                <span class="w-5 h-5 rounded-full bg-gold/10 flex items-center justify-center shrink-0 mt-0.5">
                  <svg class="w-3 h-3 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                </span>
                {{ item }}
              </li>
            </ul>
          </div>
        </div>

        <div class="group relative bg-dark-900/60 border border-gold/20 rounded-2xl p-7 card-hover overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-gold/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
          <div class="relative">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gold/20 to-gold/5 border border-gold/20 flex items-center justify-center text-xl mb-4">
              📋
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Cara Order</h3>
            <div class="space-y-4">
              <div v-for="(step, i) in ['Pilih game yang kamu mau', 'Cari akun yang cocok', 'Klik tombol Beli', 'Kamu akan diarahkan ke WhatsApp', 'Konfirmasi pembelian dan selesai!']" :key="i" class="flex items-start gap-3">
                <span class="w-7 h-7 rounded-full bg-gradient-to-br from-gold to-gold-dark text-dark-950 font-bold text-xs flex items-center justify-center shrink-0">{{ i + 1 }}</span>
                <span class="text-text-muted pt-1">{{ step }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="group relative bg-dark-900/60 border border-gold/20 rounded-2xl p-7 card-hover overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br from-blue-accent/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
          <div class="relative">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-accent/20 to-blue-accent/5 border border-blue-accent/20 flex items-center justify-center text-xl mb-4">
              💬
            </div>
            <h3 class="text-xl font-bold text-white mb-3">Kontak</h3>
            <p class="text-text-muted mb-4 leading-relaxed">
              Untuk pertanyaan lebih lanjut, hubungi kami melalui WhatsApp:
            </p>
            <a
              :href="`https://wa.me/${whatsappNumber}`"
              target="_blank"
              class="inline-flex items-center gap-2 bg-gradient-to-r from-gold to-gold-dark text-dark-950 font-bold px-5 py-2.5 rounded-xl hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg shadow-gold/20"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              Hubungi Kami
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

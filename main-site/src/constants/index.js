export const WHATSAPP_NUMBER = import.meta.env.VITE_WHATSAPP_NUMBER || '6281234567890'

export function getWhatsAppUrl(gameName, accountCode) {
  const text = encodeURIComponent(`Bang mau beli akun ${gameName} ${accountCode}`)
  return `https://wa.me/${WHATSAPP_NUMBER}?text=${text}`
}

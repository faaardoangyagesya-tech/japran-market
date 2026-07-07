<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const canvasRef = ref(null)
let animationId = null

class Particle {
  constructor(w, h) {
    this.reset(w, h)
  }
  reset(w, h) {
    this.x = Math.random() * w
    this.y = Math.random() * h
    this.size = Math.random() * 2.5 + 0.3
    this.speedX = (Math.random() - 0.5) * 0.2
    this.speedY = (Math.random() - 0.5) * 0.2
    this.opacity = Math.random() * 0.4 + 0.05
    this.type = Math.random()
    this.isGold = this.type > 0.4
    this.pulse = Math.random() * Math.PI * 2
    this.pulseSpeed = 0.01 + Math.random() * 0.02
  }
  update(w, h) {
    this.x += this.speedX
    this.y += this.speedY
    if (this.x < 0 || this.x > w) this.speedX *= -1
    if (this.y < 0 || this.y > h) this.speedY *= -1
    this.pulse += this.pulseSpeed
  }
  draw(ctx) {
    const pulseOpacity = this.opacity * (0.8 + 0.2 * Math.sin(this.pulse))
    ctx.beginPath()
    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2)
    ctx.fillStyle = this.isGold
      ? `rgba(245, 158, 11, ${pulseOpacity})`
      : `rgba(29, 78, 216, ${pulseOpacity})`
    ctx.fill()
  }
}

onMounted(() => {
  const canvas = canvasRef.value
  if (!canvas) return
  const ctx = canvas.getContext('2d')
  let particles = []
  let mouseX = -1000, mouseY = -1000

  function resize() {
    canvas.width = window.innerWidth
    canvas.height = window.innerHeight
  }

  function init() {
    resize()
    const count = Math.min(Math.floor((canvas.width * canvas.height) / 18000), 60)
    particles = Array.from({ length: count }, () => new Particle(canvas.width, canvas.height))
  }

  function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height)
    for (let i = 0; i < particles.length; i++) {
      particles[i].update(canvas.width, canvas.height)
      particles[i].draw(ctx)
      const dx = mouseX - particles[i].x
      const dy = mouseY - particles[i].y
      const dist = Math.sqrt(dx * dx + dy * dy)
      if (dist < 120) {
        ctx.beginPath()
        ctx.moveTo(particles[i].x, particles[i].y)
        ctx.lineTo(mouseX, mouseY)
        ctx.strokeStyle = `rgba(245, 158, 11, ${0.08 * (1 - dist / 120)})`
        ctx.lineWidth = 0.5
        ctx.stroke()
      }
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x
        const dy = particles[i].y - particles[j].y
        const dist = Math.sqrt(dx * dx + dy * dy)
        if (dist < 100) {
          ctx.beginPath()
          ctx.moveTo(particles[i].x, particles[i].y)
          ctx.lineTo(particles[j].x, particles[j].y)
          ctx.strokeStyle = `rgba(245, 158, 11, ${0.04 * (1 - dist / 100)})`
          ctx.lineWidth = 0.3
          ctx.stroke()
        }
      }
    }
    animationId = requestAnimationFrame(animate)
  }

  function handleMouse(e) { mouseX = e.clientX; mouseY = e.clientY }
  function handleMouseLeave() { mouseX = -1000; mouseY = -1000 }

  init()
  animate()
  window.addEventListener('resize', resize)
  window.addEventListener('mousemove', handleMouse)
  window.addEventListener('mouseleave', handleMouseLeave)

  onUnmounted(() => {
    cancelAnimationFrame(animationId)
    window.removeEventListener('resize', resize)
    window.removeEventListener('mousemove', handleMouse)
    window.removeEventListener('mouseleave', handleMouseLeave)
  })
})
</script>

<template>
  <canvas ref="canvasRef" class="fixed inset-0 pointer-events-none z-0" />
</template>

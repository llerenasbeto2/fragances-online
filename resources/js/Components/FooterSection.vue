<script setup>
import gmailIcon from '@/Components/icons/gmail.vue'
import whatsappIcon from '@/Components/icons/whatsapp.vue'
import instagramIcon from '@/Components/icons/instagram.vue'
import facebookIcon from '@/Components/icons/facebook.vue'
</script>
<template>
    <footer class="bg-neutral-800 dark:bg-neutral-800 text-white py-8 border-t-4 border-amber-500">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center">
                <div class="flex gap-3">
                    <div class="w-8 h-8  rounded-none"><a href=""><gmailIcon></gmailIcon></a></div>
                    <div class="w-8 h-8  rounded-none"><a href=""><whatsappIcon></whatsappIcon></a></div>
                    <div class="w-8 h-8  rounded-none"><a href=""><instagramIcon></instagramIcon></a></div>
                    <div class="w-8 h-8  rounded-none"><a href=""><facebookIcon></facebookIcon></a></div>
            
                </div>
                <div class="flex flex-col gap-2 items-end">
                    
                    <p class="font-medium text-amber-100">Royal Aromas Perfumes</p>
                    <p class="text-xs sm:text-right">Av. de la Realeza 123, Palacio de Oro</p>
                    <p class="text-xs">contacto@royalaromas.com</p>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
</script>
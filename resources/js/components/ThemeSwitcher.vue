<template>
    <div class="mr-10">
        <button
        :class="{'border-teal-400' : selectedTheme = 'theme-light'}" 
        class="rounded-full w-4 h-4 bg-default border mr-2 focus : outline-none" 
        style="background:#f5f6f9" 
        @click="selectedTheme = 'theme-light'"></button>

        <button 
        :class="{'border-teal-400' : selectedTheme = 'theme-dark'}"
        class="rounded-full w-4 h-4 bg-default border mr-2 focus : outline-none" 
        style="background:#222" 
        @click="selectedTheme = 'theme-dark'"></button>
    </div>
</template>

<script>
    export default {
        data () {
            return {
            selectedTheme : 'theme-light'
            }
        },
        mounted () {
            this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
        },
        watch : {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);

                localStorage.setItem('theme' , this.selectedTheme);
            }
        }
    }
</script>

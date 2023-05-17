<template>
    <div >
        <!-- welcome home -->
    </div>
</template>

<script>
    export default {
        data(){
            return {
                token: localStorage.getItem('token'),
                userEmail: '',
            }
        },

        created(){
            this.$router.push(`/polls`);
        }
    }
</script>

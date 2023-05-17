<template>
    <div >
        error <br>
        not found
    </div>
</template>

<script>
    export default {
        data(){
            return {
                token: localStorage.getItem('token'),
                userEmail: '',
            }
        }
    }
</script>

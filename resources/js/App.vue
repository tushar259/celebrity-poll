<template>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="width: 100% !important">
        <a class="navbar-brand" href="#">Home Image</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" @click="collapse = !collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse" :class="{'collapse': collapse}" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <router-link class="nav-link" to="#">Home <span class="sr-only">(current)</span></router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="#">Features</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="#">Pricing</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link disabled" to="#">Disabled</router-link>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: 'App',
    data() {
        return{
            collapse: true,
        }
    },

}
</script>

<style lang="scss">
</style>

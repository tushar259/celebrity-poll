<template>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="width: 100% !important">
        <a class="navbar-brand" href="#">Home Image</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" @click="collapse = !collapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" :class="{'show': collapse}" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <router-link class="nav-link" to="#">Home <span class="sr-only">(current)</span></router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="#">Features</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="#" title="Pricing">Pricing</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link disabled" to="#">Disabled</router-link>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto" :class="{'d-none': foundLoggedinUser}"> <!-- d-none -->
                <li class="nav-item">
                    <router-link class="nav-link" to="" @click="loginClicked()">Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="" @click="registrationClicked()">Registration</router-link>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto" :class="{'d-none': !foundLoggedinUser}">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-truncate" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :title="userEmail">
                        {{userEmail}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" to="#">Change password</router-link>
                        <!-- <a class="dropdown-item" href="#">Option 2</a>
                        <a class="dropdown-item" href="#">Option 3</a> -->
                        <div class="dropdown-divider"></div>
                        <router-link  class="dropdown-item" to="" @click="logoutClicked()">Logout</router-link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        <router-view @class-changed="updateSpecificDivClass"/>
    </div>
</template>

<script>
export default {
    name: 'App',
    data() {
        return{
            collapse: false,
            foundLoggedinUser: false,
            userEmail: '',
            token: localStorage.getItem('token'),
            currentPage: '',
        }
    },

    created(){
        
        // console.log("window.location.href: "+window.location.href); // current URL
        // console.log("window.location.pathname: "+window.location.pathname); // path of the current URL
        // console.log("window.location.hash: "+window.location.hash); // anchor part of the current URL
        // console.log("window.location.search: "+window.location.search); // query string part of the current URL
        this.checkIfUserLoggedin();
    },

    methods:{
        updateSpecificDivClass(usersEmailFromComponent){
            console.log("ifUser: "+usersEmailFromComponent);
            if(usersEmailFromComponent != ""){
                this.userEmail = usersEmailFromComponent;
                this.foundLoggedinUser = true;
            }
            else{
                this.userEmail = null;
                this.foundLoggedinUser = false;
            }
        },

        checkIfUserLoggedin(){
            const formData = new FormData();
            formData.append("token", this.token);
            if(localStorage.getItem('token')){
                axios.post('/api/auth/check-if-user-logged-in', {
                    // other data you want to send
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                })
                .then(response =>{
                    console.log(response.data);
                    if(response.data.success == true && response.data.message == "User logged in"){
                        this.foundLoggedinUser = true;
                        this.userEmail = response.data.userInfoFromTk.email;
                        // this.userId = response.data.userInfoFromTk.id;
                    }
                    else{
                        this.foundLoggedinUser = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                    this.foundLoggedinUser = false;
                });
            }
            else{
                //no token means no user logged in
                console.log("no token in storage");
            }
        },

        logoutClicked(){
            // localStorage.setItem('logout', 'clicked');
            this.currentPage = window.location.pathname;
            console.log("what is currentpage: "+this.currentPage);
            localStorage.removeItem('token');
            this.userEmail = null;
            this.foundLoggedinUser = false;
            this.$router.push(this.currentPage);
        },

        loginClicked(){
            this.currentPage = window.location.pathname;
            if(this.currentPage == "/login" || this.currentPage == "/create-account" || this.currentPage == "/forgot-password"){
                this.currentPage = "/";
            }
            localStorage.setItem('load-page', this.currentPage);
            this.$router.push("/login");
        },

        registrationClicked(){
            this.currentPage = window.location.pathname;
            if(this.currentPage == "/login" || this.currentPage == "/create-account" || this.currentPage == "/forgot-password"){
                this.currentPage = "/";
            }
            localStorage.setItem('load-page', this.currentPage);
            this.$router.push("/create-account");
        }
    }
    

}
</script>

<style lang="scss">
</style>

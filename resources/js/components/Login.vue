<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4 font-weight-bold">Login</h2>
                
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" v-model="email" @keyup.enter="loginNow()" placeholder="Enter email">
                    <small v-html="emailMessage"></small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" v-model="password" @keyup.enter="loginNow()" placeholder="Enter password">
                    <small v-html="passwordMessage"></small>
                </div>
                <div class="form-group text-right">
                    <router-link to="/change-password" class="forgot-password-link">Forgot password?</router-link>
                </div>
                <!-- <div class="px-15-gap"></div> -->
                <small v-html="submitFormMessage"></small>
                <button class="btn btn-primary btn-block" @click="loginNow()" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ isLoading ? 'Logging in...' : 'Login' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { useToast } from 'vue-toastification';
    const toast = useToast();
    export default {
        data() {
            return {
                email: '',
                password: '',
                token: localStorage.getItem('token'),
                userEmail: '',
                userId: '',
                emailMessage: '',
                passwordMessage: '',
                submitFormMessage: '',
                isLoading: false,
            }
        },

        created(){
            // console.log(this.token);
            // localStorage.removeItem('token');
            this.checkIfUserLoggedin();
        },

        methods: {
            loginNow(){
                // toast.success('Hello, Vue Toast!');
                this.isLoading = true;
                this.emailMessage = "";
                this.passwordMessage = "";
                this.submitFormMessage = "";
                if(this.email == "" || this.password == ""){
                    if(this.email == ""){
                        this.emailMessage = "<span style='color:red;'>Please enter email address.</span>"
                    }
                    if(this.password == ""){
                        this.passwordMessage = "<span style='color:red;'>Please enter password.</span>"
                    }
                    this.isLoading = false;
                }
                else{
                    const formData = new FormData();
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    axios.post('/api/auth/login', formData)
                    .then(response => {
                        // console.log(response.data);
                        if(response.data.success == true){
                            localStorage.setItem('token', response.data.token);
                            this.email = "";
                            this.password = "";
                            this.userEmail = response.data.userEmail;
                            this.isLoading = false;
                            this.$emit('class-changed', this.userEmail);
                            if(localStorage.getItem('load-page') && localStorage.getItem('load-page').length > 0){
                                this.$router.push(localStorage.getItem('load-page'));
                            }
                            else{
                                this.$router.push(`/`);
                            }
                        }
                        else if(response.data.success == false){
                            toast.error('Email or password did not match!');
                            // this.submitFormMessage = "<span style='color:red;'>Email or password did not match.</span>"
                            this.isLoading = false;
                        }
                    })
                    .catch(error => {
                        // console.log(error);
                        if(error.response.data.errors.email){
                            this.emailMessage = "<span style='color:red;'>"+error.response.data.errors.email[0]+"</span>";
                        }
                        if(error.response.data.errors.password){
                            this.passwordMessage = "<span style='color:red;'>"+error.response.data.errors.password[0]+"</span>";
                        }
                        this.isLoading = false;
                    });
                    // this.isLoading = false;
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
                            this.userEmail = response.data.userInfoFromTk.email;
                            this.$router.push(`/`);
                            // this.userId = response.data.userInfoFromTk.id;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
                else{
                    //no token means no user logged in
                    console.log("no token in storage");
                }
            }
        }
    }
</script>

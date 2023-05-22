<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4 font-weight-bold">Create Account</h2>
                
                <div class="form-group">
                    <label for="email">Email address*</label>
                    <input type="email" class="form-control" id="email" v-model="email" @keyup.enter="createAccount()" @blur="checkIfEmailExist()" placeholder="Email">
                    <small v-html="emailMessage"></small>
                </div>
                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" class="form-control" id="password" v-model="password" @keyup.enter="createAccount()" placeholder="Password">
                    <small v-html="passwordMessage"></small>
                </div>
                <div class="form-group">
                    <label for="question">Password Recovery Question*</label>
                    <select class="form-control" id="question" v-model="selectedQuestion">
                        <option value="">Select a question</option>
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What is the name of your favorite pet?">What is the name of your favorite pet?</option>
                        <option value="In which city were you born?">In which city were you born?</option>
                        <option value="What is your favorite movie?">What is your favorite movie?</option>
                        <option value="What is the name of your elementary school?">What is the name of your elementary school?</option>
                        <option value="What is your favorite book?">What is your favorite book?</option>
                        <option value="What is the model of your first car?">What is the model of your first car?</option>
                        <option value="What is your favorite food?">What is your favorite food?</option>
                        <option value="What is the name of your best friend?">What is the name of your best friend?</option>
                        <option value="What is your favorite vacation destination?">What is your favorite vacation destination?</option>
                    </select>
                    <small>*Your selected question will be asked if you forget password*</small>
                    <div class="px-5-gap"></div>
                    <small v-html="recoveryQueMessage"></small>
                </div>
                <div class="form-group">
                    <label for="answer">Password Recovery Answer*</label>
                    <input class="form-control" id="answer" v-model="selectedAnswer" @keyup.enter="createAccount()" placeholder="Answer">
                    <small>*Remember your answer to recover your password*</small>
                    <div class="px-5-gap"></div>
                    <small v-html="recoveryAnsMessage"></small>
                </div>
                <!-- <input type="checkbox"> <small style="margin-bottom: 5px;">I accept <a href="">terms and conditions</a></small> -->
                <small style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" style="vertical-align: middle;" v-model="isChecked">
                    <span style="margin-left: 5px;">I accept <router-link to="/terms-and-conditions" target="_blank">terms and conditions</router-link></span>
                </small>
                <div class="px-5-gap"></div>
                <small v-html="termsNconditionsMessage"></small>
                <div class="px-15-gap"></div>
                <!-- <button class="btn btn-primary btn-block" @click="createAccount()">Create Account</button> -->
                <div class="d-flex">
                <!-- <h4 v-html="submitFormMessage"></h4> -->
                    <span :class="{'visually-hidden': uploadLoading}">Please Wait..</span>
                    <div class="spinner-border text-primary" :class="{'visually-hidden': uploadLoading}" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <button class="btn btn-primary btn-block" @click="createAccount()" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ isLoading ? 'Creating account...' : 'Create account' }}
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
                emailMessage: '',
                passwordMessage: '',
                recoveryQueMessage: '',
                recoveryAnsMessage: '',
                termsNconditionsMessage: '',
                checkIfEmailUsed: false,
                checkIfEmailValid: "",
                password: '',
                selectedQuestion: '',
                selectedAnswer: '',
                isChecked: false,
                isLoading: false,
                submitFormMessage: '',
                uploadLoading: true,
                userEmail: '',
                token: localStorage.getItem('token'),
            }
        },

        created(){
            // this.submitFormMessage = "<span style='color:green;'>Account created.</span>";
            this.checkIfUserLoggedin();
        },

        methods: {

            checkIfEmailExist(){
                this.emailMessage = "";
                this.checkIfEmailUsed = false;
                this.checkIfEmailValid = "";
                if(this.email == ""){
                    this.emailMessage = "<span style='color:red;'>Email cannot be empty.</span>";
                }
                else{
                    const formData = new FormData();
                    formData.append("email", this.email);
                    axios.post('/api/check-if-email-exist-creating-account', formData)
                    .then(response =>{
                        if(response.data.success == true){
                            this.checkIfEmailUsed = true;
                            this.emailMessage = "<span style='color:red;'>"+response.data.message+"</span>";
                        }
                        console.log(response.data);
                    })
                    .catch(error =>{
                        console.log(error);
                        if(error.response.data.errors.email[0]){
                            this.emailMessage = "<span style='color:red;'>"+error.response.data.errors.email[0]+"</span>";
                            this.checkIfEmailValid = error.response.data.errors.email[0];
                        }
                    });
                }
            },

            createAccount(){
                this.isLoading = true;
                this.uploadLoading = true;
                this.emailMessage = "";
                this.emailMessage = "";
                this.passwordMessage = "";
                this.recoveryQueMessage = "";
                this.recoveryAnsMessage = "";
                this.termsNconditionsMessage = "";
                if(this.email == "" || this.password == "" || this.password.length < 5 || this.selectedQuestion == "" || this.selectedAnswer == "" || this.isChecked == false || this.checkIfEmailUsed == true || this.checkIfEmailValid != ""){
                    if(this.email == ""){
                        this.emailMessage = "<span style='color:red;'>Email cannot be empty.</span>";
                    }
                    if(this.password == ""){
                        this.passwordMessage = "<span style='color:red;'>Password cannot be empty.</span>";
                    }
                    if(this.selectedQuestion == ""){
                        this.recoveryQueMessage = "<span style='color:red;'>Please select a question.</span>";
                    }
                    if(this.selectedAnswer == ""){
                        this.recoveryAnsMessage = "<span style='color:red;'>Please write your answer.</span>";
                    }
                    if(this.isChecked == false){
                        this.termsNconditionsMessage = "<span style='color:red;'>Please select terms and conditions.</span>";
                    }
                    if(this.checkIfEmailUsed == true){
                        this.emailMessage = "<span style='color:red;'>Email used already.</span>";
                    }
                    if(this.checkIfEmailValid != ""){
                        this.emailMessage = "<span style='color:red;'>"+this.checkIfEmailValid+"</span>";
                    }
                    if(this.password.length < 5){
                        this.passwordMessage = "<span style='color:red;'>At least 5 characters need to be used.</span>";
                    }
                    this.isLoading = false;
                }
                else{
                    const formData = new FormData();
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    formData.append('selectedQuestion', this.selectedQuestion);
                    formData.append('selectedAnswer', this.selectedAnswer);
                    formData.append('isChecked', this.isChecked);
                    axios.post('/api/auth/create-account', formData)
                    .then(response => {
                        if(response.data.success == true){
                            toast.success(response.data.message);
                            // this.submitFormMessage = "<span style='color:green;'>"+response.data.message+" Please wait..</span>";
                            this.uploadLoading = false;
                            this.loginNow();
                        }
                        else{
                            toast.error(response.data.message);
                            // this.submitFormMessage = "<span style='color:red;'>"+response.data.message+"</span>";
                            this.isLoading = false;
                        }
                        
                        console.log(response.data);
                    })
                    .catch(error => {
                        toast.error("Something went wrong");
                        // this.submitFormMessage = "<span style='color:red;'>Something went wrong</span>";
                        this.isLoading = false;
                    });
                }
            },

            loginNow(){
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
                            this.userEmail = response.data.userEmail;
                            this.email = "";
                            this.password = "";
                            this.selectedQuestion = "";
                            this.selectedAnswer = "";
                            this.isChecked = "";
                            this.$emit('class-changed', this.userEmail);
                            setTimeout(() => {
                                this.isLoading = false;
                                this.uploadLoading = true;
                                if(localStorage.getItem('load-page') && localStorage.getItem('load-page').length > 0){
                                    this.$router.push(localStorage.getItem('load-page'));
                                }
                                else{
                                    this.$router.push(`/`);
                                }
                            }, 2000);
                        }
                        else if(response.data.success == false){
                            toast.error("Email or password did not match.");
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

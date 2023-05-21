<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4 font-weight-bold">Change password</h2>
                
                <div v-if="emailFound == 'second phase'">
                    <div class="form-group">
                        Email: <b>{{email}}</b>
                    </div>
                    {{passwordRecoveryQuestion}}
                    <div class="form-group">
                        <input class="form-control" id="answer" v-model="selectedAnswer" @keyup.enter="recoverPasswordSecondTime()" placeholder="Answer">
                    </div>
                    <!-- <small v-html="submitFormMessage"></small> -->
                    <button class="btn btn-primary btn-block" @click="recoverPasswordSecondTime()" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Loading...' : 'Submit' }}
                    </button>
                </div>
                <div v-else-if="emailFound == 'third phase'">
                    <div class="form-group">
                        <label for="password">New password (at least 5 or at most 20 characters)</label>
                        <input type="password" class="form-control" v-model="changePassword" @keyup.enter="recoverPasswordFinalStep()" placeholder="Password">
                        <small v-html="changePasswordMessage"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm password</label>
                        <input type="password" class="form-control" v-model="confirmPassword" @keyup.enter="recoverPasswordFinalStep()" placeholder="Password">
                        <small v-html="confirmPasswordMessage"></small>
                    </div>
                    <!-- <small v-html="submitFormMessage"></small> -->
                    <button class="btn btn-primary btn-block" @click="recoverPasswordFinalStep()" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Loading...' : 'Change password' }}
                    </button>
                </div>
                <div v-else>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" v-model="email" @keyup.enter="recoverPassword()" placeholder="Email">
                        <small v-html="emailMessage"></small>
                    </div>
                    <!-- <small v-html="submitFormMessage"></small> -->
                    <button class="btn btn-primary btn-block" @click="recoverPassword()" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Loading...' : 'Recover password' }}
                    </button>
                </div>
                
                
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
                userIdFromDatabase: '',
                email: '',
                emailMessage: '',
                submitFormMessage: '',
                isLoading: false,
                emailFound: "first phase",
                selectedAnswer: '',
                passwordRecoveryQuestion: '',
                passwordRecoveryAnswer: '',
                changePassword: '',
                confirmPassword: '',
                changePasswordMessage: '',
                confirmPasswordMessage: '',
                token: localStorage.getItem('token'),
                userEmail: '',
            }
        },

        created(){
            this.checkIfUserLoggedin();
        },

        methods: {
            recoverPassword(){
                this.isLoading = true;
                this.emailMessage = "";
                // this.submitFormMessage = "";
                if(this.email == ""){
                    this.emailMessage = "<span style='color:red;'>Please enter your email.</span>";
                    this.isLoading = false;
                }
                else{
                    const formData = new FormData();
                    formData.append("email", this.email);
                    axios.post('/api/check-if-email-exist', formData)
                    .then(response =>{
                        if(response.data.success == true){
                            this.emailFound = "second phase";
                            this.userIdFromDatabase = response.data.you_can_find_question_and_ans_here.id;
                            this.passwordRecoveryQuestion = response.data.you_can_find_question_and_ans_here.password_recovery_ques;
                            this.passwordRecoveryAnswer = response.data.you_can_find_question_and_ans_here.password_recovery_ans;
                            this.isLoading = false;
                        }
                        else if(response.data.success == false){
                            this.emailFound = "first phase";
                            toast.error(response.data.message);
                            // this.submitFormMessage = "<span style='color:red;'>"+response.data.message+"</span>";
                            this.isLoading = false;
                        }
                        console.log(response.data);
                    })
                    .catch(error => {
                        toast.error("Something went wrong!");
                        // this.submitFormMessage = "<span style='color:red;'>Something went wrong!</span>";
                        this.isLoading = false;
                    });
                }
            },

            recoverPasswordSecondTime(){
                this.isLoading = true;
                // this.submitFormMessage = "";
                if(this.passwordRecoveryAnswer == this.selectedAnswer){
                    this.emailFound = "third phase";
                    this.isLoading = false;
                }
                else{
                    toast.error("Answer did not match!");
                    // this.submitFormMessage = "<span style='color:red;'>Answer did not match!</span>";
                    // setTimeout(() => {
                    // 	this.submitFormMessage = '';
                    // }, 2000);
                    this.isLoading = false;
                }
            },

            recoverPasswordFinalStep(){
                this.isLoading = true;
                // this.submitFormMessage = "";
                this.changePasswordMessage = "";
                this.confirmPasswordMessage = "";
                console.log(this.changePassword.length);
                if(this.changePassword == "" || this.confirmPassword == "" || this.changePassword.length < 5 || this.changePassword.length > 20){
                    if(this.changePassword == ""){
                        this.changePasswordMessage = "<span style='color:red;'>Password cannot be empty.</span>";
                    }
                    if(this.confirmPassword == ""){
                        this.confirmPasswordMessage = "<span style='color:red;'>Password cannot be empty.</span>";
                    }
                    if(this.changePassword.length < 5){
                        this.changePasswordMessage = "<span style='color:red;'>At least 5 characters need to be used.</span>";
                    }
                    if(this.changePassword.length > 20){
                        this.changePasswordMessage = "<span style='color:red;'>At most 20 characters can be used.</span>";
                    }
                    this.isLoading = false;
                }
                else{
                    if(this.changePassword !== this.confirmPassword){
                        toast.error("Password did not match.");
                        // this.submitFormMessage = "<span style='color:red;'>Password did not match.</span>";
                        this.isLoading = false;
                    }
                    else{
                        if(this.email == "" || this.userIdFromDatabase == ""){
                            toast.error("Something went wrong, please reload and try again.");
                            // this.submitFormMessage = "<span style='color:red;'>Something went wrong, please reload and try again.</span>";
                            this.isLoading = false;
                        }
                        else{
                            const formData = new FormData();
                            formData.append("email", this.email);
                            formData.append("userId", this.userIdFromDatabase);
                            formData.append("newPassword", this.changePassword);
                            axios.post('/api/change-password-now',formData)
                            .then(response =>{
                                if(response.data.success == true){
                                    toast.success(response.data.message);
                                    // this.submitFormMessage = "<span style='color:green;'>"+response.data.message+"</span>";
                                    this.email = "";
                                    this.userIdFromDatabase = "";
                                    this.changePassword == ""; 
                                    this.confirmPassword == "";
                                    
                                    // setTimeout(() => {
                                        // this.submitFormMessage = '';
                                    this.$router.push(`/login`);
                                    // }, 1000);
                                    this.isLoading = false;
                                }
                                else{
                                    toast.error(response.data.message);
                                    // this.submitFormMessage = response.data.message;
                                    this.isLoading = false;
                                }
                                
                            })
                            .catch(error => {
                                this.isLoading = false;
                                toast.error("Something went wrong, please reload and try again.");
                                // this.submitFormMessage = "<span style='color:red;'>Something went wrong, please reload and try again.</span>";
                            });
                        }
                    }
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
                            this.emailFound = "second phase";
                            this.userEmail = response.data.userInfoFromTk.email;
                            this.email = this.userEmail;
                            this.userIdFromDatabase = response.data.userInfoFromTk.id;
                            this.passwordRecoveryQuestion = response.data.userInfoFromTk.password_recovery_ques;
                            this.passwordRecoveryAnswer = response.data.userInfoFromTk.password_recovery_ans;
                            // this.$router.push(`/`);
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

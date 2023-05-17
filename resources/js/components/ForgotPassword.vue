<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Recover password</h2>
                
                <div v-if="emailFound == 'second phase'">
                    <div class="form-group">
                        Email: <b>{{email}}</b>
                    </div>
                    {{passwordRecoveryQuestion}}
                    <div class="form-group">
                        <input class="form-control" id="answer" v-model="selectedAnswer" @keyup.enter="recoverPasswordSecondTime()" placeholder="Enter answer">
                    </div>
                    <small v-html="submitFormMessage"></small>
                    <button class="btn btn-primary btn-block" @click="recoverPasswordSecondTime()" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Loading...' : 'Recover password' }}
                    </button>
                </div>
                <div v-else-if="emailFound == 'third phase'">
                    <div class="form-group">
                        <label for="password">New password</label>
                        <input type="password" class="form-control" v-model="changePassword" @keyup.enter="recoverPasswordFinalStep()" placeholder="Password">
                        <small v-html="changePasswordMessage"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm password</label>
                        <input type="password" class="form-control" v-model="confirmPassword" @keyup.enter="recoverPasswordFinalStep()" placeholder="Password">
                        <small v-html="confirmPasswordMessage"></small>
                    </div>
                    <small v-html="submitFormMessage"></small>
                    <button class="btn btn-primary btn-block" @click="recoverPasswordFinalStep()" :disabled="isLoading">
                        <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Loading...' : 'Change password' }}
                    </button>
                </div>
                <div v-else>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" v-model="email" @keyup.enter="recoverPassword()" placeholder="Enter email">
                        <small v-html="emailMessage"></small>
                    </div>
                    <small v-html="submitFormMessage"></small>
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

        methods: {
            recoverPassword(){
                this.isLoading = true;
                this.emailMessage = "";
                this.submitFormMessage = "";
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
                            this.submitFormMessage = "<span style='color:red;'>"+response.data.message+"</span>";
                            this.isLoading = false;
                        }
                        console.log(response.data);
                    })
                    .catch(error => {
                        this.submitFormMessage = "<span style='color:red;'>Something went wrong!</span>";
                        this.isLoading = false;
                    });
                }
            },

            recoverPasswordSecondTime(){
                this.isLoading = true;
                this.submitFormMessage = "";
                if(this.passwordRecoveryAnswer == this.selectedAnswer){
                    this.emailFound = "third phase";
                    this.isLoading = false;
                }
                else{
                    this.submitFormMessage = "<span style='color:red;'>Answer did not match!</span>";
                    setTimeout(() => {
                    	this.submitFormMessage = '';
                    }, 2000);
                    this.isLoading = false;
                }
            },

            recoverPasswordFinalStep(){
                this.isLoading = true;
                this.submitFormMessage = "";
                this.changePasswordMessage = "";
                this.confirmPasswordMessage = "";
                if(this.changePassword == "" || this.confirmPassword == ""){
                    if(this.changePassword == ""){
                        this.changePasswordMessage = "<span style='color:red;'>Password cannot be empty.</span>";
                    }
                    if(this.confirmPassword == ""){
                        this.confirmPasswordMessage = "<span style='color:red;'>Password cannot be empty.</span>";
                    }
                    this.isLoading = false;
                }
                else{
                    if(this.changePassword !== this.confirmPassword){
                        this.submitFormMessage = "<span style='color:red;'>Password did not match.</span>";
                        this.isLoading = false;
                    }
                    else{
                        if(this.email == "" || this.userIdFromDatabase == ""){
                            this.submitFormMessage = "<span style='color:red;'>Something went wrong, please reload and try again.</span>";
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
                                    this.submitFormMessage = "<span style='color:green;'>"+response.data.message+"</span>";
                                    this.email = "";
                                    this.userIdFromDatabase = "";
                                    this.changePassword == ""; 
                                    this.confirmPassword == "";
                                    this.isLoading = false;
                                    setTimeout(() => {
                                        this.submitFormMessage = '';
                                        this.$router.push(`/login`);
                                    }, 2000);
                                    
                                }
                                else{
                                    this.submitFormMessage = response.data.message;
                                    this.isLoading = false;
                                }
                                
                            })
                            .catch(error => {
                                this.isLoading = false;
                                this.submitFormMessage = "<span style='color:red;'>Something went wrong, please reload and try again.</span>";
                            });
                        }
                    }
                }
            }
        }
    }
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Create Account</h2>
                
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" v-model="password" placeholder="Enter password">
                </div>
                <div class="form-group">
                    <label for="question">Password Recovery Question*</label>
                    <select class="form-control" id="question" v-model="selectedQuestion">
                        <option value="">Select a question</option>
                        <option value="question1">Question 1</option>
                        <option value="question2">Question 2</option>
                        <option value="question3">Question 3</option>
                    </select>
                    <small>*Your selected question will be asked if you forget password*</small>
                </div>
                <div class="form-group">
                    <label for="answer">Password Recovery Answer</label>
                    <input class="form-control" id="answer" v-model="selectedAnswer" placeholder="Enter answer">
                    <small>*Remember your answer to recover your password*</small>
                </div>
                <!-- <input type="checkbox"> <small style="margin-bottom: 5px;">I accept <a href="">terms and conditions</a></small> -->
                <small style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" style="vertical-align: middle;" v-model="isChecked">
                    <span style="margin-left: 5px;">I accept <a href="#">terms and conditions</a></span>
                </small>
                <div class="px-15-gap"></div>
                <button class="btn btn-primary btn-block" @click="createAccount()">Create Account</button>
            
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: '',
                password: '',
                selectedQuestion: '',
                selectedAnswer: '',
                isChecked: false,
            }
        },

        methods: {
            createAccount(){
                if(this.email == "" || this.password == "" || this.selectedQuestion == "" || this.selectedAnswer == "" || this.isChecked == false){

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
                        console.log(response.data);
                    })
                    .catch(error => {

                    });
                }
            }
        }
    }
</script>

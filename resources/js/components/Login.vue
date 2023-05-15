<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login</h2>
                
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" v-model="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" v-model="password" placeholder="Enter password">
                </div>
                
                <div class="px-15-gap"></div>
                <button class="btn btn-primary btn-block" @click="loginNow()">Login</button>
            
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
                token: localStorage.getItem('token'),
                userEmail: '',
            }
        },

        created(){
            // console.log(this.token);
            this.checkIfUserLoggedin();
        },

        methods: {
            loginNow(){
                if(this.email == "" || this.password == ""){

                }
                else{
                    const formData = new FormData();
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    axios.post('/api/auth/login', formData)
                    .then(response => {
                        localStorage.setItem('token', response.data.token);
                        this.userEmail = response.data.userEmail;
                    })
                    .catch(error => {

                    });
                }
            },

            checkIfUserLoggedin(){
                const formData = new FormData();
                formData.append("token", this.token);
                axios.post('/api/auth/check-if-user-logged-in', {
                    // other data you want to send
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                })
                .then(response =>{
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
